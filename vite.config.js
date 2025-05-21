import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'

export default defineConfig({
  plugins: [
      laravel({
          input: ['resources/css/app.css', 'resources/js/app.js'],
          refresh: true,
      }),
      
      vue({
        template: { transformAssetUrls },
      }),

      quasar({
        sassVariables: "~/css/quasar.variables.scss",
      }),

  ],

  resolve: {
    alias: {
      '@': '/resources/js',
      '~': '/resources',
    },
  },

  optimizeDeps: {
    include: [
      '@quasar/extras',
      'quasar'
    ],
  },

  server: {
    host: true, // aceita conexões externas
  }
});