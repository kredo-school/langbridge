<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Interest;

class ProfileController extends Controller
{

    private $profile;
   
    public function __construct(Profile $profile){
        $this->profile = $profile;       
    }
    public function show($user_id){
        $profile = $this->profile->findOrFail($user_id);

        if ($profile->hidden && auth()->id() !== $profile->user_id && !auth()->user()?->isAdmin()) {
            abort(404);
        }
        $user = $profile->user;
        $interests = $user->interests;

    return view('profile', compact('profile', 'user', 'interests'));
    }
    public function edit(){
        $profile = $this->profile->findOrFail(auth()->id());

        $user = auth()->user();
        $interests = Interest::all();

        return view('editprofile', compact('profile', 'user', 'interests'));

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
        $profile = $this->profile->findOrFail(auth()->id());
        $user = $profile->user;
        $request->validate([
            'handle' => 'required|string|unique:profiles,handle,' . $profile->user_id . ',user_id',
            'interests' => 'array',
        ]);

        $levelMap = [
            'Beginner' => 1,
            'Intermediate' => 2,
            'Advanced' => 3,
            'Native' => 4,
        ];

        $profile->nickname = $request->nickname;
        $profile->handle = $request->handle;
        $profile->bio = $request->bio;
        $profile->JP_level = $levelMap[$request->JP_level];
        $profile->EN_level = $levelMap[$request->EN_level];
       
        if ($request->avatar) { 
            $profile->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar)); 
        }

        $profile->save();

        // Userの更新
        $user->country = $request->country;
        $user->region = $request->region;
        $user->save();

        $user->interests()->sync($request->input('interests', []));

        return redirect()->route('profile.show', $profile->user_id);
    }



    public function destroy(Profile $profile)
    {
        //
    }
}
