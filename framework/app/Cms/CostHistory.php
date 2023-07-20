<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostHistory extends Model
{
    use SoftDeletes;
    protected $table = 'cost_history';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'product_id','quantity','unitcost','unitpricesale'
    ];

}
