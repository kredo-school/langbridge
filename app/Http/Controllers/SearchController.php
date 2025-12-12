<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Interest;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $users = collect(); //initialize empty collection
        $query = Profile::query()->where('hidden', false); //base query
        $interests = Interest::all(); //get all interests for filter options

        if ($request->filled('keyword')) { //keyword filter
            $query->where(function ($q) use ($request) { //grouped conditions
                $q->where('handle', 'like', '%' . $request->keyword . '%') //search by handle
                    ->orWhere('nickname', 'like', '%' . $request->keyword . '%') //search by nickname
                    ->orWhere('bio', 'like', '%' . $request->keyword . '%'); //search by bio
            });
        }

        if ($request->filled('interests')) { //interests filter
            $query->whereHas('user.interests', function ($q) use ($request) {
                $q->whereIn('interests.id', $request->interests);
            });
        }

        if (
            $request->filled('keyword') || //either filter is applied
            $request->filled('interests')
        ) {
            $users = $query->with('user.interests')->paginate(10); //paginate results
        }

        return view('pages.search', [ //return view with data
            'users' => $users, //filtered users
            'interests' => $interests, //all interests
        ]);
    }
}
