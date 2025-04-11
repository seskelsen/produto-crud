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
   git clone https://github.com/seskelsen/produto-crud.git
   cd produto-crud
   ```

2. **Instale as dependências**
   ```bash
   composer install
   npm install
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

6. **Compile os assets**
   ```bash
   npm run dev
   ```

7. **Inicie o servidor de desenvolvimento**
   ```bash
   php artisan serve
   ```

8. **Acesse a aplicação**
   - Abra o navegador e acesse: http://localhost:8000

## Sobre o projeto

Este projeto apresenta uma aplicação CRUD (Create, Read, Update, Delete) para gerenciar produtos, conforme solicitado no teste prático. A aplicação foi inicialmente construída utilizando Laravel no backend e jQuery no frontend, e posteriormente refatorada para utilizar Vue.js, demonstrando conhecimento em ambas as abordagens.

## Tecnologias Utilizadas

- **Backend**:
  - Laravel 10 (PHP)
  - MySQL (banco de dados)
  - Laravel Form Request (validação)
  - API RESTful

- **Frontend**:
  - HTML5, CSS3
  - Vue.js 3 (utilizando Composition API)
  - Bootstrap 5 (framework CSS)
  - Axios (para requisições HTTP)

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

Implementei a validação dos dados utilizando o Laravel Form Request, seguindo as boas práticas recomendadas para o framework. Isso permite uma validação robusta e fácil manutenção.

### 4. Controladores e Rotas API

Implementei o controlador `ProdutoController` para gerenciar todas as operações CRUD, seguindo os princípios REST.

### 5. Interface Frontend com Vue.js

Desenvolvi a interface frontend utilizando Vue.js 3 com Composition API para uma melhor organização e reatividade do código. A aplicação foi estruturada em componentes:

- **ProdutoApp.vue**: Componente principal que gerencia o estado da aplicação
- **ListaProdutos.vue**: Exibe a tabela de produtos
- **FormProduto.vue**: Formulário para criar e editar produtos
- **ModalConfirmacao.vue**: Modal para confirmar exclusão

#### Justificativa das escolhas:

- **Vue.js 3**: Escolhi o Vue.js por sua facilidade de integração com o Laravel, sua curva de aprendizado suave e sua poderosa reatividade. A Composition API proporciona um código mais organizado e reutilizável.

- **Bootstrap 5**: Mantive o Bootstrap pela sua robustez, documentação e facilidade de uso para criar interfaces responsivas.

- **Componentização**: A divisão em componentes Vue permite um código mais manutenível e organizado, seguindo princípios SOLID.

### 6. Comunicação com a API

Implementei a comunicação com a API utilizando Axios, configurado para incluir automaticamente o token CSRF:

```javascript
// Exemplo de requisição com Axios
const loadProdutos = async () => {
  try {
    const response = await axios.get('/api/produtos');
    produtos.value = response.data.data || response.data;
  } catch (error) {
    console.error('Erro ao carregar produtos:', error);
    alert('Erro ao carregar os produtos. Por favor, tente novamente.');
  }
};
```

### 7. Validação no Frontend

Além da validação no backend, implementei validação no frontend para melhorar a experiência do usuário, oferecendo feedback imediato sobre erros.

## Considerações sobre o Desenvolvimento

### Por que escolhi esta arquitetura?

1. **Laravel para o backend**:
   - Framework PHP maduro e com comunidade ativa
   - Excelente para desenvolvimento rápido de APIs RESTful
   - ORM Eloquent facilita a interação com o banco de dados
   - Recursos integrados para validação, middleware e segurança

2. **Vue.js para o frontend**:
   - Excelente integração com Laravel
   - Componentização para melhor organização do código
   - Reatividade eficiente para melhor experiência do usuário
   - Composition API para melhor gerenciamento de estado

3. **Estrutura do código**:
   - Separação clara entre backend (API) e frontend (interface)
   - Código organizado seguindo boas práticas de cada tecnologia
   - Validação em ambas as camadas para garantir integridade dos dados

## Possíveis melhorias futuras

Se este projeto fosse evoluir para uma aplicação maior, eu consideraria as seguintes melhorias:

1. **Autenticação e autorização**: Implementar JWT para autenticação na API
2. **Pinia ou Vuex**: Adicionar gerenciamento de estado mais robusto para aplicações maiores
3. **Testes automatizados**: Adicionar testes unitários e de integração (Vue Test Utils, Jest)
4. **Documentação da API**: Implementar Swagger/OpenAPI para documentar a API
5. **Otimização de performance**: Implementar lazy loading para componentes Vue
