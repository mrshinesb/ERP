<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseCartController;
use App\Http\Controllers\SaleCartController;
use App\Http\Controllers\SaleController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class);
Route::resource('stocks', StockController::class);
Route::resource('sales', SaleController::class);
Route::resource('purchases', PurchaseController::class);
Route::get('get-stock/{code}',[StockController::class,'getStock']);
Route::get('get-stock/{cqty}',[StockController::class,'getCqty']);
Route::get('get-stock-wprice/{code}',[StockController::class,'getWPrice']);

//PurchaseCart Controller
Route::post('purchase-cart',[PurchaseCartController::class,'add'])->name('purchasecart.add');
Route::get('purchase-cart-remove/{id}',[PurchaseCartController::class,'remove'])->name('purchasecart.remove');
Route::get('purchase-cart-edit/{id}',[PurchaseCartController::class,'edit'])->name('purchasecart.edit');
Route::patch('purchase-cart-update/{id}',[PurchaseCartController::class,'update'])->name('purchasecart.update');
Route::post('purchase-cart-save',[PurchaseCartController::class,'save'])->name('purchasecart.save');


//Sale Cart Controller
Route::post('sale-cart',[SaleCartController::class,'add'])->name('salecart.add');
Route::get('sale-cart-remove/{id}',[SaleCartController::class,'remove'])->name('salecart.remove');
Route::get('sale-cart-edit/{id}',[SaleCartController::class,'edit'])->name('salecart.edit');
Route::patch('sale-cart-update/{id}',[SaleCartController::class,'update'])->name('salecart.update');
Route::post('sale-cart-save',[SaleCartController::class,'save'])->name('salecart.save');

