<?php

namespace App\Http\Controllers;

use App\Cms\Sale;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $customer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->middleware('auth');
        $this->customer = $customerRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fiados = Sale::where('status','=','crédito')->get();
         return view('dashboard',['fiados'=>$fiados]);
    }
}
