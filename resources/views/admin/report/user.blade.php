@extends('admin.layout')

@section('admin-content')
{{--  search bar --}}
<div style="align-items: center; margin-bottom: 20px; padding-right: 2px;">
    <form action="{{ route('admin.reports.users') }}" method="GET" style="position: relative; display: inline-block;">
        <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #D1D5DB; pointer-events: none;">
            <i class="fas fa-search" style="font-size: 14px;"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search User Report" 
               style="width: 260px; padding: 8px 40px 8px 20px; border: 1px solid #E5E7EB; border-radius: 9999px; background-color: #ffffff; outline: none; font-size: 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
    </form>    
</div>

<table class="table-auto w-full border">
    <thead>
        <tr class="report-title">
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
    <tbody class="text-center">
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

                @if(stripos($report->reported_content_type, 'user') !== false)
    <form action="{{ route('admin.reports.action', $report->id) }}" method="POST">
        @csrf
        
        
        @if($report->action_status === 'pending')
            <button type="submit" class="btn btn-outline-warning">
                warn
            </button>
            

        @elseif($report->action_status === 'warn')
            <button type="submit" class="btn btn-warning">
                Suspend
            </button>

        @elseif($report->action_status === 'suspend')
            <button type="submit" class="btn btn-danger">
                SoftDelete
            </button>

        @elseif($report->action_status === 'user_deleted')
            <button type="submit" class="btn btn-success">
                Restore
            </button>
            
        @elseif($report->action_status === 'restore')
            <button type="submit" class="btn btn-primary">
                active
            </button>

        @endif
    </form>
@endif
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
