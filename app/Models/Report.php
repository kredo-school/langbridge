<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReportViolationReason;
use App\Models\User;


class Report extends Model
{
    protected $fillable = [
        'reporter_id',
        'category',
        'violation_reason_id',
        'detail',
        'file',
        'reported_content_id',
        'reported_content_type',
        'action_status',
    ];

    public function reporter(){
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedContent(){
        return $this->morphTo();
    }
}
