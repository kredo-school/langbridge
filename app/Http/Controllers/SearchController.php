<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Interest;

class SearchController extends Controller
{



    public function search(Request $request)
    {
        $users = collect(); // initialize empty collection for users
        $query = Profile::query()->where('hidden', false); // exclude hidden profiles

        if ($request->filled('handle')) { // partial match search by handle name
            $query->where('handle', 'like', '%' . $request->handle . '%');
        }

        if ($request->filled('interests')) { // filter by interest categories
            $query->whereHas('user.interests', function ($q) use ($request) {
                $q->whereIn('interests.id', $request->interests);
            });
        }

        if ($request->filled('handle') || $request->filled('interests')) { // execute query only if there are search conditions
            $users = $query->with('user.interests')->paginate(10);
        }

        $interests = Interest::all(); // get all interest categories
        return view('search', [ // pass data to search.blade.php
            'users' => $users,
            'interests' => $interests,
        ]);
    }
}
