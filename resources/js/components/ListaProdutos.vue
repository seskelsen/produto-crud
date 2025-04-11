<template>
  <table class="table table-striped table-hover">
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
      <tr v-if="produtos.length === 0">
        <td colspan="5" class="text-center">Nenhum produto encontrado</td>
      </tr>
      <tr v-for="produto in produtos" :key="produto.id">
        <td>{{ produto.id }}</td>
        <td>{{ produto.nome }}</td>
        <td>{{ produto.categoria || '-' }}</td>
        <td>R$ {{ formatPrice(produto.preco) }}</td>
        <td>
          <button class="btn btn-sm btn-info me-2" @click="$emit('edit-produto', produto)">
            Editar
          </button>
          <button class="btn btn-sm btn-danger" @click="$emit('delete-produto', produto.id)">
            Excluir
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    produtos: {
      type: Array,
      required: true
    }
  },
  emits: ['edit-produto', 'delete-produto'],
  setup() {
    const formatPrice = (price) => {
      return parseFloat(price).toFixed(2);
    };

    return {
      formatPrice
    };
  }
}
</script>