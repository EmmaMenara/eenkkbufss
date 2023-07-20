<?php

namespace App\Cms;

use App\Cms\Traits\KindPerson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    use KindPerson;
    protected $table = 'sales';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'customers_id','status','create_user','method_payment','mount','branch_id'
    ];


    public function products() {
        return $this->belongsToMany('\App\Cms\Product', 'details_sales')
            ->withPivot('id','product_id','sale_id','quantity','unitprice','iva','cancel')->withTrashed();
    }

    public function createUser()
    {
        return $this->belongsTo('App\Models\User', 'create_user')->withTrashed();
    }

}
