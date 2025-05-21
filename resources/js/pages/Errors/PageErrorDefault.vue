<template>
  <q-page class="flex flex-center text-center error-page">
    <div>
      <h1 class="text-h1">{{ code }}</h1>
      <p class="text-h5">{{ message }}</p>
      <q-btn
        color="primary"
        label="Voltar"
        @click="goBack"
        class="q-mt-md"
      />
    </div>
  </q-page>
</template>

<script setup>
const props = defineProps({
  code: {
    type: [String, Number],
    default: 'Error'
  },
  error: {
    type: Object,
    default: null
  }
});

const message = computed(() => {
  return props.error?.message || 'Ocorreu um erro inesperado';
});

const goBack = () => window.history.back();
</script>