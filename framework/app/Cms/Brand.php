<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $table = 'brand';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'create_user','update_user','name', ];

}
