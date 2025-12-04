<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $user = auth()->user()->load('profile');
        return view('settings', ['user' => $user]);
    }

    public function update(Request $request){
        $user = auth()->user();

        // $user->update([
        //     'hidden'        => $request->has('hidden'),
            
        // ]);

        $user->profile->update([
            'age_hidden'    => $request->has('age_hidden'),
            'country_hidden'    => $request->has('country_hidden'),
            'region_hidden'    => $request->has('region_hidden'),
            'hidden'        => $request->has('hidden'),
        ]);
        
        return redirect()->route('setting.index');
    }

}
