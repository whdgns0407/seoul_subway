<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// csv업로드
// Route::get('/csv_upload', [App\Http\Controllers\subwayController::class, 'csv_upload'])->name('csv_upload');


Route::get('/subway/{station_name}', [App\Http\Controllers\subwayController::class, 'subway'])->name('subway');

Route::get('/subway_ajax/{station_name}', [App\Http\Controllers\subwayController::class, 'subway_ajax'])->name('subway_ajax');

