<?php
/**
 * Created by PhpStorm.
 * User: alda
 * Date: 23/10/18
 * Time: 02:50 AM
 */

namespace App\Repositories;

use App\Cms\CostHistory;
use App\Cms\Customer;
use DB;
use App\Cms\Person;
use App\Cms\Product;
use App\Cms\Sale;

class SalesRepository
{

    public function current()
    {
        $rst = Sale::where([
            ['status', '=', 'nueva'],
            ['create_user', '=', \Auth::user()->id],
            ['branch_id', '=', \Auth::user()->branch_id]
        ])->first();
        if ($rst == null) {
            $data['customers_id'] = Person::PUBLIC_GENERAL;
            $data['create_user'] = \Auth::user()->id;
            $data['branch_id'] = \Auth::user()->branch_id;
            $data['mount'] = 0;
            return Sale::create($data);
        } else {
            return $rst;
        }
    }

    public function addProduct($data)
    {
        //dd($data);
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($data['product_id']);
            if ($product != null) {
                foreach ($product->detailsData($data['branch_id'])->get() as $fila){
                    $existence=($fila->pivot->existence);
                }

                $rst = DB::table('details_sales')
                    ->where([['sale_id', '=', $data['sale_id']],
                        ['product_id', '=', $data['product_id']]
                    ])->get();
                //dd("DE",$rst);
                if ($rst->count() > 0) {
                    dd($existence,$rst[0]->quantity);
                    if ($existence >= ($rst[0]->quantity)) {
                        DB::table('details_sales')
                            ->where([['sale_id', '=', $data['sale_id']],
                                ['product_id', '=', $data['product_id']]
                            ])
                            ->update(['quantity' => DB::raw('quantity + ' . 1)]);
                    } else {
                        DB::commit();
                        throw new \Exception("Producto sin existencias");
                    }
                } else {
                    //dd("TN",$existence);
                    if ($existence >= 1) {
                        DB::table('details_sales')->insert(
                            ['quantity' => 1,
                                'sale_id' => $data['sale_id'],
                                'product_id' => $data['product_id'],
                                'unitprice' => $data['unitprice']]
                        );
                    } else {
                        DB::commit();
                        throw new \Exception("Producto sin existencias");
                    }
                }

                $obj = Sale::find($data['sale_id']);
                $cost = 0;
                foreach ($obj->products as $row) {
                    $cost += ($row->pivot->quantity * $row->pivot->unitprice);
                }
                $obj->mount = $cost;
                $obj->save();

            } else {
                DB::commit();
                throw new \Exception("Producto no existente");
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            throw new \Exception($exception->getMessage());
        }
    }

    public function removeProduct($data)
    {
        try {

            $rst = DB::table('details_sales')->select('quantity')
                ->where([['sale_id', '=', $data['sale_id']],
                    ['product_id', '=', $data['product_id']]
                ])->first();

            if ($rst->quantity > 1) {
                DB::table('details_sales')
                    ->where([['sale_id', '=', $data['sale_id']],
                        ['product_id', '=', $data['product_id']]
                    ])
                    ->update(['quantity' => DB::raw('quantity - ' . 1)]);
            } else {
                DB::table('details_sales')
                    ->where([['sale_id', '=', $data['sale_id']],
                        ['product_id', '=', $data['product_id']]
                    ])->delete();
            }


            $obj = Sale::find($data['sale_id']);
            $cost = 0;
            foreach ($obj->products as $row) {
                $cost += ($row->pivot->quantity * $row->pivot->unitprice);
            }
            $obj->mount = $cost;
            $obj->save();
        } catch (\Exception $exception) {

        }
    }

    public function store($data)
    {
        try {
            DB::beginTransaction();
            $idCustomer=0;
            if(intval($data['customer'])==99999){
                $tmp= new Customer();
                $tmp->create_user=\Auth::user()->id;
                $tmp->update_user=\Auth::user()->id;
                $tmp->status_id = Customer::ACTIVE;
                $tmp->name=$data['name'];
                $tmp->first_surname=$data['firts_name'];
                $tmp->second_surname=$data['second_name'];
                $tmp->save();
                $idCustomer=$tmp->id;
            }else{
                $idCustomer=$data['customer'];
            }
            $obj = Sale::find($data['sale_id']);
            $obj->status = 'cerrada';
            $obj->customers_id=$idCustomer;
            $obj->efectivo = $data['efectivo'];
            $obj->cambio = $data['cambio'];
            $obj->save();
            $sale_id=$obj->id;
            //Proceso para obtener la utilidad de cada producto
            foreach ($obj->products as $row){
                $quantity =$row->pivot->quantity;
                $record = CostHistory::whereRaw('created_at = (select min(`created_at`) from cost_history)')->get();
                if($record->count()>0){
                    $comprados = $record[0]->quantity;
                    $vendidos = $record[0]->sales;
                    $existen=$comprados-$vendidos;
                    if($existen>=$quantity){
                        DB::table('details_sales')
                            ->where([['sale_id', '=', $sale_id],
                                ['product_id', '=', $row->id]
                            ])->update(['unitcost' => $record[0]->unitcost]);
                    }else{

                    }
                }
                DB::table('product_branch')
                    ->where([['product_id', '=', $row->id], ['branch_id', '=', $obj->branch_id]])
                    ->update(['existence' => DB::raw("existence - $quantity")]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }

    public function storecredit($data)
    {
        try {
            DB::beginTransaction();
            $obj = Sale::find($data['sale_id']);
            $obj->status = 'credito';
            $obj->customers_id = $data['customer'];
            $obj->save();
            $sale_id=$obj->id;
            //Proceso para obtener la utilidad de cada producto
            foreach ($obj->products as $row){

                $quantity =$row->pivot->quantity;
                $record = CostHistory::whereRaw('created_at = (select min(`created_at`) from cost_history) and product_id='.$row->id)->get();
                //dd($record);
                if($record->count()>0){
                    $comprados = $record[0]->quantity;
                    $vendidos = $record[0]->sales;
                    $existen=$comprados-$vendidos;
                    if($existen>=$quantity){
                        DB::table('details_sales')
                            ->where([['sale_id', '=', $sale_id],
                                ['product_id', '=', $row->id]
                            ])->update(['unitcost' => $record[0]->unitcost]);
                    }else{

                    }
                }
                DB::table('product_branch')
                    ->where([['product_id', '=', $row->id], ['branch_id', '=', $obj->branch_id]])
                    ->update(['existence' => DB::raw("existence - $quantity")]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            }
    }


    public function newcredit($data)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::create($data);
            $obj = Sale::find($data['sale_id']);
            $obj->status = 'credito';
            $obj->customers_id = $customer->id;
            $obj->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}