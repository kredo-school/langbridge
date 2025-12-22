@extends('admin.layout')

@section('admin-content')

{{--  search bar --}}
<div style="align-items: center; margin-bottom: 20px; padding-right: 2px;">
    <form action="{{ route('admin.reports.messages') }}" method="GET" style="position: relative; display: inline-block;">
        <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #D1D5DB; pointer-events: none;">
            <i class="fas fa-search" style="font-size: 14px;"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Message Report" 
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
            <td class="px-4 py-2 border">
                @if($report->reported_content_id)
                <a href="{{ route('chat.chat', ['id' => encrypt($report->reported_content_id)]) }}" 
                class="text-indigo-600 hover:text-indigo-800 font-bold flex items-center gap-1">
                <span>{{ $report->reported_content_id }}</span> 
                </a>
                @else
                <span class="text-gray-400 text-xs">No Data</span>
                @endif
            </td>
            <td class="px-4 py-2 border">{{ $report->violation_reason_id }}</td>
            <td class="px-4 py-2 border">{{ $report->detail }}</td>
            <td class="px-4 py-2 border">{{ $report->file }}</td>
            <td class="px-4 py-2 border">{{ $report->created_at }}</td>
            <td class="px-4 py-2 border">{{ $report->reporter->profile->handle }}</td>
            <td class="px-4 py-2 border">
                
                @if(!$report->message)
                    <span class="text-gray-400 text-sm font-bold uppercase tracking-wider">Deleted</span>
                @else
                    <form action="{{ route('admin.reports.action', $report->id) }}" method="POST" onsubmit="return confirm('完全に削除しますか？');">
                    @csrf
                    <button type="submit" name="action" value="delete"
                    class="bg-white border-none p-2 text-red-500 hover:text-red-700 transition-colors cursor-pointer">
                    <i class="fa-solid fa-trash-can"></i>
                    </button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
