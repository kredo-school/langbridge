<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Interest;

class ProfileController extends Controller
{

    private $profile;
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }
    public function show($user_id)
    {
        $profile = $this->profile->where('user_id', $user_id)->findOrFail($user_id);

        if ($profile->hidden && auth()->id() !== $profile->user_id && !auth()->user()?->isAdmin()) {
            abort(404);
        }
        return view('#')->with('profile', $profile);
    }
    public function edit()
    {
        $profile = $this->profile->where('user_id', auth()->id())->firstOrFail();

        return view('#')
            ->with('profile', $profile);
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


    /**
     * Remove the specified resource from storage.
     */
    public function update(Request $request)
    {
        $profile = $this->profile->where('user_id', auth()->id())->firstOrFail();
        $user = $profile->user;
        $request->validate([
            'handle' => 'required|string|unique:profiles,handle,' . $profile->id,
        ]);

        $profile->nickname = $request->nickname;
        $profile->bio = $request->bio;
        $profile->JP_level = $request->JP_level;
        $profile->EN_level = $request->EN_level;
        $profile->age_hidden = $request->has('age_hidden');
        $profile->country_hidden = $request->has('country_hidden');
        $profile->region_hidden = $request->has('region_hidden');
        $profile->hidden = $request->has('hidden');

        if ($request->avatar) {
            $profile->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $profile->save();

        // Userの更新
        $user->birthday = $request->birthday;
        $user->target_language = $request->target_language;
        $user->country = $request->country;
        $user->region = $request->region;
        $user->save();

        return redirect()->route('profile.show', $profile->user_id);
    }



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
