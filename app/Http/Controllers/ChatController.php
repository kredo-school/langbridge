<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    // チャット画面表示
    public function index(Request $request)
    {
        // 対話相手一覧を取得（例: 全ユーザー）
        $users = User::where('id', '!=', auth()->id())->get();
        $to_user_id = $request->input('to_user_id');
        return view('chat.index', compact('users', 'to_user_id'));
    }

    // メッセージ送信
    public function send(Request $request)
    {
        // いずれかが入力されているかチェック
        if (
            !$request->filled('content') &&
            !$request->filled('emoji') &&
            !$request->hasFile('image')
        ) {
            return response()->json(['error' => 'メッセージ、絵文字、または画像のいずれかを入力してください'], 422);
        }

        // to_user_idが空の場合はエラー
        $to_user_id = $request->input('to_user_id');
        if (empty($to_user_id)) {
            return response()->json(['error' => '相手ユーザーが選択されていません'], 422);
        }

        $message = new Message();
        $message->user_id = auth()->id();
        $message->to_user_id = $to_user_id;
        $message->content = $request->input('content');
        $message->emoji = $request->input('emoji');
        $message->sent_at = now();
        $message->is_read = false;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('assets/chat_images', 'public');
            $message->image_path = '/storage/' . $path;
        }

        $message->save();
        return response()->json(['message' => $message]);
    }


    // メッセージ取得
    public function fetch(Request $request)
    {
        $to_user_id = $request->input('to_user_id');
        $user_id = auth()->id();
        if (empty($to_user_id)) {
            return response()->json(['messages' => []]);
        }
        $messages = Message::where(function ($q) use ($user_id, $to_user_id) {
            $q->where('user_id', $user_id)->where('to_user_id', $to_user_id);
        })->orWhere(function ($q) use ($user_id, $to_user_id) {
            $q->where('user_id', $to_user_id)->where('to_user_id', $user_id);
        })->orderBy('sent_at', 'asc')->get();

        // usernameを追加
        foreach ($messages as $msg) {
            // 送信者と受信者の区別
            if ($msg->user_id == $user_id) {
                $user = User::find($msg->user_id); // 自分
                $partner = User::find($msg->to_user_id); // 相手
                $msg->user_name = $user->name ?? '';
                $msg->partner_name = $partner->name ?? '';
                $msg->user_avatar = ($user && $user->profile && !empty($user->profile->avatar)) ? $user->profile->avatar : '';
                $msg->partner_avatar = ($partner && $partner->profile && !empty($partner->profile->avatar)) ? $partner->profile->avatar : '';
            } else {
                $user = User::find($msg->user_id); // 相手
                $partner = User::find($msg->to_user_id); // 自分
                $msg->user_name = $user->name ?? '';
                $msg->partner_name = $partner->name ?? '';
                $msg->user_avatar = ($user && $user->profile && $user->profile->avatar) ? $user->profile->avatar : '';
                $msg->partner_avatar = ($partner && $partner->profile && $partner->profile->avatar) ? $partner->profile->avatar : '';
            }
            $msg->content = $msg->content ?? '';
            $msg->emoji = $msg->emoji ?? '';
            $msg->image_path = (!empty($msg->image_path) && $msg->image_path !== 'null') ? $msg->image_path : '';
        }

        // 未読メッセージを既読に更新
        Message::where('user_id', $to_user_id)
            ->where('to_user_id', $user_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        if ($message->user_id !== auth()->id()) {
            return response()->json(['error' => '権限がありません'], 403);
        }
        $message->delete();
        return response()->json(['success' => true]);
    }

    public function report($id)
    {
        $message = Message::findOrFail($id);
        // ここで報告内容を保存したり、管理者に通知したりできます
        // 今回は簡単に成功レスポンスを返します
        return response()->json(['success' => true, 'message' => 'メッセージが報告されました']);
    }
}
