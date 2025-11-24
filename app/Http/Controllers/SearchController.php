<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Interest;

class SearchController extends Controller
{
public function search(Request $request)
{
    $users = collect();

    $query = Profile::query()->where('hidden', false); // 非表示除外

    if ($request->filled('handle') && !$request->filled('interest')) {
        // ハンドルネームのみで検索（部分一致にしてもOK）
        $query->where('handle', 'like', '%' . $request->handle . '%');
        $users = $query->get();
    } elseif ($request->filled('interest') && !$request->filled('handle')) {
        // 興味のみで検索
        $query->whereHas('user.interests', function ($q) use ($request) {
            $q->where('interests.id', $request->interest);
        });
        $users = $query->get();
    }
    // 両方入力 or どちらも未入力 → 検索しない（空のまま）

    $interests = Interest::all();

    return view('search', [
        'users' => $users,
        'interests' => $interests,
    ]);
}


}



