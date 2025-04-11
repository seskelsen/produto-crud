import './bootstrap';

import { createApp } from 'vue';
import ProdutoApp from './components/ProdutoApp.vue';

const app = createApp({});

app.component('produto-app', ProdutoApp);

app.mount('#app');
