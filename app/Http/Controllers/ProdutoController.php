<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * List all products with optional pagination.
     */
    public function index(): JsonResponse
    {
        $produtos = Produto::paginate(10);
        return response()->json($produtos);
    }

    /**
     * Show a specific product by ID.
     */
    public function show(int $id): JsonResponse
    {
        $produto = Produto::findOrFail($id);
        return response()->json($produto);
    }

    /**
     * Create a new product.
     */
    public function store(ProdutoRequest $request): JsonResponse
    {
        $produto = Produto::create($request->validated());
        return response()->json($produto, 201);
    }

    /**
     * Update an existing product by ID.
     */
    public function update(ProdutoRequest $request, int $id): JsonResponse
    {
        $produto = Produto::findOrFail($id);
        $produto->update($request->validated());
        return response()->json($produto);
    }

    /**
     * Delete a product by ID.
     */
    public function destroy(int $id): JsonResponse
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();
        return response()->json(null, 204);
    }
}