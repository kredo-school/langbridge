<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function destroy(Request $request){
        $user = Auth::user();
        $user->delete();
        Auth::logout();
        return redirect('/');
    }
}
