<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="ProdutoRequest",
 *     title="ProdutoRequest",
 *     description="Dados para criar ou atualizar um produto",
 *     required={"nome", "preco"},
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome do produto",
 *         example="Smartphone XYZ",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         description="Descrição do produto",
 *         example="Smartphone com 128GB de armazenamento e 8GB de RAM",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="preco",
 *         type="number",
 *         format="float",
 *         description="Preço do produto",
 *         example=1299.99,
 *         minimum=0
 *     ),
 *     @OA\Property(
 *         property="categoria",
 *         type="string",
 *         description="Categoria do produto",
 *         example="Eletrônicos",
 *         nullable=true,
 *         maxLength=100
 *     )
 * )
 */
class ProdutoRequestSchema
{
    // Esta classe é usada apenas para documentação OpenAPI
}