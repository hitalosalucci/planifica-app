import './bootstrap';
import { createApp } from 'vue';
import { Quasar } from 'quasar';
import router from  './router'
import App from './App.vue'

// importar Quasar css
import '@quasar/extras/material-icons/material-icons.css';
import 'quasar/src/css/index.sass';

const app = createApp(App);

app.use(Quasar, {
  plugins: {
    // Dialog
  },
  config: {
    screen: {
      mobileBreakpoint: 'md'
    }
  }
});

app.use(router);

app.mount('#app');