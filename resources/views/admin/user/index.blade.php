@extends('admin.layout')

@section('content')

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
