<?php

namespace App\Http\Controllers\master;

use App\Http\Requests\BrandRequest;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class BrandController extends Controller
{
    protected $brand;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brand=$brandRepository;
    }

    public function index(Request $request)
    {
        $search = "";
        $limit = 20;
        $currentPage = 1;
        if ($request->has('search')) {
            $search = $request->input('search');
            if (trim($search) != '') {
                $data = $this->brand->search($search);
            } else {
                $data = $this->brand->all();
            }
        } else {
            $data = $this->brand->all();
        }
        $currentPage = Paginator::resolveCurrentPage() - 1;
        $perPage = $limit;
        $currentPageSearchResults = $data->slice($currentPage * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageSearchResults, count($data), $perPage);

        $currentPage = 1;
        return view('pages.master.brand.index', ['data' => $data, 'search' => $search, 'page' => $currentPage]);
    }

    public function create()
    {
        try {
            return view('pages.master.brand.create');
        } catch (\Exception $exception) {
            return redirect(route('brand.index'));
        }
    }

    public function store(BrandRequest $request)
    {
        if ($request->isMethod('post')) {
            $data['name'] = $request->input('name');
            $data['create_user'] = \Auth::user()->id;
            $data['update_user'] = \Auth::user()->id;
            $this->brand->store($data);
            Session::flash('status', 'Marca registrada correctamente!');
            Session::flash('status_type', 'success');
            return redirect(route('brand.index'));
        } else {
            return redirect(route('brand.index'));
        }
    }

    public function edit($id)
    {
        try {
            $obj = $this->brand->find($id);
            return view('pages.master.brand.edit',['data'=>$obj]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect(route('brand.index'));
        }
    }

    public function update(BrandRequest $request,$id)
    {
        if ($request->isMethod('put')) {
            $data['name'] = $request->input('name');
            $data['update_user'] = \Auth::user()->id;
            $this->brand->update($id,$data);
            Session::flash('status', 'Marca actualizada correctamente!');
            Session::flash('status_type', 'success');
            return redirect(route('brand.index'));
        } else {
            return redirect(route('brand.index'));
        }
    }

    public function destroy($id){
        if ($this->brand->destroy($id)) {
            Session::flash('status', 'Marca eliminada correctamente!');
            Session::flash('status_type', 'success');
        } else {
            Session::flash('status', 'Incidencia al eliminar la marca');
            Session::flash('status_type', 'warning');
        }
        return redirect()->route('brand.index');
    }
}
