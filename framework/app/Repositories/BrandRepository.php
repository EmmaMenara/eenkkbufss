<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 2/11/18
 * Time: 01:59 PM
 */

namespace App\Repositories;

use Log;
use App\Cms\Brand;

class BrandRepository
{

    public function all(){
        try{
            return Brand::all();
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
            $obj=Brand::create($data);
            return $obj->id;
        }catch (\Exception $exception){
            Log::error(\Auth::user()->id . "|". $exception->getMessage());
            dd($exception->getMessage());
            return -1;
        }
    }

    public function find($id){
        return Brand::findOrFail($id);
    }

    public function update($id,$data){
        try{
            $obj = Brand::findOrFail($id);
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
        $obj = Brand::findOrFail($id);
        $obj->delete();
        return true;
    }

}