<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Interest;

class SearchController extends Controller
{

public function search(Request $request)
{
    // empty collection 
    $users = collect();

    //initialize query builder
    $query = Profile::query()->where('hidden', false);

    // if handle is provided, search by partial match
    if ($request->filled('handle')) {
        $query->where('handle', 'like', '%' . $request->handle . '%');
    }

    // if nickname is provided, search by partial match
    if ($request->filled('nickname')) {
        $query->where('nickname', 'like', '%' . $request->nickname . '%');
    }

    // if bio is provided, search by partial match
    if ($request->filled('bio')) {
        $query->where('bio', 'like', '%' . $request->bio . '%');
    }

    // if interest categories are selected, search for users matching them
    if ($request->filled('interests')) {
        $query->whereHas('user.interests', function ($q) use ($request) {
            $q->whereIn('interests.id', $request->interests);
        });
    }

    // if any search criteria is provided, execute the search and get results
    if (
        $request->filled('handle') ||
        $request->filled('nickname') ||
        $request->filled('bio') ||
        $request->filled('interests')
    ) {
        // Retrieve related "interests" as well, and paginate results by 10 per page
        $users = $query->with('user.interests')->paginate(10);
    }

    // Retrieve the list of interest categories (to display in the search form)
    $interests = Interest::all();

    // Pass search results and interest categories to the view
    return view('search', [
        'users' => $users,
        'interests' => $interests,
    ]);
}


}
