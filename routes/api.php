<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// aqui abajo trabajamos
Route::resource('clien','User\UserController',['only'=>['index','show']]);
Route::resource('categorias','Categoria\CategoriaController',['only'=>['index','show','store','update','destroy']]);
//Route::resource('productos','Productos\ProductosController',['only'=>['index','show','destroy']]);
Route::resource('empresas','Empresa\EmpresaController',['only'=>['index','show','store','update']]);
Route::resource('empresas.categorias.productos','Empresa\EmpresaProductoController',['only'=>['show','store','update']]);
Route::resource('empresas.productos','Empresa\EmpresaProductoController',['only'=>['index']]);
Route::resource('empresas.categorias','Empresa\EmpresaCategoriaController',['only'=>['index']]);
Route::resource('proformadet.detalles','Empresa\EmpresaProformaController',['only'=>['index']]);

Route::resource('productos','Producto\ProductoController',['only'=>['index','show','destroy']]);
Route::resource('empresas.proformas','Proforma\ProformaController',['only'=>['index','show','update']]);
    Route::resource('users','Cliente\ClienteController',['only'=>['index','show','store','update']]);

Route::resource('vendedors','Vendedor\VendedorController',['only'=>['index','show']]);
Route::resource('users.empresas','Vendedor\VendedorEmpresaController',['except' => ['create','edit']]);
Route::resource('users.proform','Cliente\ClienteProformaController',['except' => ['create','edit']]);
Route::resource('users.detalles','Proforma\ProformaDetalleController',['except' => ['create','edit']]);
Route::resource('users.productos','Vendedor\VendedorProductoController',['except' => ['create','edit']]);

/// AUTH DESDE AQUI

// @TODO: Auth
//Route::post('login', 'LoginController@login');
Route::group(['middleware' => []], function () {

    Route::get('/projects', 'ProjectsController@getAll');
//    Route::get('/projects/{id}', 'ProjectsController@getProjectById');
    Route::get('/projects/{project}', 'ProjectsController@getProjectBySlug');

    // Auth
    Route::post('login', 'LoginController@login');
    Route::post('/auth/refresh', 'TokensController@refreshToken');
    Route::get('/auth/expire', 'TokensController@expireToken');
});
