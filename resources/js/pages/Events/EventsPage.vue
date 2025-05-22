<template>
  
  <StandardTable :rows="eventsList" :columns="columns" row-key="id">
    <template #table-top-right>
      <StandardButton label="Novo Evento" buttonClass="brand-button-secondary" leftIcon="add" @click="dialogModel = true" />
    </template>

    <!-- <template #column-actions="{row}">
      <Link :href="route('panel.calculators.config', { uuid: row?.uuid })">
      <Button flat dense round :disable="loadingAction" :loading="loadingAction"
        :color="$q.dark.isActive ? 'white' : 'primary'" icon="settings" />
      </Link>
      <Button :disable="loadingAction" :loading="loadingAction" popupProxy flat dense round color="negative"
        icon="fa-solid fa-trash-can" size="11px" tooltip="Remover calculadora" @confirm="removeBank(row)" />
    </template> -->
  </StandardTable>

  <q-dialog v-model="dialogModel" persistent side="right" overlay bordered :width="450">

    <q-card style="width: 56vw; max-width: 95vw" class="brand-border-radius-16">
      <q-toolbar>
        <q-icon name="event" size="24px" />
        <q-toolbar-title v-if="!isEdit"> Novo evento </q-toolbar-title>
        <q-toolbar-title v-else> Editar Evento </q-toolbar-title>
        <q-btn flat round dense icon="close" v-close-popup :loading="loading" :disable="loading" />
      </q-toolbar>

      <q-card-section>
        <div class="text-caption q-mb-lg flex items-center">
          <q-icon name="info" class="q-mr-xs" />
          Adicione as informações do evento e clique em "Salvar"
        </div>

        <q-form @submit="onSubmit" autofocus class="q-gutter-y-sm" v-model="formModel" ref="form">

          <q-input dense outlined autogrow clearable v-model="formModel.description" label="Descrição do evento"
            :rules="[val => val && val.length > 0 || 'Descrição é obrigatória']" />

          <div class="row q-gutter-x-md">
            <div class="col">

              <q-input
                :loading="loading"
                :disable="loading"
                dense
                outlined
                label="Data do evento"
                cursor="pointer"
                :model-value="
                  formModel.date
                    ? date.formatDate(new Date(formModel.date + 'T00:00:00'), 'DD/MM/YYYY')
                    : null
                "
                :rules="[validateDateMin]"
              >
                <q-popup-proxy
                  transition-show="flip-up"
                  transition-hide="flip-up"
                >
                  <q-date
                    color="primary"
                    v-model="formModel.date"
                    mask="YYYY-MM-DD"
                  >
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Fechar" color="primary" flat />
                    </div>
                  </q-date>
                </q-popup-proxy>
                <template v-slot:prepend>
                  <q-icon name="calendar_month" />
                </template>
                <template v-slot:append>
                  <q-icon
                    v-if="formModel.date"
                    name="cancel"
                    class="cursor-pointer"
                    @click="formModel.date = null"
                  />
                </template>
              </q-input>

            </div>
            <div class="col">
              <q-input type="number" min="1" dense outlined v-model="formModel.capacity" label="Capacidade máxima"
                :rules="[val => val && val > 1 || 'Capacidade é obrigatória']" />
            </div>
            <div class="col">
              <q-input type="number" min="1" dense outlined v-model="formModel.quantity_stages" label="Quantidade de etapas (turnos)"
                :rules="[val => val && val > 1 || 'Quantidade de estágios é obrigatório']" />
            </div>
          </div>
    
          <div class="text-right q-mt-lg q-gutter-x-sm">
            <!-- <StandardButton
              no-caps
              outline
              label="Cancelar"
              color="dark"
              width="50px"
              v-close-popup
              :loading="loading" :disable="loading"
            /> -->
              <StandardButton label="Salvar" buttonClass="brand-button-secondary" @click="form.submit()" :loading="isLoadingSave" />
          </div>

        </q-form>

      </q-card-section>
    </q-card>
  </q-dialog>

</template>

<script setup>
import { computed, ref, onMounted } from "vue";
import StandardTable from '../../components/StandardTable.vue'
import { api } from "../../boot/axios";
import { date } from "quasar";
import useNotify from '../../composable/useNotify';

import StandardInput from "../../components/inputs/StandardInput.vue";
import StandardButton from "../../components/inputs/StandardButton.vue";

defineOptions({
  name: "EventsPage",
});

const { notifyError, notifySuccess } = useNotify();
const isLoadingSave = ref(false) 
const eventsList = ref([]);
const dialogModel = ref(false);
const isEdit = false;
const form = ref(null)

const initialForm = {
  description: null,
  date: null,
  capacity: null,
  quantity_stages: 2
}
const formModel = ref(initialForm);
const todayDate = date.formatDate(new Date(), 'YYYY-MM-DD')

const validateDateMin = val => {
  return val >= todayDate || 'A data não pode ser anterior a hoje'
}

onMounted( () => {
  getEvents();
})

const columns = [
  { name: 'description', field: 'description', label: 'Descrição', sortable: true, align: 'left' },
  { name: 'date', field: 'date', label: 'Data', sortable: true, align: 'left' },
  { name: 'capacity', field: 'capacity', label: 'Capacidade', sortable: true, align: 'left' },
  { name: 'quantity_stages', field: 'quantity_stages', label: 'Estágios', sortable: true, align: 'left' },
]

const getEvents = async () => {
  const response = await api.get(
    '/events'
  );

  if(response.data){
    eventsList.value = response.data;
  }
}

const onSubmit = async () => {
  isLoadingSave.value = true;
  const response = await api.post(
    '/events',
    formModel.value
  );

  if(response.data){
    getEvents();
    dialogModel.value = false;
    notifySuccess('Evento cadastrado com sucesso');
    return
  }

  notifyError('Erro ao cadastrar evento')
  isLoadingSave.value = false
}

</script>
