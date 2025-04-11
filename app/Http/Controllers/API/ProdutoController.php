<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Produtos",
 *     description="Endpoints da API para gerenciamento de produtos"
 * )
 */
class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @OA\Get(
     *     path="/api/produtos",
     *     operationId="getProdutosList",
     *     tags={"Produtos"},
     *     summary="Listar todos os produtos",
     *     description="Retorna uma lista paginada de todos os produtos",
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="current_page",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Produto")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(
     *                 @OA\Property(property="url", type="string"),
     *                 @OA\Property(property="label", type="string"),
     *                 @OA\Property(property="active", type="boolean")
     *             )),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function index()
    {
        $produtos = Produto::paginate(10);
        return response()->json($produtos);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post(
     *     path="/api/produtos",
     *     operationId="storeProduto",
     *     tags={"Produtos"},
     *     summary="Criar um novo produto",
     *     description="Armazena um novo produto no banco de dados",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do produto",
     *         @OA\JsonContent(ref="#/components/schemas/ProdutoRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Os dados fornecidos são inválidos."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={"nome": {"O campo nome é obrigatório."}, "preco": {"O campo preço é obrigatório."}}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function store(ProdutoRequest $request)
    {
        $produto = Produto::create($request->validated());
        return response()->json($produto, 201);
    }

    /**
     * Display the specified resource.
     * 
     * @OA\Get(
     *     path="/api/produtos/{id}",
     *     operationId="getProdutoById",
     *     tags={"Produtos"},
     *     summary="Obter um produto específico",
     *     description="Retorna um produto específico pelo ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        $produto = Produto::findOrFail($id);
        return response()->json($produto);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @OA\Put(
     *     path="/api/produtos/{id}",
     *     operationId="updateProduto",
     *     tags={"Produtos"},
     *     summary="Atualizar um produto existente",
     *     description="Atualiza um produto existente no banco de dados",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do produto",
     *         @OA\JsonContent(ref="#/components/schemas/ProdutoRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Os dados fornecidos são inválidos."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={"nome": {"O campo nome é obrigatório."}, "preco": {"O campo preço deve ser numérico."}}
     *             )
     *         )
     *     )
     * )
     */
    public function update(ProdutoRequest $request, string $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update($request->validated());
        return response()->json($produto);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @OA\Delete(
     *     path="/api/produtos/{id}",
     *     operationId="deleteProduto",
     *     tags={"Produtos"},
     *     summary="Excluir um produto",
     *     description="Exclui um produto existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do produto",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto excluído com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();
        return response()->json(null, 204);
    }
}
