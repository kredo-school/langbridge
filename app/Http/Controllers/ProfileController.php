<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Interest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {

    // }

    /**
     * Display the specified resource.
     */

    public function show(Profile $profile)
    {
        // search result connected to profile page
        return "This is {$profile->handle} profile page!";
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }


    // test用のプロフィール作成機能（後で削除予定）

    public function create()
    {
        $interests = Interest::all();
        return view('profiles.create', ['interests' => $interests]);
    }


    public function store(Request $request)
    {
        // 仮ユーザー作成（簡易的なテスト用）
        $user = User::create([
            'name' => 'Test User',
            'email' => uniqid('test') . '@example.com',
            'password' => bcrypt('password'),
            'birth_date' => now()->subYears(20),
            'target_language' => 'English',
            'country' => 'Japan',
            'region' => 'Tokyo',
            'suspended' => false,
        ]);
        // プロフィール作成
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->handle = $request->handle;
        $profile->nickname = $request->handle;
        $profile->avatar = '';
        $profile->JP_level = '3';
        $profile->EN_level = '2';
        $profile->bio = 'よろしくお願いします！';
        $profile->age_hidden = false;
        $profile->country_hidden = false;
        $profile->region_hidden = false; // ← ここを追加！
        $profile->hidden = false;
        $profile->save();




        // 興味を紐付け
        $user->interests()->sync($request->interests);

        return redirect()->route('users.search');
    }
}
