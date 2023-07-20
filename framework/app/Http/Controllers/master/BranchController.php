<?php

namespace App\Http\Controllers\master;

use App\Http\Requests\BranchRequest;
use App\Repositories\BranchRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class BranchController extends Controller
{

    protected $branch;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branch = $branchRepository;
    }

    public function index(Request $request)
    {
        $search = "";
        $limit = 20;
        $currentPage = 1;
        $id_kiosks = 1;
        if ($request->has('search')) {
            $search = $request->input('search');
            if (trim($search) != '') {
                $data = $this->branch->search($search);
            } else {
                $data = $this->branch->all();// Products::paginate(50);
            }
        } else {
            $data = $this->branch->all(); //Products::paginate(50);
        }
        $currentPage = Paginator::resolveCurrentPage() - 1;
        $perPage = $limit;
        $currentPageSearchResults = $data->slice($currentPage * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageSearchResults, count($data), $perPage);
        return view('pages.master.branch.index', ['data' => $data, 'search' => $search, 'page' => $currentPage]);
    }

    public function create()
    {
        return view('pages.master.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        if(trim($request->input('name'))!=''){
            $data['name']=$request->input('name');
            $data['direction']=$request->input('direction');
            $this->branch->store($data);
            Session::flash('status', 'Tienda registrada correctamente!');
            Session::flash('status_type','success');
            return redirect(route('branch.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data= $this->branch->findOrFail($id);
        return view('pages.master.branch.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, $id)
    {/*
        $category = Kiosks::findOrFail($id);
        $category->fill($request->all());
        $category->save();*/
        if($this->branch->update($request->all(),$id)>0){
            Session::flash('status', 'Tienda actualizada correctamente!');
            Session::flash('status_type','success');
        }else{
            Session::flash('status', 'Incidencia al actualizar los datos');
            Session::flash('status_type','danger');
        }

        return  redirect()->route('branch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->branch->destroy($id)) {
            Session::flash('status', 'Sucursal eliminada correctamente!');
            Session::flash('status_type', 'success');
        } else {
            Session::flash('status', 'Incidencia al eliminar la sucursal');
            Session::flash('status_type', 'warning');
        }
        return redirect()->route('branch.index');
    }
}
