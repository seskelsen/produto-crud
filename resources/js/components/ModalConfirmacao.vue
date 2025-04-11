<template>
  <div class="modal fade" :class="{ 'show d-block': show }" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Exclusão</h5>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja excluir este produto?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="$emit('close')">Cancelar</button>
          <button type="button" class="btn btn-danger" @click="$emit('confirm')">Excluir</button>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show" v-if="show"></div>
  </div>
</template>

<script>
import { watch } from 'vue';

export default {
  props: {
    show: {
      type: Boolean,
      default: false
    },
    produtoId: {
      type: Number,
      default: null
    }
  },
  emits: ['close', 'confirm'],
  setup(props) {
    // Observa mudanças na visibilidade do modal
    watch(() => props.show, (isVisible) => {
      if (isVisible) {
        document.body.classList.add('modal-open');
      } else {
        document.body.classList.remove('modal-open');
      }
    });
    
    return {};
  }
}
</script>

<style scoped>
.modal.show {
  background-color: rgba(0, 0, 0, 0.5);
}
</style>