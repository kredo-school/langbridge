<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

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
        return view('#')->with('profile', $profile);
    }
    public function edit(){
        $profile = $this->profile->findOrFail(auth()->id());

        return view('#')
            ->with('profile', $profile);
    }

    public function update(Request $request)
    {
        $profile = $this->profile->findOrFail(auth()->id());
        $user = $profile->user;
        $request->validate([
            'handle' => 'required|string|unique:profiles,handle,' . $profile->user_id,
        ]);
        
        $profile->nickname = $request->nickname;
        $profile->bio = $request->bio;
        $profile->JP_level = $request->JP_level;
        $profile->EN_level = $request->EN_level;
       
        if ($request->avatar) { 
            $profile->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar)); 
        }

        $profile->save();

        // Userの更新
        $user->country = $request->country;
        $user->region = $request->region;
        $user->save();

        return redirect()->route('profile.show',$profile->user_id);
    }


  
    public function destroy(Profile $profile)
    {
        //
    }
}
