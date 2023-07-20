<?php

namespace App\Http\Controllers\master;

use App\Cms\Customer;
use App\Http\Requests\CustomCreditRequest;
use App\Http\Requests\NewCreditRequest;
use App\Http\Requests\SaleRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\SupplierRepository;
use Session;
use App\Repositories\ProductRepository;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesController extends Controller
{
    protected $product;
    protected $sales;
    protected $customer;

    public function __construct(ProductRepository $productRepository,
                                SalesRepository $salesRepository,
                                CustomerRepository $customerRepository)
    {
        $this->product = $productRepository;
        $this->sales = $salesRepository;
        $this->customer = $customerRepository;
    }

    public function index(Request $request)
    {
        $search = "";
        $limit = 20;
        $currentPage = 1;
        if ($request->has('search')) {
            $search = $request->input('search');
            if (trim($search) != '') {
                $data = $this->product->search($search);
            } else {
                $data = $this->product->all();
            }
        } else {
            $data = $this->product->all();
        }
        $currentPage = Paginator::resolveCurrentPage() - 1;
        $perPage = $limit;
        $currentPageSearchResults = $data->slice($currentPage * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageSearchResults, count($data), $perPage);
        //return view('pages.master.product.index', ['data' => $data, 'search' => $search, 'page' => $currentPage]);

        $sale = $this->sales->current();
        $quantityProducts = 0;
        if ($sale->count() > 0) {
            //dd($sale->products()->get(),"E");
            foreach ($sale->products as $row) {
                $quantityProducts += $row->pivot->quantity;
              //  dd($row);
            }
        }
        return view('pages.shared.sales.index', ['data' => $data, 'sale' => $sale, 'total' => $quantityProducts, 'page' => $currentPage]);
    }

    public function addProduct(Request $request)
    {
        try {
            $data['sale_id'] = $request->get('assestId');
            $data['product_id'] = $request->get('key');
            $data['unitprice'] = $request->get('c');
            $data['branch_id'] = \Auth::user()->branch_id;
            $this->sales->addProduct($data);
        } catch (\Exception $exception) {
            Session::flash('status', $exception->getMessage());
            Session::flash('status_type', 'warning');
        }
        return redirect(route('sales.index'));
    }

    public function removeProduct(Request $request)
    {
        try {
            $data['sale_id'] = $request->get('assestId');
            $data['product_id'] = $request->get('key');
            $this->sales->removeProduct($data);
            return redirect(route('sales.index'));
        } catch (\Exception $exception) {

        }
    }

    public function receivable()
    {
        $sale = $this->sales->current();
        $customer = $this->customer->all();
        return view('pages.shared.sales.receivable', ['sale' => $sale,'customer'=>$customer]);
    }

    public function credit()
    {
        $sale = $this->sales->current();
        $customer = $this->customer->all();
        return view('pages.shared.sales.credit', ['sale' => $sale, 'customer' => $customer]);
    }

    public function store(SaleRequest $request)
    {
       // dd("CONT");
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $sale = $this->sales->current();
                $data['sale_id'] = $sale->id;
             //   dd($data);
                $this->sales->store($data);
                Session::flash('status', 'Venta generada');
                Session::flash('status_type', 'success');
                return redirect(route('sales.index'));
            } catch (\Exception $exception) {
                Session::flash('status', 'Incidencia al guardar la venta');
                Session::flash('status_type', 'danger');
                return redirect(route('sales.index'));
            }
        } else {
            return redirect(route('sales.index'));
        }

    }


    public function storecredit(CustomCreditRequest $request)
    {
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $sale = $this->sales->current();
                $data['sale_id'] = $sale->id;
                //dd($data);
                $this->sales->storecredit($data);
                Session::flash('status', 'Venta generada a crédito');
                Session::flash('status_type', 'success');
                return redirect(route('sales.index'));
            } catch (\Exception $exception) {
                Session::flash('status', 'Incidencia al guardar la venta');
                Session::flash('status_type', 'danger');
                dd($exception->getMessage());
                return redirect(route('sales.index'));
            }
        } else {
            return redirect(route('sales.index'));
        }

    }

    public function newcredit(NewCreditRequest $request)
    {
        if ($request->isMethod('post')) {
            try {

                $sale = $this->sales->current();
                $data['name'] = $request->input('name');
                $data['first_surname'] = $request->input('firts_name');
                $data['second_surname'] = $request->input('second_name');
                $data['sale_id'] = $sale->id;
                $data['create_user'] =\Auth::user()->id;
                $data['update_user'] =\Auth::user()->id;
                $data['status_id'] = Customer::ACTIVE;
                $this->sales->newcredit($data);
                Session::flash('status', 'Venta generada. Cŕedito aperturado');
                Session::flash('status_type', 'success');
                return redirect(route('sales.index'));
            } catch (\Exception $exception) {
                Session::flash('status', 'Incidencia al guardar la venta');
                Session::flash('status_type', 'danger');
                return redirect(route('sales.index'));
            }
        } else {
            return redirect(route('sales.index'));
        }

    }
}
