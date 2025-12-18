@extends('admin.layout')

@section('admin-content')

<div class="block w-full text-right mb-4">
    <form method="GET" action="{{ route(Route::currentRouteName()) }}" class="flex items-center gap-2">
        <input type="text" name="keyword" value="{{ request('keyword') }}"
               placeholder="Search User" class="px-3 py-2 border rounded-lg">
        <button type="submit" class="px-3 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>
</div>
<table class="table-auto w-full border">
    <thead>
        <tr>
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Full Name</th>
            <th class="px-4 py-2 border">Handle</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Role</th>
            <th class="px-4 py-2 border">Age</th>
            <th class="px-4 py-2 border">Country</th>
            <th class="px-4 py-2 border">Region</th>
            <th class="px-4 py-2 border">Status</th>
            <th class="px-4 py-2 border"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td class="px-4 py-2 border">{{ $user->id }}</td>
            <td class="px-4 py-2 border">{{ $user->name }}</td>
            <td class="px-4 py-2 border">{{ $user->profile->handle }}</td>
            <td class="px-4 py-2 border">{{ $user->email }}</td>
            <td class="px-4 py-2 border">{{ $user->target_language }}</td>
            <td class="px-4 py-2 border">{{ $user->age }}</td>
            <td class="px-4 py-2 border">{{ $user->country }}</td>
            <td class="px-4 py-2 border">{{ $user->region }}</td>
            <td class="px-4 py-2 border">{{ $user->status ?? 'active' }}</td>
            <td class="px-4 py-2 border"></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
