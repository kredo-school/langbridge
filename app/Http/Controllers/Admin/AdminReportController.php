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
        $reports = Report::where('reported_content_id', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.report.user', compact('reports'));
    }

    // message
    public function messages()
    {
        $reports = Report::where('reported_content_id', 'message')
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
    
        switch ($request->input('action')) {
            case 'warn':
                if ($target instanceof User) {
                    $target->status = 'warned';
                    $target->save();
                    $report->action_status = 'warned';
                }
                break;
    
            case 'suspend':
                if ($target instanceof User) {
                    $target->suspended = true;
                    $target->save();
                    $report->action_status = 'suspended';
                }
                break;
    
            case 'delete':
                if ($target instanceof User) {
                    // softdelete for user
                    $target->delete();
                    $report->action_status = 'user_deleted';
                } elseif ($target instanceof Message) {
                    // forcedelete for message
                    $target->forceDelete();
                    $report->action_status = 'message_deleted';
                }
                break;
    
            case 'restore':
                if ($target instanceof User) {
                    $target = User::withTrashed()->findOrFail($target->id);
                    $target->restore();
                    $report->action_status = 'user_restored';
                }
               
                break;
        }
    
        $report->save();
    
        return redirect()->back()->with('success', 'Action completed.');
    }
}
