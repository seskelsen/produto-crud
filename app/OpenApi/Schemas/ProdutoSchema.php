<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Produto",
 *     title="Produto",
 *     description="Modelo de produto",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID único do produto",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome do produto",
 *         example="Smartphone XYZ"
 *     ),
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         description="Descrição do produto",
 *         example="Smartphone com 128GB de armazenamento e 8GB de RAM"
 *     ),
 *     @OA\Property(
 *         property="preco",
 *         type="number",
 *         format="float",
 *         description="Preço do produto",
 *         example=1299.99
 *     ),
 *     @OA\Property(
 *         property="categoria",
 *         type="string",
 *         description="Categoria do produto",
 *         example="Eletrônicos"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Data de criação",
 *         example="2025-04-11T18:30:00.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Data da última atualização",
 *         example="2025-04-11T18:30:00.000000Z"
 *     )
 * )
 */
class ProdutoSchema
{
    // Esta classe é usada apenas para documentação OpenAPI
}