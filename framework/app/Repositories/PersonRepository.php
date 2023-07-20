<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 28/07/18
 * Time: 05:46 PM
 */

namespace App\Repositories;

use App\Cms\Barber;
use App\Cms\ContactPerson;
use App\Cms\Customer;
use App\Cms\Direction;
use App\Cms\Person;
use App\Cms\Schedule;
use App\Cms\Status;
use App\Models\Role;
use App\Models\User;
use DB;
use Log;

class PersonRepository
{
    public function store($data, $typeUser)
    {
        DB::beginTransaction();
        try {
            $person['status_id'] = Status::ACTIVE;
            switch ($typeUser) {
                case Role::BARBER:
                    $person['role_id'] = Role::BARBER;
                    $oRole = Role::find(Role::BARBER);
                    break;
                case Role::CUSTOMER:
                    $person['role_id'] = Role::CUSTOMER;
                    $oRole = Role::find(Role::CUSTOMER);
                    break;
            }

            $person['name'] = $data['name'];
            $person['first_surname'] = $data['first_surname'];
            $person['second_surname'] = $data['second_surname'];
            $person['phone'] = $data['phone'];
            $person['mobile'] = $data['mobile'];

            $oPerson = Person::create($person);


            $user['person_id'] = $oPerson->id;
            $user['name'] = $oPerson->name;
            $user['email'] = $data['email'];
            $user['password'] = $data['password'];

            $oUser = User::create($user);
            $oUser->attachRole($oRole);

            $address['create_user'] = \Auth::user()->id;
            $address['zip'] = $data['zip'];
            $address['person_id'] = $oPerson->id;
            $address['address'] = $data['address'];
            $address['exterior_number'] = $data['exterior_number'];
            $address['inner_number'] = $data['inner_number'];
            $address['colony'] = $data['colony'];
            $address['city'] = $data['city'];

            Direction::create($address);
            switch ($typeUser) {
                case Role::BARBER;
                    $barber['person_id'] = $oPerson->id;
                    $barber['curp'] = $data['curp'];
                    $barber['rfc'] = $data['rfc'];
                    $barber['nss'] = $data['nss'];
                    $barber['alergias'] = $data['alergias'];
                    Barber::create($barber);
                    break;
                case Role::CUSTOMER:
                    $customer['person_id'] = $oPerson->id;
                    $customer['birth_date'] = $data['birth_date'];
                    $customer['favorite_beverage'] = $data['favorite_beverage'];
                    $customer['executive'] = $data['executive'];
                    $customer['type_customer'] = $data['type_customer'];
                    Customer::create($customer);
                    break;
            }
            if(isset($data['contact_first_surname'])){
                $contact['role_id'] = Role::CONTACT;
                $contact['status_id'] = Status::ACTIVE;
                $contact['name'] = $data['contact_name'];
                $contact['first_surname'] = $data['contact_first_surname'];
                $contact['second_surname'] = $data['contact_second_surname'];
                $contact['phone'] = $data['contact_phone'];
                $oContact = Person::create($contact);
                ContactPerson::create(['person_id' => $oPerson->id, 'contact_id' => $oContact->id]);
            }


            if(isset($data['Status'])){
                for($x=0;$x<count($data['Status']);$x++){
                    $schedule['person_id']=$oPerson->id;
                    if($data['Status'][$x]==="descanso"){
                        $schedule['status_id']=Status::REST_DAYS;
                    }else{
                        $schedule['status_id']=Status::WORK_SCHEDULE;
                    }

                    $schedule['day_name']=$data['NameDay'][$x];
                    $schedule['starting_time']=$data['HomeTime'][$x];
                    $schedule['ending_time']=$data['Ending'][$x];
                    Schedule::create($schedule);
                }
            }


            DB::commit();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            dd($queryException->getMessage(),$data);
            DB::rollBack();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(),$data);
            dd($exception->getMessage());
            DB::rollBack();
        }
    }

    public function existEmail($value)
    {
        $obj = User::where('email', '=', $value)->get();
        if ($obj->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function executive()
    {
        return Person::executive()->orderBy('name', 'asc')->orderBy('first_surname', 'asc')->get();
    }

    public function workstation(){
        return (Role::whereNotIn('id',[1,2,4])->get());
    }

}