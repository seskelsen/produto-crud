<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>CRUD de Produtos</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </head>
    <body class="bg-light">
        <div class="container py-5">
            <header class="mb-4 text-center">
                <h1 class="mb-3">CRUD de Produtos</h1>
                <p class="lead">Sistema para gerenciamento de produtos</p>
            </header>

            <div class="row mb-4">
                <div class="col-md-12 text-end">
                    <button id="btnCriarProduto" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalProduto">
                        <i class="bi bi-plus-circle"></i> Novo Produto
                    </button>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Lista de Produtos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabelaProdutos" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Preço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Os produtos serão carregados via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal para adicionar/editar produto -->
            <div class="modal fade" id="modalProduto" tabindex="-1" aria-labelledby="modalProdutoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalProdutoLabel">Adicionar Produto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formProduto">
                                <input type="hidden" id="produtoId">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                    <div class="invalid-feedback" id="nomeError"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                                    <div class="invalid-feedback" id="descricaoError"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="categoria" class="form-label">Categoria</label>
                                    <input type="text" class="form-control" id="categoria" name="categoria">
                                    <div class="invalid-feedback" id="categoriaError"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="preco" class="form-label">Preço</label>
                                    <input type="number" class="form-control" id="preco" name="preco" step="0.01" required>
                                    <div class="invalid-feedback" id="precoError"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="btnSalvarProduto">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para confirmar exclusão -->
            <div class="modal fade" id="modalConfirmacaoExclusao" tabindex="-1" aria-labelledby="modalConfirmacaoExclusaoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalConfirmacaoExclusaoLabel">Confirmar Exclusão</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Tem certeza que deseja excluir este produto?</p>
                            <input type="hidden" id="idExclusao">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="btnConfirmarExclusao">Excluir</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    // CSRF Token para requisições AJAX
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    // Carregar a lista de produtos
                    carregarProdutos();
                    
                    // Preparar o modal para adicionar um novo produto
                    $('#btnCriarProduto').click(function() {
                        limparFormulario();
                        $('#modalProdutoLabel').text('Adicionar Produto');
                    });
                    
                    // Salvar produto (adicionar ou editar)
                    $('#btnSalvarProduto').click(function() {
                        salvarProduto();
                    });
                    
                    // Confirmar exclusão de produto
                    $('#btnConfirmarExclusao').click(function() {
                        excluirProduto();
                    });
                });
                
                // Função para carregar a lista de produtos
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
                
                // Função para renderizar a tabela de produtos
                function renderizarTabela(produtos) {
                    var tbody = $('#tabelaProdutos tbody');
                    tbody.empty();
                    
                    if (produtos.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center">Nenhum produto encontrado</td></tr>');
                        return;
                    }
                    
                    produtos.forEach(function(produto) {
                        tbody.append(`
                            <tr>
                                <td>${produto.id}</td>
                                <td>${produto.nome}</td>
                                <td>${produto.categoria || '-'}</td>
                                <td>R$ ${parseFloat(produto.preco).toFixed(2)}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editarProduto(${produto.id})">
                                        Editar
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmarExclusao(${produto.id})">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }
                
                // Função para editar um produto existente
                function editarProduto(id) {
                    $.ajax({
                        url: `/api/produtos/${id}`,
                        type: 'GET',
                        success: function(produto) {
                            $('#produtoId').val(produto.id);
                            $('#nome').val(produto.nome);
                            $('#descricao').val(produto.descricao);
                            $('#categoria').val(produto.categoria);
                            $('#preco').val(produto.preco);
                            
                            $('#modalProdutoLabel').text('Editar Produto');
                            $('#modalProduto').modal('show');
                        },
                        error: function(xhr) {
                            console.error('Erro ao buscar produto:', xhr);
                            alert('Erro ao buscar os dados do produto.');
                        }
                    });
                }
                
                // Função para confirmar a exclusão de um produto
                function confirmarExclusao(id) {
                    $('#idExclusao').val(id);
                    $('#modalConfirmacaoExclusao').modal('show');
                }
                
                // Função para excluir um produto
                function excluirProduto() {
                    const id = $('#idExclusao').val();
                    
                    $.ajax({
                        url: `/api/produtos/${id}`,
                        type: 'DELETE',
                        success: function() {
                            $('#modalConfirmacaoExclusao').modal('hide');
                            carregarProdutos();
                            alert('Produto excluído com sucesso!');
                        },
                        error: function(xhr) {
                            console.error('Erro ao excluir produto:', xhr);
                            alert('Erro ao excluir o produto.');
                        }
                    });
                }
                
                // Função para salvar um produto (novo ou existente)
                function salvarProduto() {
                    limparMensagensErro();
                    
                    const id = $('#produtoId').val();
                    const url = id ? `/api/produtos/${id}` : '/api/produtos';
                    const method = id ? 'PUT' : 'POST';
                    
                    const dados = {
                        nome: $('#nome').val(),
                        descricao: $('#descricao').val(),
                        categoria: $('#categoria').val(),
                        preco: $('#preco').val()
                    };
                    
                    $.ajax({
                        url: url,
                        type: method,
                        data: dados,
                        success: function(response) {
                            $('#modalProduto').modal('hide');
                            carregarProdutos();
                            alert(id ? 'Produto atualizado com sucesso!' : 'Produto criado com sucesso!');
                        },
                        error: function(xhr) {
                            console.error('Erro ao salvar produto:', xhr);
                            
                            if (xhr.status === 422) {
                                // Exibir erros de validação
                                const errors = xhr.responseJSON.errors;
                                for (const field in errors) {
                                    $(`#${field}`).addClass('is-invalid');
                                    $(`#${field}Error`).text(errors[field][0]);
                                }
                            } else {
                                alert('Erro ao salvar o produto.');
                            }
                        }
                    });
                }
                
                // Função para limpar o formulário
                function limparFormulario() {
                    $('#produtoId').val('');
                    $('#formProduto')[0].reset();
                    limparMensagensErro();
                }
                
                // Função para limpar mensagens de erro
                function limparMensagensErro() {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');
                }
            </script>
        </div>
    </body>
</html>
