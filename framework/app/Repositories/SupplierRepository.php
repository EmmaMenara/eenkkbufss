<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 28/07/18
 * Time: 02:38 PM
 */

namespace App\Repositories;

use App\Cms\Supplier;
use Log;

class SupplierRepository
{
    public function all(){
        try{
            return Supplier::all();
        }catch (QueryException $queryException){
            Log::error(\Auth::user()->id . "|". $queryException->getMessage());
        }catch (\Exception $exception){
            Log::error(\Auth::user()->id . "|". $exception->getMessage());
        }
    }

    public function store($data){
        try{
            $obj=Supplier::create($data);
            return $obj->id;
        }catch (\Exception $exception){
            Log::error(\Auth::user()->id . "|". $exception->getMessage());
            dd($exception->getMessage());
            return -1;
        }
    }

    public function find($id){
        return Supplier::findOrFail($id);
    }

    public function update($id,$data){
        try{
            $obj = Supplier::findOrFail($id);
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
        $obj = Supplier::findOrFail($id);
        $obj->delete();
        return true;
    }

    public function search($name)
    {
        return Supplier::search($name)->orderBy('provider_name')->get();
    }
}