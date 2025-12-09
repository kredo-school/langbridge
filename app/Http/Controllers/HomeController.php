<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
    public function index(){
        $user = Auth::user();
        // $recentChats = $user->recentChats()->take(5)->get();
        $myPreference = $user->target_language;
        $otherPreference = $myPreference === 'ja' ? 'en' : 'ja';
        $otherUsers = User::where('target_language', $otherPreference)->where('id' , '!=', $user->id)->inRandomOrder()->take(10)->get();
        return view('home', compact('otherUsers'));
        // return view('home', compact('recentChats', 'otherUsers'));
    }
}
