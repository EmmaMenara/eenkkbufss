<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 5/01/19
 * Time: 10:21 PM
 */

namespace App\Repositories;

use App\Cms\Product;
use DB;
use App\Cms\Transfer;

class TransferRepository
{
    public function all()
    {
        return Transfer::all();
    }

    public function current()
    {
        $rst = Transfer::where([['status', '=', 'nueva'], ['create_user', '=', \Auth::user()->id]])->first();
        if ($rst == null) {
            $data['create_user'] = \Auth::user()->id;
            return Transfer::create($data);
        } else {
            return $rst;
        }
    }

    public function addProduct($data)
    {
        try {
            DB::beginTransaction();
            $prod = Product::find($data['product_id']);
            $precio = 0;

            foreach ($prod->detailsData(1)->get() as $record) {
                if ($record->pivot->branch_id === 1) {
                    $precio = $record->pivot->unitprice1;
                    $costo = $prod->costo;
                    break;
                }
            }

            $rst = DB::table('details_transfer')
                ->where([['transfer_id', '=', $data['transfer_id']],
                    ['product_id', '=', $data['product_id']]
                ])->get();
            if ($rst->count() > 0) {

                DB::table('details_transfer')
                    ->where([['transfer_id', '=', $data['transfer_id']],
                        ['product_id', '=', $data['product_id']]
                    ])
                    ->update(['quantity' => DB::raw('quantity + ' . $data['quantity']), 'unitpricesale' => "$precio", 'unitcost'=>"$costo"]);
            } else {
                DB::table('details_transfer')->insert(
                    ['quantity' => $data['quantity'],
                        'transfer_id' => $data['transfer_id'],
                        'product_id' => $data['product_id'],
                        'unitpricesale' => $precio,
                        'unitcost'=>$costo]
                );
            }
            DB::commit();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            DB::rollBack();
        }
    }

    public function store($data, $products)
    {
        try {
            //dd($products,$data);
            DB::beginTransaction();
            $obj = Transfer::find($data['transfer_id']);
            $obj->status = $data['status'];
            $obj->branch_id = $data['destino'];
            $obj->save();
            for ($i = 0; $i < count($products); $i++) {
                $product = Product::find($products[$i]['product_id']);
                if ($product != null) {
                    $cantidad = $products[$i]['quantity'];
                    $precio = str_replace(',', '', $products[$i]['price']);
                    $precio = str_replace('$', '', $precio);

                    $record = DB::table('product_branch')
                        ->where([['product_id', '=', $product->id], ['branch_id', '=', $data['destino']]])
                        ->get();
                    if ($record->count() == 0) {
                        DB::table('product_branch')->insert(
                            ['branch_id' => $data['destino'],
                                'product_id' => $product->id,
                                'unitprice1' => $precio,
                                'existence'=>$cantidad]
                        );
                    } else {
                        DB::table('product_branch')
                            ->where([['product_id', '=', $product->id], ['branch_id', '=', $data['destino']]])
                            ->update(['existence' => DB::raw("existence + $cantidad"), 'unitprice1' => $precio]);
                    }
                    //Lo sacamos de Matriz
                    DB::table('product_branch')
                        ->where([['product_id', '=', $product->id], ['branch_id', '=', 1]])
                        ->update(['existence' => DB::raw("existence - $cantidad")]);
                }
            }
            /*
            foreach ($obj->products as $row){
                $cost = new CostHistory();
                $cost->product_id= $row->id;
                $cost->quantity=$row->pivot->quantity;
                $cost->unitcost=$row->pivot->unitcost;
                $cost->unitpricesale=$row->pivot->unitpricesale;
                $cost->save();
            }
            */
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function destroy($product_id)
    {
        $current = $this->current();
        DB::table('details_transfer')->where([['product_id', '=', $product_id], ['transfer_id', '=', $current->id]])->delete();
        return true;
    }


    public function findOrFail($id)
    {
        return Transfer::find($id);
    }
}