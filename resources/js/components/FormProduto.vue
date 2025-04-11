<template>
  <div class="modal fade" :class="{ 'show d-block': show }" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ produto.id ? 'Editar Produto' : 'Adicionar Produto' }}</h5>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input 
                type="text" 
                class="form-control" 
                :class="{ 'is-invalid': errors.nome }"
                id="nome" 
                v-model="form.nome" 
                required
              >
              <div class="invalid-feedback" v-if="errors.nome">{{ errors.nome[0] }}</div>
            </div>
            <div class="mb-3">
              <label for="descricao" class="form-label">Descrição</label>
              <textarea 
                class="form-control" 
                :class="{ 'is-invalid': errors.descricao }"
                id="descricao" 
                v-model="form.descricao" 
                rows="3"
              ></textarea>
              <div class="invalid-feedback" v-if="errors.descricao">{{ errors.descricao[0] }}</div>
            </div>
            <div class="mb-3">
              <label for="categoria" class="form-label">Categoria</label>
              <input 
                type="text" 
                class="form-control" 
                :class="{ 'is-invalid': errors.categoria }"
                id="categoria" 
                v-model="form.categoria"
              >
              <div class="invalid-feedback" v-if="errors.categoria">{{ errors.categoria[0] }}</div>
            </div>
            <div class="mb-3">
              <label for="preco" class="form-label">Preço</label>
              <input 
                type="number" 
                class="form-control" 
                :class="{ 'is-invalid': errors.preco }"
                id="preco" 
                v-model="form.preco" 
                step="0.01" 
                required
              >
              <div class="invalid-feedback" v-if="errors.preco">{{ errors.preco[0] }}</div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="$emit('close')">Cancelar</button>
          <button type="button" class="btn btn-primary" @click="handleSubmit">Salvar</button>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show" v-if="show"></div>
  </div>
</template>

<script>
import { ref, watch, reactive } from 'vue';

export default {
  props: {
    show: {
      type: Boolean,
      default: false
    },
    produto: {
      type: Object,
      required: true
    }
  },
  emits: ['close', 'save'],
  setup(props, { emit }) {
    const form = reactive({
      id: null,
      nome: '',
      descricao: '',
      categoria: '',
      preco: ''
    });
    
    const errors = reactive({});

    // Observa mudanças no produto e atualiza o formulário
    watch(() => props.produto, (newProduto) => {
      form.id = newProduto.id || null;
      form.nome = newProduto.nome || '';
      form.descricao = newProduto.descricao || '';
      form.categoria = newProduto.categoria || '';
      form.preco = newProduto.preco || '';
      
      // Limpa erros quando o formulário muda
      Object.keys(errors).forEach(key => {
        delete errors[key];
      });
    }, { immediate: true, deep: true });

    // Observa mudanças na visibilidade do modal
    watch(() => props.show, (isVisible) => {
      if (isVisible) {
        document.body.classList.add('modal-open');
      } else {
        document.body.classList.remove('modal-open');
      }
    });

    const handleSubmit = async () => {
      // Limpa erros anteriores
      Object.keys(errors).forEach(key => {
        delete errors[key];
      });
      
      // Validação básica no cliente
      let isValid = true;
      
      if (!form.nome) {
        errors.nome = ['O nome do produto é obrigatório'];
        isValid = false;
      }
      
      if (!form.preco) {
        errors.preco = ['O preço do produto é obrigatório'];
        isValid = false;
      } else if (isNaN(form.preco) || parseFloat(form.preco) < 0) {
        errors.preco = ['O preço deve ser um valor numérico positivo'];
        isValid = false;
      }
      
      if (!isValid) return;
      
      // Enviar para o componente pai
      const resultado = await emit('save', { ...form });
      
      // Se houver erros de validação do servidor
      if (resultado) {
        Object.assign(errors, resultado);
      }
    };

    return {
      form,
      errors,
      handleSubmit
    };
  }
}
</script>

<style scoped>
body.modal-open {
  overflow: hidden;
}

.modal.show {
  background-color: rgba(0, 0, 0, 0.5);
}
</style>