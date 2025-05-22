import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia'
import { Quasar, Notify } from 'quasar';
import langPtBr from 'quasar/lang/pt-BR'
import router from  './router'
import App from './App.vue'

// importar Quasar css
import '@quasar/extras/material-icons/material-icons.css';
import 'quasar/src/css/index.sass';

const app = createApp(App);

const pinia = createPinia()
app.use(pinia)

app.use(Quasar, {
  plugins: {
    Notify
    // Dialog
  },
  lang: langPtBr,
  config: {
    screen: {
      mobileBreakpoint: 'md'
    }
  }
});

app.use(router);

app.mount('#app');