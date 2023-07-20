<?php

namespace App\Http\Controllers\master;

use App\Http\Requests\TransferRequest;
use App\Repositories\BranchRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TransferRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class TransferController extends Controller
{
    protected $transfer;
    protected $branch;
    protected $product;

    public function __construct(TransferRepository $transferRepository, BranchRepository $branchRepository,
ProductRepository $productRepository)
    {
        $this->transfer=$transferRepository;
        $this->branch=$branchRepository;
        $this->product=$productRepository;
    }

    public function  index(){
        $rst=$this->transfer->all();
        return view ('pages.master.transfer.index',['search'=>'','data'=>$rst]);
    }

    public function create(){
        try{
            $rst = $this->branch->all();
            $transfer = $this->transfer->current();
            return view('pages.master.transfer.create',['branch'=>$rst,'transfer'=>$transfer,'search'=>'']);
        }catch (\Exception $exception){
            Session::flash('status', 'Incidencia al crear el traslado');
            Session::flash('status_type', 'danger');
            return view ('pages.master.transfer.index');
        }
    }

    public function addItem($codebarAndquantity)
    {
        $data = explode('@', $codebarAndquantity);
        if (count($data) == 2) {
            $data['codebar'] = $data[0];
            $data['quantity'] = $data[1];
            $data['create_user']=\Auth::user()->id;
            $product = $this->product->search($data[0]);
            if(count($product)>0){
                $transfer = $this->transfer->current();
                if($transfer!=null){
                    $data['transfer_id']=$transfer->id;
                    $data['product_id']=$product[0]->id;
                    $obj = $this->transfer->addProduct($data);
                    return '{  "success": true}';
                }else{
                    Session::flash('status', "Incidencia al ingresar el producto al traslado actual.");
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

    public function store(TransferRequest $request){
        if($request->isMethod('post')){
            $data=$request->all();

            $data['create_user']=\Auth::user()->id;
            $data['status']='Validar';
            $data['destino']=$request->get('branch_id');
            $rst=$this->transfer->current();

            $costos=[];
            foreach ($rst->products as $row){
                $costos[]=['product_id'=>$row->id,'price'=>$row->pivot->unitpricesale,'quantity'=>$row->pivot->quantity];
            }
            $data['transfer_id']=$rst->id;
        //    dd($data);
            $this->transfer->store($data,$costos);

            Session::flash('status', "Traslado registrado correctamente.");
            Session::flash('status_type', 'success');
            return redirect(route('transfer.index'));
        }else{
            return redirect(route('transfer.index'));
        }
    }

    public function destroy($id){
        if ($this->transfer->destroy($id)) {
            Session::flash('status', 'Producto eliminado correctamente!');
            Session::flash('status_type', 'success');
        } else {
            Session::flash('status', 'Incidencia al eliminar el producto');
            Session::flash('status_type', 'warning');
        }
        return redirect()->route('transfer.create');
    }

    public function show($id){
        $rst = $this->transfer->findOrFail($id);
        if ($rst->count() > 0) {
            return view('pages.master.transfer.show', ['data' => $rst]);
        } else {
            return view('pages.master.transfer.index');
        }
    }

}
