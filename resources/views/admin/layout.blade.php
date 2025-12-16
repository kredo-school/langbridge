
    @extends('layouts.app')
   
    @section('sidebar')
    <aside class="col-auto bg-gray-100 p-4 rounded-xl shadow-md space-y-6">
        
        <ul class="space-y-4">
            <!-- Data Overview -->
            <li>
                <div class="font-semibold text-gray-700 mb-1">Data Overview</div>
                <ul class="space-y-1 pl-4">
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                           class="block px-3 py-2 rounded 
                                  {{ request()->routeIs('admin.users.index') ? 'bg-blue-300 font-bold' : 'hover:bg-blue-200' }}">
                           User
                        </a>
                    </li>
                </ul>
            </li>
    
            <!-- Reports -->
            <li>
                <div class="font-semibold text-gray-700 mb-1">Reports</div>
                <ul class="space-y-1 pl-4">
                    <li>
                        <a href="{{ route('admin.reports.users') }}"
                           class="block px-3 py-2 rounded 
                                  {{ request()->routeIs('admin.reports.users') ? 'bg-blue-300 font-bold' : 'hover:bg-blue-200' }}">
                           User
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.messages') }}"
                           class="block px-3 py-2 rounded 
                                  {{ request()->routeIs('admin.reports.messages') ? 'bg-blue-300 font-bold' : 'hover:bg-blue-200' }}">
                           Chat Message
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside> 
    

   @endsection

   @section('content')
<div class="p-6">
    @yield('admin-content')
</div>
@endsection

