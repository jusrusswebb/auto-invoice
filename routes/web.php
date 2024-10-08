<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return redirect()->route('add-service');
})->middleware('auth');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/add-client', [ClientController::class, 'create'])->name('add-client');
    Route::post('/add-client', [ClientController::class, 'store']);

    Route::get('/add-service', [ServiceController::class, 'create'])->name('add-service');
    Route::post('/add-service', [ServiceController::class, 'store'])->name('store-service');

    Route::delete('/service/{id}', [ServiceController::class, 'destroy'])->name('delete-service');

    Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('delete-client');

    Route::get('/client-dashboard', [ClientDashboardController::class, 'index'])->name('client-dashboard');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/generate-docx/{clientId}', [DocumentController::class, 'generateDocx'])->name('generate-docx');
    Route::post('/update-invoice-total', [InvoiceController::class, 'updateTotal'])->name('update.invoice.total');
    Route::get('/search-client', [ClientDashboardController::class, 'search'])->name('search-client');//new 

});




