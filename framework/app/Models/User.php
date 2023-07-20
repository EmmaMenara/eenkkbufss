<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;

/*

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends \App\User implements AuthenticatableContract, CanResetPasswordContract //implements Transformable
{
*/

class User extends \App\User implements AuthenticatableContract, CanResetPasswordContract //Transformable
{
//    use TransformableTrait;
    use EntrustUserTrait;
    use Authenticatable;


    protected $fillable = [
       'person_id', 'name', 'email','password'
    ];

    public function scopeSearchEmail($query, $value)
    {
        if (trim($value) != "") {
            return $query->where('email', 'LIKE', "%$value%")->orderBy('email');
        }
    }


    public function NameBranch(){
        return $this->belongsTo('App\Cms\Branch','branch_id')->withTrashed();
    }
}
