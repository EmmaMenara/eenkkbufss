<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buy extends Model
{
    use SoftDeletes;
    protected $table = 'buy';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'suplier_id','status','create_user','mount','num_docto'
    ];

    public function products() {
        return $this->belongsToMany('\App\Cms\Product', 'details_buy')
            ->withPivot('id','product_id','buy_id','quantity','unitcost','unitpricesale')->withTrashed();
    }

    public function suppliers()
    {
        return $this->belongsTo('App\Cms\Supplier', 'supplier_id')->withTrashed();
    }

    public function createUser()
    {
        return $this->belongsTo('App\Models\User', 'create_user')->withTrashed();
    }
}
