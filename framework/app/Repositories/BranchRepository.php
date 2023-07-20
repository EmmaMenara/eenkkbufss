<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 3/01/19
 * Time: 10:06 PM
 */

namespace App\Repositories;


use App\Cms\Branch;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class BranchRepository
{

    public function all(){
        return Branch::all();
    }

    public function findOrFail($id){
        return Branch::findOrFail($id);
    }

    public function store($data){
        Branch::create($data);
    }

    public function search($name)
    {
        return Branch::search($name)->orderBy('name')->get();
    }

    public function update($data,$id){
        try{
            $obj = Branch::findOrFail($id);
            $obj->fill($data);
            $obj->save();
            return $obj->id;
        }catch (QueryException $queryException){
            Log::error($queryException->getMessage());
            return -1;
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return -2;
        }
    }

    public function destroy($id){
        $obj = Branch::findOrFail($id);
        $obj->delete();
        return true;
    }

}