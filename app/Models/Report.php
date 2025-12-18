<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReportViolationReason;
use App\Models\User;


class Report extends Model
{
    protected $fillable = [
        'reporter_id',
        'violation_reason_id',
        'detail',
        'file',
        'reported_content_id',
        'reported_content_type',
        'action_status',
        'created_at',
        'updated_at',
    ];


    public function reporter(){
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedContent(){
        return $this->morphTo();
    }

    public function nextActionLabel()
    {
        $map = [
            'reported'    => 'Warn',
            'warned'      => 'Suspend',
            'suspended'   => 'Delete',
            'user_deleted'=> 'Restore',
            'restored'    => 'Report',
        ];
    
        return $map[$this->action_status] ?? 'Pending';
}
}
