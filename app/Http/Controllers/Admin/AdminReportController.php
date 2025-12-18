<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Models\Message;

class AdminReportController extends Controller
{
    /** report index */
    //users
    public function users()
    {
        $reports = Report::where('reported_content_type', User::class)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.report.user', compact('reports'));
    }

    // message
    public function messages()
    {
        $reports = Report::where('reported_content_type', \App\Models\Message::class)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.report.message', compact('reports'));
    }

    /** Action to report */
    public function action(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $target = $report->reportedContent; 
    
        if (!$target) {
            return back()->with('error', 'not found the target');
        }
        // if ($target instanceof User) {
        //     $user = User::withTrashed()->findOrFail($report->reported_content_id);
        if ($report->reported_content_type === User::class) {
            $user = User::withTrashed()->findOrFail($report->reported_content_id);
        //     // User 
            switch ($report->action_status) {
                case 'pending':
                    $report->action_status = 'warn';
                    break;
        
                case 'warn':
                    $report->action_status = 'suspend';
                    $user->update(['suspended' => true]);
                    $user->save();
                    break;
        
                case 'suspend':
                    
                    $user->delete(); // soft delete
                    $report->action_status = 'user_deleted';
                    break;                    
                
                case 'user_deleted':
    
    $user->update([
        'deleted_at' => null,
        'suspended' => false,
    ]);
    $report->update(['action_status' => 'restore']);
    break;
                    // $user->restore();
                    // $user->update(['suspended' => false]); 
                    // $report->update(['action_status' => 'restore']); 
                    // break;
                    
                case 'restore':
                    $report->action_status = 'pending';
                    break;
            }
        } elseif ($report->reported_content_type === Message::class) {
            // Message 
    // } elseif ($target instanceof Message) {
            if ($report->action_status === 'pending') {
                $target->forceDelete(); 
                $report->action_status = 'deleted';
            }
        }
        
            $report->save();    
    
            return redirect()->back()->with('action_status', $report->action_status);
    }

}
