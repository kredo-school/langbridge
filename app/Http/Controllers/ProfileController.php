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
        return view('pages.profile.show')->with('profile', $profile);
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
}
