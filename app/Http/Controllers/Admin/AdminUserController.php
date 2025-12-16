<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index(Request $request){
        
        $query = User::with('profile');

        if($search = $request->input('search')){
            $query->where(function($userQuery) use ($search){
                $userQuery->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhereHas('profile', function($profileQuery) use ($search){
                            $profileQuery->where('handle', 'like', "%{$search}%");
                          });
            });
        }
        $users = $query->paginate(10);
        return view('admin.user.index', compact('users'));
    }

  // softdelete by admin
   public function adminDestroy($id){
       $user = User::findOrFail($id);
       $user->delete();

       return redirect()->route('#')->with('deleted', true);
   }
   // restore by admin
   public function restore($id){
       $user = User::withTrashed()->findOrFail($id);
       $user->restore();

       return redirect()->route('#')->with('restored', true);
   }

}
