<template>
  <div class="container py-5">
    <header class="mb-4 text-center">
      <h1 class="mb-3">CRUD de Produtos</h1>
      <p class="lead">Sistema para gerenciamento de produtos</p>
    </header>

    <div class="row mb-4">
      <div class="col-md-12 text-end">
        <button class="btn btn-success" @click="showModal(null)">
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
          <ListaProdutos 
            :produtos="produtos" 
            @edit-produto="showModal"
            @delete-produto="confirmDelete" 
          />
        </div>
      </div>
    </div>

    <FormProduto 
      :show="showFormModal" 
      :produto="currentProduto" 
      @close="hideModal"
      @save="saveProduto" 
    />

    <ModalConfirmacao 
      :show="showDeleteModal" 
      :produto-id="produtoIdToDelete"
      @close="cancelDelete"
      @confirm="deleteProduto"
    />
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ListaProdutos from './ListaProdutos.vue';
import FormProduto from './FormProduto.vue';
import ModalConfirmacao from './ModalConfirmacao.vue';

export default {
  components: {
    ListaProdutos,
    FormProduto,
    ModalConfirmacao
  },
  setup() {
    const produtos = ref([]);
    const showFormModal = ref(false);
    const showDeleteModal = ref(false);
    const currentProduto = ref({});
    const produtoIdToDelete = ref(null);

    // Carrega a lista de produtos
    const loadProdutos = async () => {
      try {
        const response = await axios.get('/api/produtos');
        produtos.value = response.data.data || response.data;
      } catch (error) {
        console.error('Erro ao carregar produtos:', error);
        alert('Erro ao carregar os produtos. Por favor, tente novamente.');
      }
    };

    // Exibe modal de formulário
    const showModal = (produto) => {
      currentProduto.value = produto || { nome: '', descricao: '', preco: '', categoria: '' };
      showFormModal.value = true;
    };

    // Fecha o modal de formulário
    const hideModal = () => {
      showFormModal.value = false;
    };

    // Confirma exclusão de produto
    const confirmDelete = (produtoId) => {
      produtoIdToDelete.value = produtoId;
      showDeleteModal.value = true;
    };

    // Cancela exclusão de produto
    const cancelDelete = () => {
      showDeleteModal.value = false;
      produtoIdToDelete.value = null;
    };

    // Salvar produto (criar ou atualizar)
    const saveProduto = async (produto) => {
      try {
        if (produto.id) {
          await axios.put(`/api/produtos/${produto.id}`, produto);
          alert('Produto atualizado com sucesso!');
        } else {
          await axios.post('/api/produtos', produto);
          alert('Produto criado com sucesso!');
        }
        
        hideModal();
        loadProdutos();
      } catch (error) {
        console.error('Erro ao salvar produto:', error);
        
        if (error.response && error.response.status === 422) {
          return error.response.data.errors;
        } else {
          alert('Erro ao salvar o produto.');
        }
      }
      
      return null;
    };

    // Excluir produto
    const deleteProduto = async () => {
      try {
        await axios.delete(`/api/produtos/${produtoIdToDelete.value}`);
        alert('Produto excluído com sucesso!');
        showDeleteModal.value = false;
        loadProdutos();
      } catch (error) {
        console.error('Erro ao excluir produto:', error);
        alert('Erro ao excluir o produto.');
      }
    };

    // Carrega produtos ao iniciar o componente
    onMounted(() => {
      loadProdutos();
    });

    return {
      produtos,
      showFormModal,
      showDeleteModal,
      currentProduto,
      produtoIdToDelete,
      showModal,
      hideModal,
      confirmDelete,
      cancelDelete,
      saveProduto,
      deleteProduto
    };
  }
}
</script>