<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 27/10/18
 * Time: 06:42 PM
 */

namespace App\Repositories;

use App\Cms\Buy;
use App\Cms\CostHistory;
use App\Cms\Product;
use DB;

class BuyRepository
{

    public function all(){
        try{
            return Buy::where('status','!=','nueva')->get();
        }catch (\Exception $exception){
            return null;
        }
    }

    public function current()
    {
        $rst = Buy::where([['status', '=', 'nueva'], ['create_user', '=', \Auth::user()->id]])->first();
        if ($rst == null) {
            $data['create_user'] = \Auth::user()->id;
            $data['mount'] = 0;
            return Buy::create($data);
        } else {
            return $rst;
        }
    }

    public function addProduct($data)
    {
        try {
            DB::beginTransaction();
            $rst = DB::table('details_buy')
                ->where([['buy_id', '=', $data['buy_id']],
                    ['product_id', '=', $data['product_id']]
                ])->get();
            if ($rst->count() > 0) {
                DB::table('details_buy')
                    ->where([['buy_id', '=', $data['buy_id']],
                        ['product_id', '=', $data['product_id']]
                    ])
                    ->update(['quantity' => DB::raw('quantity + ' . $data['quantity'])]);
            } else {
                DB::table('details_buy')->insert(
                    ['quantity' => $data['quantity'],
                        'buy_id' => $data['buy_id'],
                        'product_id' => $data['product_id'],
                        'unitcost' => $data['unitcost'],
                        'unitpricesale' => $data['unitpricesale']]
                );
            }
            $prod= Product::find($data['product_id']);
            $prod->costo=$data['unitcost'];
            $prod->save();

            $obj = Buy::find($data['buy_id']);
            $cost = 0;
            foreach ($obj->products as $row) {
                $cost += ($row->pivot->quantity * $row->pivot->unitcost);
            }
//dd($data);
            $obj->mount = $cost;
            $obj->date_buy = $data['date_buy'];
            $obj->save();
            DB::commit();
  //          dd("OK");
        } catch (\Exception $exception) {
    //        dd($exception->getMessage());
            DB::rollBack();
        }
    }

    public function store($data,$products){
        try{
            //dd($products,$data);
            DB::beginTransaction();
            $obj = Buy::find($data['buy_id']);
            $obj->mount=$data['mount'];
            $obj->status=$data['status'];
            $obj->supplier_id=$data['proveedor'];
            $obj->num_docto=$data['num_docto'];
            $obj->save();
            for ($i=0;$i<count($products);$i++){
                $product=Product::find($products[$i]['product_id']);
                if($product!=null){
                    $cantidad=$products[$i]['quantity'];
                    $precio=str_replace(',','',$products[$i]['price']);
                    $precio=str_replace('$','',$precio);
                    //dd($product);
                    DB::table('product_branch')
                        ->where([['product_id', '=',$product->id],['branch_id','=',1]])
                        ->update(['existence' => DB::raw( "existence + $cantidad"),'unitprice1'=>$precio]);
                }
            }
            //dd($obj->products);
            foreach ($obj->products as $row){
                $cost = new CostHistory();
                $cost->product_id= $row->id;
                $cost->quantity=$row->pivot->quantity;
                $cost->unitcost=$row->pivot->unitcost;
                $cost->unitpricesale=$row->pivot->unitpricesale;
                $cost->save();
            }
            DB::commit();
            //dd("OKs");
        }catch (\Exception $exception){
            DB::rollBack();
            //dd($exception->getMessage());
        }
    }

    public function destroy($product_id){
        $current = $this->current();
        DB::table('details_buy')->where([['product_id', '=', $product_id],['buy_id','=',$current->id]])->delete();
        return true;
    }

    public function findOrFail($id)
    {
        return Buy::find($id);
    }
}