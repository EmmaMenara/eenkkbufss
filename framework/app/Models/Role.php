<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

use Zizaco\Entrust\EntrustRole;


//class Role extends Model implements Transformable
class Role extends EntrustRole implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

    const ADMIN = 1;
    const MASTER = 2;
    const BARBER = 3;
    const CUSTOMER = 4;
    const EXECUTIVE = 5;
    const CONTACT = 6;


    public static function getRole()
    {
        return [
            self::ADMIN,
            self::MASTER,
            self::BARBER,
            self::CUSTOMER,
            self::EXECUTIVE,
            self::CONTACT,
        ];
    }
}
