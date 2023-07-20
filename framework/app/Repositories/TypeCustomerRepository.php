<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 6/08/18
 * Time: 10:06 PM
 */

namespace App\Repositories;


use App\Cms\TypeCustomer;

class TypeCustomerRepository
{
    public function all(){
        try{
            return TypeCustomer::all();
        }catch (QueryException $queryException){
            Log::error(\Auth::user()->id . "|". $queryException->getMessage());
        }catch (\Exception $exception){
            Log::error(\Auth::user()->id . "|". $exception->getMessage());
        }
    }
}