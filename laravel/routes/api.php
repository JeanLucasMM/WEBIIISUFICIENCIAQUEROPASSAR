<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
|
| Registro, login e visualização pública de produtos e categorias.
|
*/

// Registro e login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Produtos e categorias públicos (apenas index e show)
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Usuário autenticado)
|--------------------------------------------------------------------------
|
| Apenas usuários logados podem criar, editar e deletar pedidos e fazer logout.
|
*/
Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD de pedidos (usuário só acessa seus próprios pedidos)
    Route::apiResource('orders', OrderController::class)->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Administradores)
|--------------------------------------------------------------------------
|
| Apenas administradores podem gerenciar produtos e categorias.
|
*/
Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::apiResource('products', ProductController::class)->except(['index','show']);
    Route::apiResource('categories', CategoryController::class)->except(['index','show']);

    Route::apiResource('categories', CategoryController::class)->except([
        'index', 'show'
    ]);
});
