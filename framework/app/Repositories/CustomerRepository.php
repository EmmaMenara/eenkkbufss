<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 26/07/18
 * Time: 08:48 AM
 */

namespace App\Repositories;

use App\Cms\Customer;
use Log;

class CustomerRepository
{


    public function all(){
        try{
            return Customer::
                where('id','!=',Customer::PUBLIC_GENERAL)
                ->orderBy('name','asc')->orderBy('first_surname','asc')
                ->get();
        }catch (QueryException $queryException){
         //  dd($queryException->getMessage());
            Log::error(\Auth::user()->id . "|". $queryException->getMessage());
        }catch (\Exception $exception){
           // dd($exception->getMessage());
            Log::error(\Auth::user()->id . "|". $exception->getMessage());
        }
    }

    public function store($data){
        try{
            $obj=Customer::create($data);
            return $obj->id;
        }catch (\Exception $exception){
            Log::error(\Auth::user()->id . "|". $exception->getMessage());
            dd($exception->getMessage());
            return -1;
        }
    }

    public function find($id){
        return Customer::findOrFail($id);
    }

    public function update($id,$data){
        try{
            $obj = Customer::findOrFail($id);
            $obj->fill($data);
            $obj->save();
            return $obj->id;
        }catch (\Exception $exception){
            Log::error(\Auth::user()->id . "|". $exception->getMessage());
            dd($exception->getMessage());
            return -1;
        }
    }

    public function destroy($id){
        $obj = Customer::findOrFail($id);
        $obj->delete();
        return true;
    }

    public function search($text)
    {
        return Customer::search($text)->orderBy('name')->get();
    }
}