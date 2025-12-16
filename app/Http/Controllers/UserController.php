<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   // 本人による削除
   public function destroy(Request $request){
       $user = Auth::user();
       $user->forceDelete();
       Auth::logout();

       return redirect()->route('login')->with('deleted', true);
   }

}
