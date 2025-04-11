<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProdutoController;

// Rota para a página inicial (interface do usuário)
Route::get('/', function () {
    return view('welcome');
});

// Rotas API para Produtos
Route::prefix('api')->group(function () {
    Route::get('/produtos', [ProdutoController::class, 'index']);
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
    Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
});
