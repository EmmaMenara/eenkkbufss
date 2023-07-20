<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactPerson extends Model
{
    use SoftDeletes;
    protected $table = 'contact_person';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'person_id',  'contact_id',
    ];

}
