<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0|decimal:0,2',
            'categoria' => 'nullable|string|max:100'
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do produto é obrigatório',
            'preco.required' => 'O preço do produto é obrigatório',
            'preco.numeric' => 'O preço deve ser um valor numérico',
            'preco.min' => 'O preço não pode ser negativo',
            'preco.decimal' => 'O preço deve ter no máximo duas casas decimais',
        ];
    }
}
