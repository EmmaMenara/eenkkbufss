<?php

namespace App\Http\Controllers;

use App\Cms\Customer;
use App\Cms\Sale;
use Illuminate\Http\Request;
use Session;


class ReportController extends Controller
{

    public function index()
    {
        return view('pages.master.reports.index');
    }

    public function fiados()
    {
        //$creditos=Sale::distinct('customers_id')->count('customers_id');
        $creditos = Sale::select('customers_id')->groupBy('customers_id')->where('status', '=', 'credito')->get();
        $key = [];
        //dd($creditos);
        foreach ($creditos as $row) {
            $key[] = $row->customers_id;
        }
        //dd($key);
        $clientes = Customer::whereIn('id', $key)->get();
//dd($clientes);
        return view('pages.master.reports.fiados', ['creditos' => $clientes]);
    }

    public function detalleFiado($id)
    {
        try {
            if (is_numeric($id)) {
                $rst = Sale::where([['status', '=', 'credito'], ['customers_id', '=', $id]])->get();
                $customer = Customer::findOrFail($id);
                return view('pages.master.reports.detalleFiado', ['data' => $rst,'customer'=>$customer]);
            } else {
                Session::flash('status', 'Incidencia al guardar la venta');
                Session::flash('status_type', 'danger');
            }
            return redirect('reports.index');
        } catch (\Exception $exception) {

        }
    }

    public function sales(Request $request)
    {
        try {
            $efectivo = 0;
            $credito = 0;
            $debito = 0;
            $clip = 0;
            $devoluciones = 0;
            if ($request->isMethod('POST')) {

                $aux = explode('-', $request->input('home'));
                $home = $aux[2] . "-" . $aux[1] . "-" . $aux[0] . " 00:00:00";
                $aux = explode('-', $request->input('end'));
                $end = $aux[2] . "-" . $aux[1] . "-" . $aux[0] . " 23:59:59";
                $dateHome = date('Y-m-d 00:00:00', strtotime($home));
                $dateEnd = date('Y-m-d 23:59:59', strtotime($end));
            } else {

                $dateHome = date('Y-m-d 00:00:00');
                $dateEnd = date('Y-m-d 23:59:59');
            }
            $data = Sale::where([
                ['branch_id', '=', \Auth::user()->branch_id],
                ['created_at', '>=', "$dateHome"],
                ['created_at', '<=', "$dateEnd"]])->get();
            foreach ($data as $row) {
                if ($row->cancel != 1) {
                    $method = $row->methodpayment;
                    if (substr($method, 0, 8) === "Efectivo") {
                        $efectivo += $row->subtotal + $row->iva;
                    }
                    if (substr($method, 0, 13) === "Tarjeta de cr") {
                        $credito += $row->subtotal + $row->iva;
                    }
                    if (substr($method, 0, 12) === "Tarjeta de d") {
                        $debito += $row->subtotal + $row->iva;
                    }
                    if (substr($method, 0, 4) === "Clip") {
                        $clip += $row->subtotal + $row->iva;
                    }
                }
            }
            return view('pages.master.reports.sales', ['data' => $data, 'home' => $dateHome, 'end' => $dateEnd,
                'efectivo' => $efectivo,
                'debito' => $debito,
                'credito' => $credito,
                'clip' => $clip,
                'devoluciones' => $devoluciones,
                'total' => (($efectivo + $debito + $credito + $clip) - $devoluciones)]);


        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect(route('reports.index'));
        }
    }
}
