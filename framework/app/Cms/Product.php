<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'product';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'create_user','update_user','codebar','codeinner','brand_id', 'name', 'photo','stock_max_matriz','stock_min_matriz',
        'genero','tipo','color','talla','costo'
    ];


    public function scopeSearch($query, $name)
    {
        if (trim($name) != "") {
            return $query->where('name', 'like', "%$name%")
                ->orWhere('codebar', 'like', "%$name%");
        }
    }

    public function brand()
    {
        return $this->belongsTo('App\Cms\Brand', 'brand_id')->withTrashed();
    }

    public function detailsData($branch_id){
        return $this->belongsToMany('\App\Cms\Branch','product_branch')
            ->where('branch_id','=',$branch_id)
            ->withPivot('product_id','branch_id','existence','stock_min_branch','stock_max_branch','unitprice1','unitprice2','unitprice3',
                'lastsale','lastentry')
            ->withTimestamps();
    }

}
