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
        $message = new Message();
        $message->user_id = auth()->id();
        $message->to_user_id = $request->input('to_user_id');
        $message->content = $request->input('content');
        $message->emoji = $request->input('emoji');
        $message->sent_at = now();
        $message->is_read = false;

        // 画像アップロード処理
        // 画像アップロード処理
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
        // 自分と相手の会話履歴のみ取得
        $messages = Message::where(function ($q) use ($user_id, $to_user_id) {
            $q->where('user_id', $user_id)->where('to_user_id', $to_user_id);
        })->orWhere(function ($q) use ($user_id, $to_user_id) {
            $q->where('user_id', $to_user_id)->where('to_user_id', $user_id);
        })->orderBy('sent_at', 'asc')->get();

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
}
