<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;
    protected $table = 'branch';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name','direction'
    ];

    public function scopeSearch($query, $name)
    {
        if (trim($name) != "") {
            return $query->where('name', 'like', "%$name%")
                ->orWhere('direction', 'like', "%$name%");
        }
    }


    /*
        public function products() {
            return $this->belongsToMany('\App\Cms\Product', 'product_branch');
        }

        public function user() {
            return $this->hasMany('\App\Models\User', 'branch_id','id');
        }
        */

    public function create_user() {
        return $this->hasOne('\App\Models\User', 'branch_id');
    }

}
