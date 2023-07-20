<?php

namespace App\Http\Controllers\master;

use App\Cms\Branch;
use App\Http\Requests\ProductRequest;
use App\Repositories\BranchRepository;
use App\Repositories\BrandRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    protected $product;
    protected $brand;
    protected $branch;

    public function __construct(ProductRepository $productRepository,
            BrandRepository $brandRepository, BranchRepository $branchRepository)
    {
        $this->product = $productRepository;
        $this->brand = $brandRepository;
        $this->branch = $branchRepository;
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
        return view('pages.master.product.index', ['data' => $data, 'search' => $search, 'page' => $currentPage]);
    }

    public function create(){
        try{
            $rst = $this->brand->all();
            return view('pages.master.product.create',['brands'=>$rst]);
        }catch (\Exception $exception){
            return redirect(route('product.index'));
        }
    }

    public function search(Request $request){
        $search= $request->input('txtSearch');
        $data = $this->product->search($search);
        return view('pages.shared.sales.index',['data'=>$data]);
    }

    public function store(ProductRequest $request){
        if($request->isMethod('post')){
            try{
                if ($request->file('photo') != null) {
                    $mime = "";
                    try {
                        $mime = $request->file('photo')->getMimeType();
                    } catch (\Exception $ex) {
                        return redirect(route('products.create'));
                    }
                    $name = strtolower($request->file('photo')->getClientOriginalName());
                    $name = str_replace(' ', '_', $name);
                    $path = base_path() . '/productos/';
                    $request->file('photo')->move($path, $name);
                } else {
                    $name = 'default.png';
                }
                $data['create_user']=\Auth::user()->id;
                $data['update_user']=\Auth::user()->id;
                $data['brand_id']=$request->input('brand_id');
                $data['codeinner'] = $request->input('codeinner');
                $data['codebar'] = $request->input('codebar');
                $data['name'] = $request->input('name');
                $data['stock_max_matriz'] = $request->input('stockmax');
                $data['stock_min_matriz'] = $request->input('stockmin');
                $data['photo'] = $name;
                $data['genero']=$request->input('genero');
                $data['tipo']=$request->input('tipo');
                $data['color']=$request->input('color');
                $data['talla']=$request->input('talla');
                $data['costo']=$request->input('costo');
                $data['unit_price1'] = ($request->input('price'));// * config('globals.IVA'));

               //dd( $data,$request->all());

                $key=$this->product->store($data);
                if (intval($key) > 0) {
                    Session::flash('status', 'Producto registrado correctamente!');
                    Session::flash('status_type', 'success');
                    return redirect(route('product.index'));
                } else {
                    Session::flash('status', 'Incidencia al registrar el producto');
                    Session::flash('status_type', 'warning');
                    return redirect(route('product.index'));
                }
            }catch (\Exception $exception){

            }
        }else{
            return redirect(route('product.index'));
        }
    }

    public function destroy($id){
        if ($this->product->destroy($id)) {
            Session::flash('status', 'Producto eliminado correctamente!');
            Session::flash('status_type', 'success');
        } else {
            Session::flash('status', 'Incidencia al eliminar el producto');
            Session::flash('status_type', 'warning');
        }
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        try {
            $obj = $this->product->find($id);
            $rst = $this->brand->all();
            return view('pages.master.product.edit',['data'=>$obj,'brands'=>$rst]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect(route('product.index'));
        }
    }

    public function update(ProductRequest $request,$id)
    {
        if ($request->isMethod('put')) {
            try {
                if ($request->file('photo') != null) {
                    $mime = "";
                    try {
                        $mime = $request->file('photo')->getMimeType();
                    } catch (\Exception $ex) {
                        return redirect(route('products.create'));
                    }
                    $name = strtolower($request->file('photo')->getClientOriginalName());
                    $name = str_replace(' ', '_', $name);
                    $path = base_path() . '/productos/';
                    $request->file('photo')->move($path, $name);
                    $data['photo'] = $name;
                }
                $data['create_user'] = \Auth::user()->id;
                $data['update_user'] = \Auth::user()->id;
                $data['brand_id']=$request->input('brand_id');
                $data['codeinner'] = $request->input('codeinner');
                $data['codebar'] = $request->input('codebar');
                $data['name'] = $request->input('name');
                $data['stock_max_matriz'] = $request->input('stockmax');
                $data['stock_min_matriz'] = $request->input('stockmin');
                $data['genero']=$request->input('genero');
                $data['tipo']=$request->input('tipo');
                $data['color']=$request->input('color');
                $data['talla']=$request->input('talla');
                $data['costo']=$request->input('costo');
                $data['unit_price1'] = ($request->input('price'));// * config('globals.IVA'));

                $this->product->update($id, $data);
                Session::flash('status', 'Producto actualizado correctamente!');
                Session::flash('status_type', 'success');
                return redirect(route('product.index'));
            }catch (\Exception $exception){
                Session::flash('status', 'Incidencia al actualizar el producto!'.$exception->getMessage());
                Session::flash('status_type', 'danger');
                return redirect(route('product.index'));
            }
        } else {
            return redirect(route('product.index'));
        }
    }

    public function inventory(Request $request){
        $search = "";
        $limit = 20;
        $currentPage = 1;
        $id_branch = \Auth::user()->branch_id;
        if ($request->has('tienda')) {
            if (is_numeric(trim($request->input("tienda")))) {
                $id_branch = trim($request->input("tienda"));
            }
        }
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
        $branch = $this->branch->all();
        $active = $this->branch->findOrFail($id_branch);
        $currentPage = Paginator::resolveCurrentPage() - 1;
        $perPage = $limit;
        $currentPageSearchResults = $data->slice($currentPage * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageSearchResults, count($data), $perPage);
        return view('pages.master.product.inventory', ['data' => $data,
            'branch'=>$branch,'sucursal'=>$active, 'search' => $search, 'page' => $currentPage]);
    }

    public function autocomplete(Request $request)
    {
        $term = str_replace("'", "''", strtolower($request->input('query')));
        $results = array();
        $rst = $this->product->search($term, true, 50);
        foreach ($rst as $row) {
            $results[] = ['value' => str_pad($row->codebar, 13, "0", STR_PAD_LEFT) . "|" . $row->name, 'data' => $row->codebar];
        }
        $results = ['suggestions' => $results];
        return json_encode($results, JSON_UNESCAPED_UNICODE);
    }


    public function layout(Request $request)
    {
        if ($request->isMethod("post")) {
            $counter = 1;
            $documento = new Spreadsheet();
            $documento
                ->getProperties()
                ->setCreator("789.mx")
                ->setLastModifiedBy('ALDA') // última vez modificado por
                ->setTitle('Layout para carga masiva de productos')
                ->setSubject('Carga masiva')
                ->setCategory('Layout');

            $hoja = $documento->getActiveSheet();
            $hoja->setTitle("Productos");
            //$hoja->setCellValueByColumnAndRow(1, 1, "Un valor en 1, 1");
            $hoja->setCellValue("A1", "NEGOCIO");//CATEGORÍA
            $hoja->setCellValue("B1", "MARCA");
            $hoja->setCellValue("C1", "CÓDIGO DE BARRAS");
            $hoja->setCellValue("D1", "CODIGO INTERNO");
            $hoja->setCellValue("E1", "NOMBRE");
            $hoja->setCellValue("F1", "GENERO");
            $hoja->setCellValue("G1", "TIPO");
            $hoja->setCellValue("H1", "COLOR");
            $hoja->setCellValue("I1", "TALLA");
            $hoja->setCellValue("J1", "COSTO");
            $hoja->setCellValue("K1", "STOCK MÍNIMO");
            $hoja->setCellValue("L1", "STOCK MÁXIMO");
            $hoja->setCellValue("M1", "PRECIO DE VENTA");
            $hoja->getColumnDimension("A")->setWidth(18);
            $hoja->getColumnDimension("B")->setWidth(18);
            $hoja->getColumnDimension("C")->setWidth(18);
            $hoja->getColumnDimension("D")->setWidth(18);
            $hoja->getColumnDimension("E")->setWidth(30);
            $hoja->getColumnDimension("F")->setWidth(18);
            $hoja->getColumnDimension("G")->setWidth(18);
            $hoja->getColumnDimension("H")->setWidth(18);
            $hoja->getColumnDimension("I")->setWidth(18);
            $hoja->getColumnDimension("J")->setWidth(18);
            $hoja->getColumnDimension("K")->setWidth(18);
            $hoja->getColumnDimension("L")->setWidth(18);
            $hoja->getColumnDimension("M")->setWidth(18);

            $oCategory = $this->brand->all();
            $indice = 2;
            foreach ($oCategory as $row):
                $value = $row->name;
                $key = $row->id;
                $hoja->setCellValue('LA' . $indice, $key);
                $hoja->setCellValue('LB' . $indice, $value);
                $indice++;
            endforeach;
            $indice--;
            $documento->addNamedRange(new \PhpOffice\PhpSpreadsheet\NamedRange('marcas', $documento->getActiveSheet(), "LB2:LB$indice"));


            $home = 2;
            $end = 501;
            for ($i = $home; $i < $end; $i++) {
                $objValidation = $documento->getActiveSheet()->getCell("B$i")->getDataValidation();
                $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Dato incorrecto');
                $objValidation->setError('El valor se encuentra en la lista.');
                $objValidation->setPromptTitle('Marcas registradas en el sistema');
                $objValidation->setPrompt('Por favor, elija un valor de la lista desplegable.');
                $objValidation->setFormula1("=marcas");


                /*
                 *
                 $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_WHOLE );
$validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
$validation->setAllowBlank(true);
$validation->setShowInputMessage(true);
$validation->setShowErrorMessage(true);
$validation->setErrorTitle('Input error');
$validation->setError('Number is not allowed!');
$validation->setPromptTitle('Allowed input');
$validation->setPrompt('Only numbers between 10 and 20 are allowed.');
$validation->setFormula1(10);
$validation->setFormula2(20);
                 */
            }


            $writer = new Xlsx($documento);


            //Manda al navegador
            $xlsName = "LAYOUT_DOWN_PRODUCTS_" . date('dmyhis') . ".xlsx";
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");;
            header("Content-Disposition: attachment;filename=$xlsName");
            header("Content-type: application/vnd.ms-excel;charset=latin");
            header("Content-type: text/html; charset=utf-8");
            header("Content-Transfer-Encoding: binary ");
            return $writer->save("php://output");
            exit;
            /*
            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle('Productos');
            $names = ['CATEGORÍA', 'CÓDIGO DE BARRAS', 'CÓDIGO INTERNO', 'NOMBRE', 'PRECIO UNITARIO', 'STOCK MÍNIMO','STOCK MÁXIMO'];
            $width = [ 20, 20, 20, 50, 15, 15, 15];
            $this->setNamesSheetExcel($objPHPExcel, $names, $width, 1);
            $oCategory = $this->category->all();
            $indice = 2;
            foreach ($oCategory as $row):
                $value = $row->name;
                $key = $row->id;
                $objPHPExcel->getActiveSheet()->SetCellValue('LA' . $indice, $key);
                $objPHPExcel->getActiveSheet()->SetCellValue('LB' . $indice, $value);
                $indice++;
            endforeach;
            $indice--;
            $objPHPExcel->addNamedRange(new \PHPExcel_NamedRange('categorias', $objPHPExcel->getSheetByName("Productos"),
                "LB2:LB$indice"));
            $home = 2;
            $end = 501;
            for ($i = $home; $i < $end; $i++) {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell("A$i")->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Dato incorrecto');
                $objValidation->setError('El valor se encuentra en la lista.');
                $objValidation->setPromptTitle('Categorías registradas en el sistema');
                $objValidation->setPrompt('Por favor, elija un valor de la lista desplegable.');
                $objValidation->setFormula1("=categorias");
            }
            $objPHPExcel->getActiveSheet()->getStyle("D$home:E$end")->getNumberFormat()->setFormatCode('#,###,##0');
            $objPHPExcel->getActiveSheet()->getStyle("F$home:G$end")->getNumberFormat()->setFormatCode('#,###,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle("A$home:G$end")->getNumberFormat()->setFormatCode('###############');

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $xlsName = "LAYOUT_DOWN_PRODUCTS_" . date('dmyhis') . ".xlsx";
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");;
            header("Content-Disposition: attachment;filename=$xlsName");
            header("Content-type: application/vnd.ms-excel;charset=latin");
            header("Content-type: text/html; charset=utf-8");
            header("Content-Transfer-Encoding: binary ");
            return $objWriter->save("php://output");
            */
        }
        return view('pages.master.product.layout');
    }

    public function upload(Request $request){

    }
}
