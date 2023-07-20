<?php
//Plantilla de descarga
//https://github.com/Owen-oj/laravel-gentelella.git BarberShop

//Usuario: admin@dulces.com
//Clave: demo
//Para encriptar bcrypt('demo');

// Auth::routes(); //Viene por default
//El orden de las rutas sin autentificación debe ser este

/* ====================== RUTAS SIN AUTENTIFICACIÓN ============================================*/
Route::get('/login', ['as' => 'auth.login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('/login', ['as' => 'auth.login', 'uses' => 'Auth\LoginController@login']);


Route::get('/home', function () {
    if (\Auth::check()) {
        return redirect(route('validar'));
    } else {
        return redirect(route('auth.login'));
    }
})->name('home');


Route::get('/', function () {
    //Descomenta siguiente línea para que veas clave encriptada
    //dd(bcrypt('demo'));
    //dd(bcrypt('1ngr3s@r')); //clave para master
    if (\Auth::check()) {
        //return redirect(route('panel'));
        return redirect(route('dashboard'));
    } else {
        return redirect(route('home'));
    }
});

/* ====================== FIN DE RUTAS SIN AUTENTIFICACIÓN ============================================*/

/* ====================== RUTAS PARA UTILIZAR UN FAKER E INSERTAR DATOS DUMMY =========================*/
Route::get('barber-insert', 'DummyController@barber')->name('barberInsert');
Route::get('customer-insert', 'DummyController@customer')->name('customerInsert');
Route::get('product-insert', 'DummyController@product')->name('productInsert');
Route::get('service-insert', 'DummyController@services')->name('serviceInsert');

/* ====================== FIN DE RUTAS DUMMY ==========================================================*/

Route::group(['middleware' => 'auth'], function () {
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('logout', function () {

        return back();

    });

    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('dashboard', 'HomeController@index')->name('dashboard');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');;

    Route::group(['prefix' => 'customer'], function () {
        Route::get('/index', ['as' => 'customer.index', 'uses' => 'master\CustomerController@index']);
        Route::get('/create', ['as' => 'customer.create', 'uses' => 'master\CustomerController@create']);
        Route::post('/store', ['as' => 'customer.store', 'uses' => 'master\CustomerController@store']);
        Route::get('/{id}/edit', ['as' => 'customer.edit', 'uses' => 'master\CustomerController@edit']);
        Route::put('/{id}', ['as' => 'customer.update', 'uses' => 'master\CustomerController@update']);
        //Route::get('/{id}/delete', ['as' => 'customer.delete', 'uses' => 'master\CustomerController@delete']);
        Route::delete('/{id}', ['as' => 'customer.destroy', 'uses' => 'master\CustomerController@destroy']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/autocomplete', ['as' => 'product.autocomplete', 'uses' => 'master\ProductController@autocomplete']);
        Route::get('/index', ['as' => 'product.index', 'uses' => 'master\ProductController@index']);
        Route::get('/create', ['as' => 'product.create', 'uses' => 'master\ProductController@create']);
        Route::post('/store', ['as' => 'product.store', 'uses' => 'master\ProductController@store']);
        Route::get('/{id}/edit', ['as' => 'product.edit', 'uses' => 'master\ProductController@edit']);
        Route::put('/{id}', ['as' => 'product.update', 'uses' => 'master\ProductController@update']);
        Route::get('/{id}/delete', ['as' => 'product.delete', 'uses' => 'master\ProductController@delete']);
        Route::delete('/{id}', ['as' => 'product.destroy', 'uses' => 'master\ProductController@destroy']);
        Route::match(['get', 'post'],'/inventory', ['as' => 'product.inventory', 'uses' => 'master\ProductController@inventory']);
        Route::match(['get', 'post'], '/layout', ['as' => 'products.layout', 'uses' => 'master\ProductController@layout']);
        Route::post('/upload', ['as' => 'products.upload', 'uses' => 'master\ProductController@upload']);
    });

    Route::group(['prefix' => 'provider'], function () {
        Route::get('/index', ['as' => 'provider.index', 'uses' => 'master\ProviderController@index']);
        Route::post('/index', ['as' => 'provider.index', 'uses' => 'master\ProviderController@index']);
        Route::get('/create', ['as' => 'provider.create', 'uses' => 'master\ProviderController@create']);
        Route::post('/store', ['as' => 'provider.store', 'uses' => 'master\ProviderController@store']);
        Route::get('/{id}/edit', ['as' => 'provider.edit', 'uses' => 'master\ProviderController@edit']);
        Route::put('/{id}', ['as' => 'provider.update', 'uses' => 'master\ProviderController@update']);
        Route::delete('/{id}', ['as' => 'provider.destroy', 'uses' => 'master\ProviderController@destroy']);
    });


    Route::group(['prefix' => 'sales'], function () {
        Route::match(['get', 'post'], '/index', ['as' => 'sales.index', 'uses' => 'master\SalesController@index']);
        Route::post('/store', ['as' => 'sales.store', 'uses' => 'master\SalesController@store']);
        Route::post('/credit-sale', ['as' => 'sales.storecredit', 'uses' => 'master\SalesController@storecredit']);
        Route::post('/new-credit-sale', ['as' => 'sales.newcredit', 'uses' => 'master\SalesController@newcredit']);
        Route::get('/add-product', ['as' => 'sales.addProduct', 'uses' => 'master\SalesController@addProduct']);
        Route::get('/remove-product', ['as' => 'sales.removeProduct', 'uses' => 'master\SalesController@removeProduct']);
        Route::get('/receivable', ['as' => 'sales.receivable', 'uses' => 'master\SalesController@receivable']);
        Route::get('/credit', ['as' => 'sales.credit', 'uses' => 'master\SalesController@credit']);

    });

    Route::group(['prefix' => 'buy'], function () {
        Route::get('/index', ['as' => 'buy.index', 'uses' => 'master\BuyController@index']);
        Route::get('/create', ['as' => 'buy.create', 'uses' => 'master\BuyController@create']);
        Route::get('/add-item/{codebar}', ['as' => 'buy.addItem', 'uses' => 'master\BuyController@addItem']);
        Route::post('/store', ['as' => 'buy.store', 'uses' => 'master\BuyController@store']);
        Route::delete('/{id}', ['as' => 'buy.destroy', 'uses' => 'master\BuyController@destroy']);
        Route::get('/show/{id}', ['as' => 'buy.show', 'uses' => 'master\BuyController@show']);
    });

    Route::group(['prefix' => 'transfer'], function () {
        Route::get('/index', ['as' => 'transfer.index', 'uses' => 'master\TransferController@index']);
        Route::get('/create', ['as' => 'transfer.create', 'uses' => 'master\TransferController@create']);
        Route::get('/add-item/{codebar}', ['as' => 'transfer.addItem', 'uses' => 'master\TransferController@addItem']);
        Route::post('/store', ['as' => 'transfer.store', 'uses' => 'master\TransferController@store']);
        Route::delete('/{id}', ['as' => 'transfer.destroy', 'uses' => 'master\TransferController@destroy']);
        Route::get('/show/{id}', ['as' => 'transfer.show', 'uses' => 'master\TransferController@show']);
    });

    Route::group(['prefix' => 'brand'], function () {
        Route::get('/index', ['as' => 'brand.index', 'uses' => 'master\BrandController@index']);
        Route::get('/create', ['as' => 'brand.create', 'uses' => 'master\BrandController@create']);
        Route::post('/store', ['as' => 'brand.store', 'uses' => 'master\BrandController@store']);
        Route::get('/{id}/edit', ['as' => 'brand.edit', 'uses' => 'master\BrandController@edit']);
        Route::put('/{id}', ['as' => 'brand.update', 'uses' => 'master\BrandController@update']);
        Route::delete('/{id}', ['as' => 'brand.destroy', 'uses' => 'master\BrandController@destroy']);
    });

    Route::group(['prefix' => 'branch'], function () {
        Route::get('/index', ['as' => 'branch.index', 'uses' => 'master\BranchController@index']);
        Route::get('/create', ['as' => 'branch.create', 'uses' => 'master\BranchController@create']);
        Route::post('/store', ['as' => 'branch.store', 'uses' => 'master\BranchController@store']);
        Route::get('/{id}/edit', ['as' => 'branch.edit', 'uses' => 'master\BranchController@edit']);
        Route::put('/{id}', ['as' => 'branch.update', 'uses' => 'master\BranchController@update']);
        Route::get('/{id}/delete', ['as' => 'branch.delete', 'uses' => 'master\BranchController@delete']);
        Route::delete('/{id}', ['as' => 'branch.destroy', 'uses' => 'master\BranchController@destroy']);
    });



    Route::group(['prefix' => 'reports'], function () {
        Route::get('/index', ['as' => 'reports.index', 'uses' => 'ReportController@index']);
        Route::get('/fiados', ['as' => 'reports.fiados', 'uses' => 'ReportController@fiados']);
        Route::get('/fiado/{id}', ['as' => 'reports.detalle-fiado', 'uses' => 'ReportController@detalleFiado']);
        Route::match(['get','post'],'/sales', ['as' => 'reports.sales', 'uses' => 'ReportController@sales']);
    });


});
