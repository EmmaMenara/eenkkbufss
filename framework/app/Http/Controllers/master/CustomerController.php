<?php

namespace App\Http\Controllers\master;

use App\Cms\Customer;
use App\Http\Requests\CustomerRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\PersonRepository;
use App\Repositories\TypeCustomerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class CustomerController extends Controller
{
    protected $customer;
    protected $person;
    protected $typeCustomer;

    public function __construct(CustomerRepository $customerRepository,
                                PersonRepository $personRepository,
                                TypeCustomerRepository $typeCustomerRepository)
    {
        $this->customer = $customerRepository;
        $this->person = $personRepository;
        $this->typeCustomer = $typeCustomerRepository;
    }

    public function index(Request $request)
    {
        $search = "";
        $limit = 20;
        $currentPage = 1;
        if ($request->has('search')) {
            $search = $request->input('search');
            if (trim($search) != '') {
                $data = $this->customer->search($search);
            } else {
                $data = $this->customer->all();
            }
        } else {
            $data = $this->customer->all();
        }
        $currentPage = Paginator::resolveCurrentPage() - 1;
        $perPage = $limit;
        $currentPageSearchResults = $data->slice($currentPage * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageSearchResults, count($data), $perPage);

        $currentPage = 1;
        return view('pages.master.customer.index', ['data' => $data, 'search' => $search, 'page' => $currentPage]);
    }

    public function create()
    {
        try {
            return view('pages.master.customer.create');
        } catch (\Exception $exception) {
            return redirect(route('customer.index'));
        }
    }

    public function store(CustomerRequest $request)
    {
        if ($request->isMethod('post')) {
            $data['name'] = $request->input('name');
            $data['first_surname'] = $request->input('first_surname');
            $data['second_surname'] = $request->input('second_surname');
            $data['create_user'] = \Auth::user()->id;
            $data['update_user'] = \Auth::user()->id;
            $data['status_id'] = Customer::ACTIVE;
            $this->customer->store($data);
            Session::flash('status', 'Cliente registrado correctamente!');
            Session::flash('status_type', 'success');
            return redirect(route('customer.index'));
        } else {
            return redirect(route('customer.index'));
        }
    }

    public function edit($id)
    {
        try {
            $obj = $this->customer->find($id);
            return view('pages.master.customer.edit',['data'=>$obj]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect(route('customer.index'));
        }
    }

    public function update(CustomerRequest $request,$id)
    {
        if ($request->isMethod('put')) {
            $data['name'] = $request->input('name');
            $data['first_surname'] = $request->input('first_surname');
            $data['second_surname'] = $request->input('second_surname');
            $data['update_user'] = \Auth::user()->id;
            $this->customer->update($id,$data);
            Session::flash('status', 'Cliente actualizado correctamente!');
            Session::flash('status_type', 'success');
            return redirect(route('customer.index'));
        } else {
            return redirect(route('customer.index'));
        }
    }

    public function destroy($id){
        if ($this->customer->destroy($id)) {
            Session::flash('status', 'Cliente eliminado correctamente!');
            Session::flash('status_type', 'success');
        } else {
            Session::flash('status', 'Incidencia al eliminar el cliente');
            Session::flash('status_type', 'warning');
        }
        return redirect()->route('customer.index');
    }
}
