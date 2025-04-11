# Changelog

Todas as alterações notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Versionamento Semântico](https://semver.org/lang/pt-BR/spec/v2.0.0.html).

## [1.0.0] - 2025-04-11

### Adicionado
- Implementação inicial do CRUD completo de produtos
- API RESTful com Laravel para operações de produtos
- Interface de usuário com Vue.js
- Documentação OpenAPI/Swagger da API
- Collection do Postman para testes da API
- Validação de dados no backend e frontend
- Design responsivo com Bootstrap 5
- Paginação na listagem de produtos
- Modais para criação, edição e exclusão de produtos
- README detalhado com instruções de instalação e uso
- TODO list com sugestões de melhorias futuras

### Alterado
- Migração de jQuery para Vue.js no frontend
- Reorganização da estrutura de pastas para melhor legibilidade
- Refatoração do controller de produtos para melhor separação de responsabilidades

### Corrigido
- Validação de preço para garantir valores positivos
- Feedback visual para operações CRUD
- Tratamento de erros na API e no frontend