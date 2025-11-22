<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('#', ['user' => $user]);
    }

    public function update(Request $request){
        $user = auth()->user();

        $user->update([
            'hidden'        => $request->has('hidden'),
            'age_hidden'    => $request->has('age_hidden'),
            'country_hidden'    => $request->has('country_hidden'),
            'region_hidden'    => $request->has('region_hidden'),
        ]);
        return redirect()->route('setting.index');
    }

}
