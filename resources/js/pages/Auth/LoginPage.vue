<template>
  <q-page class="overflow-hidden">
    <div class="row brand-full-view-height">
      <div :class="['col-xl-4 col-lg-5 col-md-6 col-12', { hidden: $q.screen.lt.md }]">
        <div class="brand-image-container">
          <q-img :src="brandData?.imageBannerLogin" class="brand-image-background-auth" />
        </div>
      </div>

      <div class="col flex items-center justify-center">

        <div class="brand-form-container q-px-xl">

          <div>
            <q-img v-if="brandData?.imageLogoHorizontalDark" :src="brandData?.imageLogoHorizontalDark" width="200px"
              class="brand-mb-36" />
          </div>

          <div :class="{ 'q-px-md': $q.screen.lt.md }">
            <div>
              <div class="column brand-gap-16">

                <div>
                  <div class="brand-heading-l-bold">
                    Acessar Conta
                  </div>
                  <div class="brand-text-l-regular brand-text-secondary">
                    Preencha as informações para acessar
                  </div>

                </div>

                <StandardInput type="email" label="Email de acesso" placeholder="Informe seu email"
                  v-model="form.email" :errorMessage="formErrors.email" @update:keyupEnter="handleLogin" />

                <StandardInput type="password" label="Senha" placeholder="Informe sua senha"
                  v-model="form.password" :errorMessage="formErrors.password" @update:keyupEnter="handleLogin" />

                <div class="brand-text-l-regular brand-text-secondary">
                  <q-checkbox v-model="form.remember" label="Lembrar-me" size="xs" class="brand-text-m-regular text-dark" color="primary" />
                </div>

                <div>

                  <StandardButton label="Acessar"
                    buttonClass="brand-full-width brand-button-primary" :loading="isLoadingButton"
                    @click="handleLogin" class="q-mt-sm" />

                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </q-page>
</template>

<script setup>
import { ref } from "vue";
import { brandData } from "../../composable/globalVariables";
import { validateEmail } from "../../utils/globalFunctions";

import { useAuthStore } from "../../stores/auth";

import StandardInput from "../../components/inputs/StandardInput.vue";
import StandardButton from "../../components/inputs/StandardButton.vue";

import useGlobalLoading from '../../composable/useGlobalLoading';
import useNotify from '../../composable/useNotify';
import { useGoToRouter } from "../../composable/goToRouter";

const { handleGoToPage } = useGoToRouter();
const { showGlobalLoading, hideGlobalLoading } = useGlobalLoading();
const { notifyError, notifySuccess } = useNotify();
const authStore = useAuthStore();

defineOptions({
  name: "LoginPage",
});

const form = ref({
  email: "",
  password: "",
  remember: false
});

const formErrors = ref({
  email: "",
  password: ""
});

const isLoadingButton = ref(false);

const funValidationForm = async () => {
  formErrors.value = {};

  // Validation Email
  if (!form.value.email) {
    formErrors.value.email = 'Informe o email';
  } else if (!(validateEmail(form.value.email))) {
    formErrors.value.email = 'E-mail invalido';
  }

  // Validation Password
  if (!form.value.password) {
    formErrors.value.password = 'Informe a senha';
  }

  return Object.keys(formErrors.value).length === 0;
};

const handleLogin = async () => {
  isLoadingButton.value = true;

  const isValid = await funValidationForm();
  if (!isValid) {

    isLoadingButton.value = false;
    return;
  }

  try{
    const resp = await authStore.login(form.value);

    if (resp?.status === 401) {
      isLoadingButton.value = false;
      return notifyError('Credenciais inválidas');
    }
  }
  catch($e){
    return notifyError('Ocorreu um erro ao realizar o login. Tente novamente mais tarde');
  }
  
  await handleGoToPage("events");
};
</script>
