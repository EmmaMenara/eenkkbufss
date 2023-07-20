<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customer';
    protected $dates = ['deleted_at'];
    protected $fillable = [
       'create_user','update_user', 'status_id', 'name', 'first_surname', 'second_surname'    ];

    const PUBLIC_GENERAL= 0;
    const ACTIVE= 1;

    public function scopeSearch($query, $name)
    {
        if (trim($name) != "") {
            return $query->where('name', 'like', "%$name%")
                ->orWhere('first_surname', 'like', "%$name%")
                ->orWhere('second_surname', 'like', "%$name%");
        }
    }
}
