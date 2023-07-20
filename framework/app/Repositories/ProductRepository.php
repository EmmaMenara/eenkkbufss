<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 26/07/18
 * Time: 09:02 AM
 */

namespace App\Repositories;

use App\Cms\Branch;
use Illuminate\Database\QueryException;
use Log;
use App\Cms\Product;
use DB;

class ProductRepository
{
    public function all()
    {
        try {
            return Product::all();
        } catch (QueryException $queryException) {
            Log::error(\Auth::user()->id . "|" . $queryException->getMessage());
        } catch (\Exception $exception) {
            Log::error(\Auth::user()->id . "|" . $exception->getMessage());
        }
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $matriz = Branch::findOrFail(1);
//dd($data);
            $inventory['stock_max_branch'] = $data['stock_max_matriz'];
            $inventory['stock_min_branch'] = $data['stock_min_matriz'];
            $inventory['unitprice1'] = $data['unit_price1'];
            //$inventory['unitprice2'] = $data['unitprice2'];
            //$inventory['unitprice3'] = $data['unitprice3'];

            $product = Product::create($data);
            $product->detailsData()->attach($matriz, $inventory);

            DB::commit();
            return $product->id;
        } catch (QueryException $queryException) {
            Log::error(\Auth::user()->id . "|" . $queryException->getMessage());
            dd($queryException->getMessage());
            DB::rollBack();
            return -1;
        } catch (\Exception $exception) {
            Log::error(\Auth::user()->id . "|" . $exception->getMessage());
            DB::rollBack();
            dd($exception->getMessage());
            return -1;
        }
    }

    public function search($name)
    {
        return Product::search($name)->orderBy('name')->get();
    }

    public function destroy($id){
        $obj = Product::findOrFail($id);
        $obj->delete();
        return true;
    }

    public function find($id){
        return Product::findOrFail($id);
    }

    public function update($id,$data){
        try{
            //dd($data);
            DB::beginTransaction();
            $obj = Product::findOrFail($id);
            $obj->fill($data);
            $obj->save();

            DB::table('product_branch')
                ->where([['product_id','=',$obj->id],['branch_id','=','1']])
                ->update(['unitprice1' => $data['unit_price1']]);
            DB::commit();
            return $obj->id;
        }catch (QueryException $queryException){
            DB::rollBack();
            Log::error(\Auth::user()->id . "|". $queryException->getMessage());
            dd($queryException->getMessage());
            return -1;
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error(\Auth::user()->id . "|". $exception->getMessage());
            dd($exception->getMessage());
            return -1;
        }
    }
}