<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;
    protected $table = 'transfer';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'branch_id','status','create_user'
    ];


    public function products() {
        return $this->belongsToMany('\App\Cms\Product', 'details_transfer')
            ->withPivot('id','product_id','transfer_id','quantity','unitpricesale')->withTrashed();
    }

    public function createUser()
    {
        return $this->belongsTo('App\Models\User', 'create_user')->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo('App\Cms\Branch', 'branch_id')->withTrashed();
    }
}
