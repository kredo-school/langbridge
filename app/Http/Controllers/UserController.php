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

//    // 管理者による削除
//    public function adminDestroy($id){
//        $user = User::findOrFail($id);
//        $user->delete();

//        return redirect()->route('#')->with('deleted', true);
//    }
//    // 管理者による復元
//    public function restore($id){
//        $user = User::withTrashed()->findOrFail($id);
//        $user->restore();

//        return redirect()->route('#')->with('restored', true);
//    }
}
