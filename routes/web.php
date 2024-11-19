<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;


Route::get('/', [EmpleadoController::class, 'inicio']);
Route::resource('empleados', EmpleadoController::class);


