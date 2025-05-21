<template>
  <q-layout view="lHh Lpr lFf">
    <q-page-container>
      <router-view />
      <!-- <GlobalLoading /> -->
    </q-page-container>
  </q-layout>
</template>
<script lang="ts" setup>
defineOptions({
  name: "AuthLayout",
});

// import GlobalLoading from 'src/components/GlobalLoading.vue';

</script>
