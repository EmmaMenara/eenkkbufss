<?php

namespace App\Cms;

use App\Cms\Traits\KindPerson;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;
    use KindPerson;
    protected $table = 'person';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'status_id', 'name', 'first_surname', 'second_surname'
    ];

    //SI QUITA, AÑADE O MODIFICA ESTOS VALORES, CONSIDERE EL TRAIT KINDPERSON
    const ADMIN = 1;
    const MASTER = 2;
    const CUSTOMER = 4;
    const PUBLIC_GENERAL= 0;


    public static function getPerson()
    {
        return [
            self::ADMIN,
            self::MASTER,
            self::CUSTOMER,
            self::PUBLIC_GENERAL,
        ];
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'person_id')->withTrashed();
    }

    public function scopeSearchBarber($query,$value){
        if(trim($value)!=""){
            $rst = User::searchEmail($value)->get();

            $key=[];
            foreach ($rst as $row){
                $key[]=$row->person_id;
            }
            if(count($rst)>0){
                return $query->where('name','like',"%$value%")
                    ->orWhere('first_surname','like',"%$value%")
                    ->orWhere('second_surname','like',"%$value%")
                    ->orWhere('phone','like',"%$value%")
                    ->orWhere('mobile','like',"%$value%")
                    ->orWhereIn('id',$key);
            }else{
                return $query->where('name','like',"%$value%")
                    ->orWhere('first_surname','like',"%$value%")
                    ->orWhere('second_surname','like',"%$value%")
                    ->orWhere('phone','like',"%$value%")
                    ->orWhere('mobile','like',"%$value%");
            }

        }
    }

    public function address(){
        $this->hasOne('App\Cms\Direction')->withTrashed();
    }

    public function contact(){
        $this->hasOne('contact_person')->withTrashed();
    }
}

