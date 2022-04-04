<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\VoucherController;
use Illuminate\Support\Facades\Auth;
Route::group(['prefix' => '/'], function () {
    Route::get('login', [LoginController::class,'loginForm'])->name('admin.login.get');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::get('logout', [LoginController::class, 'logout'])->
    name('admin.logout');

    Route::group(['middleware' => ['auth:admin']], function () {
       Route::get('/dashboard', [HomeController::class,'index'])->name('admin.dashboard');

       Route::get('/account', [AccountController::class, 'loadAccount'])->
       name('admin.account');

       Route::get('/account/lockUser/{id}', [AccountController::class, 'lockUser'])->
       name('admin.account.lockUser');

       Route::get('/account/unLockUser/{id}', [AccountController::class, 'unLockUser'])->
       name('admin.account.unLockUser');
       
       Route::get('/account/delete/{id}', [AccountController::class, 'deleteAccount'])->
       name('admin.account.delete');

       Route::get('/account/search', [AccountController::class, 'searchAccount'])->
       name('admin.account.search');

       Route::get('/account/profile', [AccountController::class, 'viewProfile'])->
       name('admin.account.profile');
    
       //--------------------------------------------------------------->

       Route::group(['prefix' => '/products'], function () {

            Route::get('', [ProductController::class, 'loadProduct'])->
            name('admin.product');

            Route::get('/search', [ProductController::class, 'Search'])->
            name('admin.product.search');

            Route::post('/create-product', [ProductController::class, 'createProduct'])->
            name('admin.product.create');

            Route::delete('/delete', [ProductController::class, 'deleteProduct'])->
            name('admin.product.delete');
       });

        //----------------------------------------------------------------------------------------
       Route::group(['prefix' => '/invoices'], function () {

               Route::get('/details/{invoiceID}', [InvoiceController::class, 'detailsInvoice'])->name('admin.invoice.details');

               Route::get('/search', [InvoiceController::class, 'Search']);

               Route::get('/order-tracking', [InvoiceController::class, 'orderTracking'])->name('admin.invoice.orderTracking');

               Route::get('/order-tracking/confirmStatus/{invoiceID}', [InvoiceController::class, 'handleConfirmStatus'])->name('admin.invoice.confirmStatus');

               Route::get('/waiting-to-accept', [InvoiceController::class, 'waitingToAccept'])->name('admin.invoice.waiting');

               Route::get('/confirmed', [InvoiceController::class, 'confirmed'])->name('admin.invoice.confirmed');

               Route::get('/on-delivery', [InvoiceController::class, 'onDelivery'])->name('admin.invoice.delivery');

               Route::get('/success-delivery', [InvoiceController::class, 'success'])->name('admin.invoice.success');
        });


        //----------------------------------------------------------
      

//----------------------------------------------------------------------------------------

    
//----------------------------------------------------------------------------------------
        Route::group(['prefix' => '/employee'], function(){

            Route::get('', [EmployeeController::class, 'loadEmployee'])->name('admin.employee.index');

            Route::get('/create', [EmployeeController::class, 'loadEmployee'])->name('admin.employee.index');

            Route::post('/create', [EmployeeController::class, 'createEmployee'])->name('admin.employee.createEmployee');

        });

        Route::group(['prefix' => '/vouchers'], function(){

            Route::get('', [VoucherController::class, 'Index'])->name('admin.vouchers.index'); 
            
            Route::get('/create', [VoucherController::class, 'FormCreate'])->name('admin.vouchers.create');     
    
            Route::post('/create', [VoucherController::class, 'CreateVoucher'])->name('admin.vouchers.create.post');    
        });


        Route::group(['prefix' => '/reviews'], function(){

            Route::get('', [ReviewController::class, 'Index'])->name('admin.reviews.index'); 
            
        });
    });

});
