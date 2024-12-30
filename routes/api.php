<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::resource('roles', RoleController::class);
Route::resource('categories', CategoryController::class);

