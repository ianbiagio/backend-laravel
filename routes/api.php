<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaProdutoController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::middleware('auth:api')->get('auth', [AuthController::class, 'auth']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('produtos', ProdutoController::class);
    Route::resource('categorias_produtos', CategoriaProdutoController::class);
});
