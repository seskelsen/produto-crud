<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# CRUD de Produtos - Teste Prático

## Índice
1. [Instalação](#instalação)
2. [Sobre o projeto](#sobre-o-projeto)
3. [Tecnologias utilizadas](#tecnologias-utilizadas)
4. [Processo de desenvolvimento](#processo-de-desenvolvimento)
5. [Considerações sobre o desenvolvimento](#considerações-sobre-o-desenvolvimento)
6. [Possíveis melhorias](#possíveis-melhorias-futuras)

## Instalação

Para instalar e executar o projeto em sua máquina local, siga estas etapas:

1. **Clone o repositório**
   ```bash
   git clone https://github.com/seu-usuario/produto-crud.git
   cd produto-crud
   ```

2. **Instale as dependências**
   ```bash
   composer install
   ```

3. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure o banco de dados**
   - Crie um banco de dados MySQL chamado `produtos_crud`
   - Configure as credenciais do banco de dados no arquivo `.env`

5. **Execute as migrações**
   ```bash
   php artisan migrate
   ```

6. **Inicie o servidor de desenvolvimento**
   ```bash
   php artisan serve
   ```

7. **Acesse a aplicação**
   - Abra o navegador e acesse: http://localhost:8000

## Sobre o projeto

Este projeto apresenta uma aplicação CRUD (Create, Read, Update, Delete) para gerenciar produtos, conforme solicitado no teste prático. A aplicação foi construída utilizando Laravel no backend e JavaScript puro com jQuery no frontend, com o objetivo de demonstrar minhas habilidades em desenvolvimento web full-stack.

## Tecnologias Utilizadas

- **Backend**:
  - Laravel 10 (PHP)
  - MySQL (banco de dados)
  - Laravel Form Request (validação)
  - API RESTful

- **Frontend**:
  - HTML5, CSS3
  - JavaScript
  - jQuery (para manipulação DOM e requisições AJAX)
  - Bootstrap 5 (framework CSS)

## Processo de Desenvolvimento

### 1. Configuração do Ambiente

Iniciei o desenvolvimento configurando o ambiente Laravel e conectando ao banco de dados MySQL. Optei por utilizar o MySQL em vez do SQLite (que vinha configurado por padrão no projeto) por ser mais robusto e adequado para aplicações em produção, além de ser o mais utilizado em ambientes corporativos.

```php
// Configuração do banco de dados no .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=produtos_crud
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Modelagem do Banco de Dados

Criei o modelo `Produto` com os campos solicitados e configurei a respectiva migration. Defini os campos conforme os requisitos:

```php
// Migration para a tabela de produtos
Schema::create('produtos', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->text('descricao')->nullable();
    $table->decimal('preco', 10, 2);
    $table->string('categoria')->nullable();
    $table->timestamps();
});
```

```php
// Model Produto
class Produto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'categoria'
    ];
}
```

### 3. Validação de Dados

Implementei a validação dos dados utilizando o Laravel Form Request, seguindo as boas práticas recomendadas para o framework. Isso permite uma validação robusta e fácil manutenção:

```php
// ProdutoRequest para validação
class ProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0|decimal:0,2',
            'categoria' => 'nullable|string|max:100'
        ];
    }
    
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
```

### 4. Controladores e Rotas API

Implementei o controlador `ProdutoController` para gerenciar todas as operações CRUD, seguindo os princípios REST:

```php
// Controlador para produtos
class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::paginate(10);
        return response()->json($produtos);
    }

    public function store(ProdutoRequest $request)
    {
        $produto = Produto::create($request->validated());
        return response()->json($produto, 201);
    }

    public function show(string $id)
    {
        $produto = Produto::findOrFail($id);
        return response()->json($produto);
    }

    public function update(ProdutoRequest $request, string $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update($request->validated());
        return response()->json($produto);
    }

    public function destroy(string $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();
        return response()->json(null, 204);
    }
}
```

Configurei as rotas da API para acessar os métodos do controlador:

```php
// Rotas da API
Route::prefix('api')->group(function () {
    Route::get('/produtos', [ProdutoController::class, 'index']);
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
    Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
});
```

### 5. Interface Frontend

Desenvolvi a interface frontend utilizando Bootstrap para garantir um design responsivo e moderno. Optei por utilizar jQuery para simplificar as manipulações DOM e requisições AJAX, já que é uma biblioteca amplamente adotada e com excelente documentação.

A estrutura da interface inclui:
- Uma tabela para listagem de produtos
- Modal para adicionar/editar produtos
- Modal de confirmação para exclusão
- Feedback visual para erros de validação

#### Justificativa das escolhas:

- **Bootstrap 5**: Escolhi o Bootstrap pela sua robustez, documentação e facilidade de uso para criar interfaces responsivas. Ele permite criar uma interface profissional e adaptável a diferentes dispositivos rapidamente.

- **jQuery**: Mesmo com a ascensão de frameworks modernos como React e Vue, optei pelo jQuery por sua simplicidade e adequação ao escopo do projeto. Para uma aplicação CRUD simples como esta, o jQuery oferece todas as funcionalidades necessárias sem adicionar complexidade desnecessária.

### 6. Comunicação com a API

Implementei a comunicação com a API utilizando Ajax via jQuery, seguindo boas práticas como:
- Configuração do token CSRF para requisições seguras
- Tratamento adequado de erros
- Feedback visual para o usuário

```javascript
// Exemplo de requisição para carregar produtos
function carregarProdutos() {
    $.ajax({
        url: '/api/produtos',
        type: 'GET',
        success: function(response) {
            renderizarTabela(response.data);
        },
        error: function(xhr) {
            console.error('Erro ao carregar produtos:', xhr);
            alert('Erro ao carregar os produtos. Por favor, tente novamente.');
        }
    });
}
```

### 7. Validação no Frontend

Além da validação no backend, implementei validação no frontend para melhorar a experiência do usuário:
- Validação de campos obrigatórios
- Feedback visual imediato para erros
- Exibição adequada das mensagens de erro retornadas pelo servidor

```javascript
// Exemplo de validação e exibição de erros
if (xhr.status === 422) {
    // Exibir erros de validação
    const errors = xhr.responseJSON.errors;
    for (const field in errors) {
        $(`#${field}`).addClass('is-invalid');
        $(`#${field}Error`).text(errors[field][0]);
    }
}
```

## Considerações sobre o Desenvolvimento

### Por que escolhi esta arquitetura?

1. **Laravel para o backend**:
   - Framework PHP maduro e com comunidade ativa
   - Excelente para desenvolvimento rápido de APIs RESTful
   - ORM Eloquent facilita a interação com o banco de dados
   - Recursos integrados para validação, middleware e segurança

2. **Abordagem tradicional com jQuery no frontend**:
   - Simplicidade e eficácia para projetos de menor escopo
   - Fácil integração com Bootstrap para design responsivo
   - Menor curva de aprendizado comparado a frameworks SPA

3. **Estrutura do código**:
   - Separação clara entre backend (API) e frontend (interface)
   - Código organizado seguindo boas práticas de cada tecnologia
   - Validação em ambas as camadas para garantir integridade dos dados

## Possíveis melhorias futuras

Se este projeto fosse evoluir para uma aplicação maior, eu consideraria as seguintes melhorias:

1. **Autenticação e autorização**: Implementar JWT para autenticação na API
2. **Framework frontend moderno**: Migrar para Vue.js ou React para melhor gerenciamento de estado
3. **Testes automatizados**: Adicionar testes unitários e de integração
4. **Documentação da API**: Implementar Swagger/OpenAPI para documentar a API
5. **Cache e otimização**: Implementar cache para melhorar performance
