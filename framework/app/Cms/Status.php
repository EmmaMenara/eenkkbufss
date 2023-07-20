<?php

namespace App\Cms;

use App\Cms\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 2;
    const RESERVED = 3;
    const WORK_SCHEDULE = 4;
    const REST_DAYS = 5;

    protected $table = 'status';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', 'description',
    ];
}
