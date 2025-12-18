@extends('admin.layout')

@section('admin-content')


<table class="table-auto w-full border">
    <thead>
        <tr>
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Type</th>
            <th class="px-4 py-2 border">Reported Content ID</th>
            <th class="px-4 py-2 border">Violation Reason</th>
            <th class="px-4 py-2 border">Detail</th>
            <th class="px-4 py-2 border">File</th>
            <th class="px-4 py-2 border">Reported At</th>
            <th class="px-4 py-2 border">Reporter</th>
            <th class="px-4 py-2 border">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
        <tr>
            <td class="px-4 py-2 border">{{ $report->id }}</td>
            <td class="px-4 py-2 border">{{ class_basename($report->reported_content_type) }}</td>
            <td class="px-4 py-2 border">{{ $report->reported_content_id }}</td>
            <td class="px-4 py-2 border">{{ $report->violation_reason_id }}</td>
            <td class="px-4 py-2 border">{{ $report->detail }}</td>
            <td class="px-4 py-2 border">{{ $report->file }}</td>
            <td class="px-4 py-2 border">{{ $report->created_at }}</td>
            <td class="px-4 py-2 border">{{ $report->reporter->name }}</td>
            <td>
                <form action="{{ route('admin.reports.action', $report->id) }}" method="POST">
                    @csrf
                    @php
                        $labels = [
                            'pending'     => 'Warn',
                            'warn'         => 'Suspend',
                            'suspend'      => 'SoftDelete',
                            'user_deleted' => 'Restore',
                            'restore'     => 'Pending',
                        ];
                        $current = $report->action_status ?? 'pending';
                    @endphp
                    <button type="submit" class="btn btn-primary">
                        {{ $labels[$current] ?? 'Warn' }}
                    </button>
                </form>
                {{-- <form method="POST" action="{{ route('admin.reports.action', $report->id) }}">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-blue-500 text-black rounded">
                        {{ $report->nextActionLabel() }}
                    </button>
                </form> --}}
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
