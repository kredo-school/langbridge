<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportViolationReason extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'category',
        // 'name_JP',
        // 'name_EN',
        'name',
    ];
}
