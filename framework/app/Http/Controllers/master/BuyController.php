<?php

namespace App\Http\Controllers\master;

use App\Http\Requests\BuyRequest;
use App\Repositories\BuyRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class BuyController extends Controller
{
    protected $provider;
    protected $buy;
    protected $product;

    public function __construct(SupplierRepository $repository, BuyRepository $buyRepository,
            ProductRepository $productRepository)
    {
        $this->provider=$repository;
        $this->buy=$buyRepository;
        $this->product=$productRepository;
    }

    public function  index(){
        $rst=$this->buy->all();
        return view ('pages.master.buy.index',['search'=>'','data'=>$rst]);
    }

    public function create(){
        try{
            $rst = $this->provider->all();
            $buy = $this->buy->current();
            return view('pages.master.buy.create',['supplier'=>$rst,'buy'=>$buy,'search'=>'']);
        }catch (\Exception $exception){
            Session::flash('status', 'Incidencia al crear una compra');
            Session::flash('status_type', 'danger');
            return view ('pages.master.buy.index');
        }
    }

    public function addItem($codebarAndquantity)
    {
        $data = explode('@', $codebarAndquantity);
        if (count($data) == 5) {
            $data['codebar'] = $data[0];
            $data['quantity'] = $data[1];
            $data['unitcost']=$data[2];
            $data['unitpricesale']=$data[3];
            $data['create_user']=\Auth::user()->id;
            /*$aux=explode('-',$data[4]);
            $fecha=$aux[2]."-".$aux[1]."-".$aux[0];*/
            $data['date_buy']=$data[4];
            $product = $this->product->search($data[0]);
            if(count($product)>0){
                $buy = $this->buy->current();
                if($buy!=null){
                    $data['buy_id']=$buy->id;
                    $data['product_id']=$product[0]->id;
                    $obj = $this->buy->addProduct($data);
                    return '{  "success": true}';
                }else{
                    Session::flash('status', "Incidencia al ingresar el producto a la compra actual.");
                    Session::flash('status_type', 'danger');
                    return '{  "success": false}';
                }
            }else{
                Session::flash('status', "El código $data[0] no se encuentra en el sistema");
                Session::flash('status_type', 'danger');
                return '{  "success": false}';
            }
        }else{
            return '{  "success": false}';
        }
    }

    public function store(BuyRequest $request){
        if($request->isMethod('post')){
            $data=$request->all();

            $data['create_user']=\Auth::user()->id;
            $data['status']='registrada';
            $data['proveedor']=$request->get('supplier_id');
            $rst=$this->buy->current();

            $costos=[];
            $mount=0;
            foreach ($rst->products as $row){
                $mount+=($row->pivot->quantity * $row->pivot->unitcost);
                $costos[]=['product_id'=>$row->id,'price'=>$row->pivot->unitpricesale,'quantity'=>$row->pivot->quantity];
            }
            $data['buy_id']=$rst->id;
            $data['mount']=$mount;
            //dd($data);
            $this->buy->store($data,$costos);

            Session::flash('status', "Compra registrada correctamente.");
            Session::flash('status_type', 'success');
            return redirect(route('buy.index'));
        }else{
            return redirect(route('buy.index'));
        }
    }

    public function destroy($id){
        if ($this->buy->destroy($id)) {
            Session::flash('status', 'Producto eliminado correctamente!');
            Session::flash('status_type', 'success');
        } else {
            Session::flash('status', 'Incidencia al eliminar el producto');
            Session::flash('status_type', 'warning');
        }
        return redirect()->route('buy.create');
    }

    public function show($id){
        $rst = $this->buy->findOrFail($id);
        if ($rst->count() > 0) {
            return view('pages.master.buy.show', ['data' => $rst]);
        } else {
            return view('pages.master.buy.index');
        }
    }
}
