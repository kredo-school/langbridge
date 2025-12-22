<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ReportViolationReason;
use App\Models\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
    
        // 最近チャットした相手を messages テーブルから取得
        $myId = $user->id;
        $partners = Message::selectRaw('CASE WHEN user_id = ? THEN to_user_id ELSE user_id END as partner_id, MAX(sent_at) as last_chat_at', [$myId])
            ->where(function ($query) use ($myId) {
                $query->where('user_id', $myId)
                      ->orWhere('to_user_id', $myId);
            })
            ->groupBy('partner_id')
            ->orderByDesc('last_chat_at')
            ->get();
        $partnerIds = $partners->pluck('partner_id')->toArray();
        // 相手ユーザー情報をまとめて取得
        $recentChats = User::whereIn('id', $partnerIds)->get()
         ->sortBy(function ($user) use ($partnerIds) {
        return array_search($user->id, $partnerIds);
         })
         ->values();
        // 自分の言語設定
        $myPreference = $user->target_language;
    
        // 相手の言語設定（自分がjaならen、逆ならja）
        $otherPreference = $myPreference === 'ja' ? 'en' : 'ja';
    
        // ランダムに10人取得（自分以外）
        $otherUsers = User::where('target_language', $otherPreference) 
        ->where('id', '!=', $user->id) 
        ->whereHas('profile', function ($query) { $query->where('hidden', false); }) 
        ->whereNotIn('id', $partnerIds) // すでにチャットした人を除外 
        ->where('inadmin', false) // 管理者を除外 
        ->inRandomOrder() 
        ->take(10) 
        ->get();

        // recentChats と otherUsers を両方ビューに渡す
        return view('home', compact('recentChats', 'otherUsers'));
    }
    
   
}
