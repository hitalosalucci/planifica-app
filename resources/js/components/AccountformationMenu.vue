<template>
  <q-btn
    flat
    no-caps
    class="relative-position"
    @click="toggleAccountMenu(true)"
  >
    <q-icon name="account_circle" color="white" size="26px" />
    <p class="q-ma-none text-light q-ml-sm" v-if="$q.screen.gt.sm">
      {{ currentUserData?.name }}
    </p>
    <q-menu
      :offset="[0, 18]"
      transition-duration="0"
      class="brand-menu-basic"
      @hide="toggleAccountMenu(false)"
    >
      <div class="brand-pa-12 brand-modal-account-information">
        <div class="column items-center">
          <div class="bg-grey-3 q-pa-md" style="border-radius: 50%"> 
            <q-icon
              name="account_circle"
              color="grey-5"
              size="60px"
            />
          </div>

          <div class="q-py-sm text-center">
            <p class="q-ma-none q-pt-sm brand-text-m-regular">
              {{ currentUserData?.name }}
            </p>
            <p class="q-ma-none brand-text-s-regular">
              {{ currentUserData?.email }}
            </p>
          </div>

          <!-- start options menu -->
          <q-list class="full-width q-pt-sm brand-border-top-solid-default">
            <q-item
              v-for="(option, index) in accountOptions"
              :key="index"
              clickable
              v-ripple
              class="relative-position"
              @click="handleOptionClick(option)"
            >
              <q-item-section side class="q-pa-none">
                <q-icon
                  :name="option.icon"
                  :color="option.id === 2 ? 'red-5' : 'primary'"
                />
              </q-item-section>
              <q-item-section
                class="q-pa-sm brand-text-m-medium"
                :class="option.id === 2 ? 'brand-text-error' : 'text-grey-10'"
              >
                {{ option.name }}
              </q-item-section>
            </q-item>
          </q-list>
          <!-- end options menu -->
        </div>
      </div>
    </q-menu>
  </q-btn>

  <!-- Modal -->
  <q-dialog
    v-model="isShowModal"
    persistent
    transition-show="scale"
    transition-hide="scale"
  >
    <q-card class="bg-white brand-modal brand-modal-new-type-query">
      <q-card-section class="brand-pd-24-40">
        <q-card-section class="q-px-none row justify-between">
          <div class="brand-text-heading-s q-mt-sm">{{ modalTitle }}</div>
          <q-btn
            flat
            round
            class="brand-close-icon-button brand-button-close-modal"
            @click="closeModal"
            icon="close"
          />
        </q-card-section>

        <q-card-section
          v-if="stageModal === 1"
          class="q-px-none q-py-lg q-gutter-y-md"
        >
          <StandardInput
            label="Nome e sobrenome"
            :validation="errorNameQuantity"
            v-model="form.name"
          />
          <StandardInput
            label="Número de acesso"
            v-model="form.email"
            :disabled="true"
            classLabel="brand-text-m-semibold brand-text-disabled"
          />
          <span class="brand-text-s-medium">
            {{ "This information is used for customers to contact you." }}
          </span>
          <div
            class="row items-center justify-center brand-gap-10 no-wrap brand-pd-y16-x20 brand-bg-brand-lighter brand-border-radius-8 bg-popup-info"
          >
            <q-icon name="info" color="primary" size="24px" />
            <span class="brand-text-m-medium text-primary">
              {{ "To change your password, please contact support." }}
            </span>
          </div>
        </q-card-section>

      </q-card-section>

      <q-card-actions align="right" class="brand-px-40 q-py-md brand-bg-default">
        <q-btn
          :label="titleButtonModal"
          classButton="brand-button-large brand-button-bg-primary brand-border-radius-8"
          classLabel="brand-text-m-semibold"
          :isLoading="false"
          @click="handleModalAction"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useAuthStore } from "../stores/auth";
import useNotify from "../composable/useNotify";
import { currentUserData } from "../composable/globalVariables";
import { useGoToRouter } from "../composable/goToRouter";
import StandardInput from "../components/inputs/StandardInput.vue";

const authStore = useAuthStore();
const { handleGoToPage } = useGoToRouter();
const { notifySuccess, notifyError } = useNotify();

const isClassBtnActive = ref(false);
const stageModal = ref(0);
const isShowModal = ref(false);

const form = ref({ name: "", email: "" });
const initialForm = ref({ name: "", email: "" });
const errorNameQuantity = ref("");

const accountOptions = [
  // { id: 0, name: "Informações da conta", icon: "edit_note" },
  { id: 2, name: "Desconectar", icon: "logout" },
];

const titleButtonModal = computed(() =>
  stageModal.value === 1 ? "Salvar" : "Fechar"
);
const modalTitle = computed(() =>
  stageModal.value === 1 ? "Informações da conta" : "Meus saldos"
);

const toggleAccountMenu = async (isActive) => {
  isClassBtnActive.value = isActive;
};
const handleOptionClick = (option) => {
  if (option.id === 2) handleLogout();
  else {
    stageModal.value = option.id + 1;
    isShowModal.value = true;
  }
};

const handleModalAction = () => {
  if (stageModal.value === 1) handleSave();
  else closeModal();
};

const handleLogout = async () => {
  const resp = await authStore.logout();
  if (resp.error) notifyError(resp.message, "bottom-right");
  else handleGoToPage("login");
};

const closeModal = () => {
  isShowModal.value = false;
};

const handleSave = async () => {

  if (form.value.name.length < 3) {
    errorNameQuantity.value = "O campo de nome não pode estar vazio.";
  } else {
    // Verifica se houve mudança no valor do nome
    if (form.value.name !== initialForm.value.name) {
      try {
        const resp = await authStore.updateUser(form.value);

        // Verifica se houve algum erro na resposta
        if (resp.error) {
          notifyError(resp.message, "bottom-right");
        } else {
          initialForm.value.name = form.value.name;
          notifySuccess(t("Data updated successfully."));
        }
      } catch (error) {
        console.error("Erro ao atualizar o usuário:", error);
        notifyError("Erro ao atualizar o usuário.", "bottom-right");
      }
    }

    // Fecha o modal e atualiza o perfil, independente da mudança
    closeModal();
    errorNameQuantity.value = "";
  }
};
</script>