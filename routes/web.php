<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Excel;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuditController;

use App\Imports\CatalogImport;

/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class,'index'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| RUTAS COORDINADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:coordinador'])->group(function () {

    Route::get('/purchase-requests', [PurchaseRequestController::class,'index'])
        ->name('purchase-requests.index');

    Route::get('/purchase-requests/create', [PurchaseRequestController::class,'create'])
        ->name('purchase-requests.create');

    Route::post('/purchase-requests', [PurchaseRequestController::class,'store'])
        ->name('purchase-requests.store');

    Route::get('/coordinador/devueltas', [PurchaseRequestController::class,'devueltas'])
        ->name('purchase-requests.devueltas');

    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);

});

/*
|--------------------------------------------------------------------------
| RUTAS COMPRAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:compras'])->group(function () {

    /* REQUISICIONES */

    Route::get('/compras/requisiciones',
        [PurchaseRequestController::class,'pendientesCompras'])
        ->name('compras.pendientes');

    Route::get('/compras/aceptadas',
        [PurchaseRequestController::class,'aceptadas'])
        ->name('purchase-requests.aceptadas');

    Route::get('/compras/rechazadas',
        [PurchaseRequestController::class,'rechazadas'])
        ->name('purchase-requests.rechazadas');

    Route::get('/compras/numeradas',
        [PurchaseRequestController::class,'numeradas'])
        ->name('purchase-requests.numeradas');

    Route::delete('/purchase-requests/{purchaseRequest}',
        [PurchaseRequestController::class,'destroy'])
        ->name('purchase-requests.destroy');


    /* ÓRDENES DE COMPRA */

    // Crear orden
    Route::post('/orders/{purchaseRequest}',
        [PurchaseOrderController::class,'store'])
        ->name('orders.store');

    // PDF
    Route::get('/orders/{order}/pdf',
        [PurchaseOrderController::class,'pdf'])
        ->name('orders.pdf');

    // Todas las órdenes
    Route::get('/orders',
        [PurchaseOrderController::class,'todas'])
        ->name('orders.index');

    // Borradores
    Route::get('/purchase_orders/borradores',
        [PurchaseOrderController::class,'borradores'])
        ->name('purchase_orders.borradores');

    // Emitidas
    Route::get('/purchase_orders/emitidas',
        [PurchaseOrderController::class,'emitidas'])
        ->name('purchase_orders.emitidas');

         Route::patch('/orders/{order}/emitir',
        [PurchaseOrderController::class,'emitir'])
        ->name('orders.emitir');



        Route::delete('/orders/{order}', [PurchaseOrderController::class,'destroy'])
->name('orders.destroy');

Route::get('/orders/zip', [PurchaseOrderController::class,'downloadZip'])
->name('orders.zip');


Route::get('/orders/emitidas/descargar',
[PurchaseOrderController::class,'descargarEmitidas'])
->name('orders.emitidas.descargar');





});

/*
|--------------------------------------------------------------------------
| ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:administrador'])->group(function () {

    Route::resource('users', \App\Http\Controllers\UserController::class);

});

/*
|--------------------------------------------------------------------------
| RUTAS GENERALES AUTENTICADAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /* PERFIL */

    Route::get('/profile', [ProfileController::class,'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class,'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class,'destroy'])
        ->name('profile.destroy');


    /* REQUISICIONES */

    Route::resource('purchase-requests', PurchaseRequestController::class)
        ->except(['destroy']);

    Route::post('/purchase-requests/{purchaseRequest}/change-status',
        [PurchaseRequestController::class,'changeStatus'])
        ->name('purchase-requests.change-status');

    Route::get('/purchase-requests/aceptadas/descargar-todas',
        [PurchaseRequestController::class,'descargarTodasAceptadas'])
        ->name('purchase-requests.aceptadas.descargar');


    /* ÓRDENES */

    Route::get('/orders/{order}/edit',
        [PurchaseOrderController::class,'edit'])
        ->name('orders.edit');

    Route::put('/orders/{order}',
        [PurchaseOrderController::class,'update'])
        ->name('orders.update');

    Route::put('/orders/{order}/numero',
        [PurchaseOrderController::class,'updateNumero'])
        ->name('orders.updateNumero');

   
        Route::get('/orders/monto-total',
[PurchaseOrderController::class,'montoTotal'])
->name('orders.monto_total');

Route::get('/orders/reportes',
[PurchaseOrderController::class,'reportes'])
->name('orders.reportes');

Route::get('/orders/reportes/excel',
[PurchaseOrderController::class,'exportarExcel'])
->name('orders.reportes.excel');

Route::get('/orders/reportes/pdf',
    [PurchaseOrderController::class,'reportePdf']
)->name('orders.reportes.pdf');


    /* AUDITORÍA */

    Route::get('/auditoria',
        [AuditController::class,'index'])
        ->name('audit.index');


    /* PDF REQUISICIÓN */

    Route::get('/purchase-requests/{purchaseRequest}/pdf',
        [PurchaseRequestController::class,'pdf'])
        ->name('purchase-requests.pdf');

    Route::get('/purchase-requests/{purchaseRequest}',
        [PurchaseRequestController::class,'show'])
        ->name('purchase-requests.show');


    /* EDICIÓN COORDINADOR */

    Route::get('/purchase-requests/{purchaseRequest}/edit',
        [PurchaseRequestController::class,'edit'])
        ->middleware(['role:coordinador'])
        ->name('purchase-requests.edit');

    Route::put('/purchase-requests/{purchaseRequest}',
        [PurchaseRequestController::class,'update'])
        ->middleware(['role:coordinador'])
        ->name('purchase-requests.update');


    /* IMPORTAR CATÁLOGO */

    Route::get('/import-catalog', function () {

        Excel::import(new CatalogImport, storage_path('app/catalogo.xlsx'));

        return 'Importación completada';

    });

});

require __DIR__.'/auth.php';