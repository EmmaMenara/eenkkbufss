<?php

namespace App\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $table = 'supplier';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'create_user', 'update_user', 'provider_name', 'rfc', 'phone_number', 'contact_name', 'contact_first_surname',
        'contact_second_surname', 'mobile'
    ];

    public function scopeSearch($query, $name)
    {
        if (trim($name) != "") {
            return $query->where('provider_name', 'like', "%$name%")
                ->orWhere('contact_name', 'like', "%$name%")
                ->orWhere('contact_first_surname', 'like', "%$name%")
                ->orWhere('contact_second_surname', 'like', "%$name%")
                ->orWhere('mobile', 'like', "%$name%")
                ->orWhere('rfc', 'like', "%$name%");
        }
    }
}
