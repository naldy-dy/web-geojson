<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JsonController;

Route::controller(JsonController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('create', 'create');

});