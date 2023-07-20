<?php

namespace App\Http\Controllers\master;

use App\Http\Requests\ProviderRequest;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class ProviderController extends Controller
{
    protected $supplier;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplier = $supplierRepository;
    }

    public function index(Request $request)
    {
        $search = "";
        $limit = 20;
        $currentPage = 1;
        if ($request->has('search')) {
            $search = $request->input('search');
            if (trim($search) != '') {
                $data = $this->supplier->search($search);
            } else {
                $data = $this->supplier->all();
            }
        } else {
            $data = $this->supplier->all();
        }
        $currentPage = Paginator::resolveCurrentPage() - 1;
        $perPage = $limit;
        $currentPageSearchResults = $data->slice($currentPage * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageSearchResults, count($data), $perPage);
        return view('pages.master.supplier.index', ['data' => $data, 'search' => $search, 'page' => $currentPage]);
    }

    public function create()
    {
        try {
            return view('pages.master.supplier.create');
        } catch (\Exception $exception) {
            return redirect(route('provider.index'));
        }
    }

    public function store(ProviderRequest $request){

        if ($request->isMethod('post')) {
            $data['provider_name']=$request->input('company');
            $data['contact_name']=$request->input('name');
            $data['contact_first_surname']=$request->input('first_surname');
            $data['contact_second_surname']=$request->input('second_name');
            $data['mobile']=$request->input('mobile');
            $data['rfc']=$request->input('rfc');
            $data['phone_number']=$request->input('phonenumber');
            $data['create_user']=\Auth::user()->id;
            $data['update_user']=\Auth::user()->id;
            $this->supplier->store($data);
            Session::flash('status', 'Proveedor registrado correctamente!');
            Session::flash('status_type', 'success');
            return redirect(route('provider.index'));
        } else {
            return redirect(route('provider.index'));
        }
    }


    public function edit($id)
    {
        try {
            $obj = $this->supplier->find($id);
            return view('pages.master.supplier.edit',['data'=>$obj]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect(route('provider.index'));
        }
    }

    public function update(ProviderRequest $request,$id)
    {
        if ($request->isMethod('put')) {
            $data['provider_name']=$request->input('company');
            $data['contact_name']=$request->input('name');
            $data['contact_first_surname']=$request->input('first_surname');
            $data['contact_second_surname']=$request->input('second_name');
            $data['mobile']=$request->input('mobile');
            $data['rfc']=$request->input('rfc');
            $data['phone_number']=$request->input('phonenumber');
            $data['update_user']=\Auth::user()->id;
            $this->supplier->update($id,$data);
            Session::flash('status', 'Proveedor actualizado correctamente!');
            Session::flash('status_type', 'success');
            return redirect(route('provider.index'));
        } else {
            return redirect(route('provider.index'));
        }
    }

    public function destroy($id){
        if ($this->supplier->destroy($id)) {
            Session::flash('status', 'Proveedor eliminado correctamente!');
            Session::flash('status_type', 'success');
        } else {
            Session::flash('status', 'Incidencia al eliminar el proveedor');
            Session::flash('status_type', 'warning');
        }
        return redirect()->route('provider.index');
    }
}
