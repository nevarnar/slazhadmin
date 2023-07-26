<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ExcelImportController;

Route::post('import_division',[ExcelImportController::class,'importDivision']);
Route::post('import_township',[ExcelImportController::class,'importTownship']);

Route::post('import_country_list',[ExcelImportController::class,'importCountry']);

Route::post('add_size',[SizeController::class,'addSize']);

Route::post('/save_stock',[StockController::class,'saveStock']);
