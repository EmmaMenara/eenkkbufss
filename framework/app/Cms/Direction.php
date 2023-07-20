<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direction extends Model
{
    use SoftDeletes;
    protected $table = 'address_person';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'create_user', 'zip', 'person_id','address','exterior_number','inner_number','colony','city'
    ];

}
