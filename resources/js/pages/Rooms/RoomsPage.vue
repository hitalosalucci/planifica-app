<template>

  <StandardTable :rows="eventsList" :columns="columns" row-key="id" :loading="isLoadingData">
    <template #table-top-right>
      <StandardButton label="Nova Sala" buttonClass="brand-button-secondary" leftIcon="add" @click="openCreateDialog" />
    </template>

    <template #column-actions="{row}">

      <div class="flex items-center justify-center">
        <StandardButton flat buttonClass="brand-button-flat text-negative" :loading="isLoadingSave" popupProxy color="negative"
          leftIcon="delete" size="12px" tooltip="Remover Sala" @confirm="deleteData(row.id)" />
  
        <StandardButton flat buttonClass="brand-button-flat text-info" :loading="isLoadingSave" color="info"
          leftIcon="edit" size="12px" tooltip="Editar Sala" @click="openUpdateDialog(row)" />
      </div>

    </template>
  </StandardTable>

  <q-dialog v-model="dialogModel" persistent side="right" overlay bordered :width="450">

    <q-card style="width: 56vw; max-width: 95vw" class="brand-border-radius-16">
      <q-toolbar>
        <q-icon name="event" size="24px" />
        <q-toolbar-title v-if="!isEdit"> Nova Sala </q-toolbar-title>
        <q-toolbar-title v-else> Editar Sala </q-toolbar-title>
        <q-btn flat round dense icon="close" v-close-popup :loading="loading" :disable="loading" />
      </q-toolbar>

      <q-card-section>
        <div class="text-caption q-mb-lg flex items-center">
          <q-icon name="info" class="q-mr-xs" />
          Adicione as informações da sala e clique em "Salvar"
        </div>

        <q-form @submit="onSubmit" autofocus class="q-gutter-y-sm" v-model="formModel" ref="form">

          <div class="row q-gutter-x-md">
            <div class="col">
              <q-input dense outlined autogrow clearable v-model="formModel.name" label="Nome da sala*"
                :rules="[val => val && val.length > 0 || 'Nome é obrigatório']" />
            </div>
            <div class="col-3">
              <q-input type="number" min="1" dense outlined v-model="formModel.capacity" label="Capacidade máxima*"
                :rules="[val => val && val > 1 || 'Capacidade é obrigatória']" />
            </div>
          </div>
    
          <div class="q-mt-lg q-gutter-x-sm flex items-center q-gutter-x-sm justify-end">
            <StandardButton v-if="isEdit" label="Cancelar" buttonClass="brand-button-negative" v-close-popup :loading="isLoadingSave" />
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
  name: "RoomsPage",
});

const { notifyError, notifySuccess } = useNotify();
const isLoadingSave = ref(false);
const isLoadingData = ref(false);
const eventsList = ref([]);
const dialogModel = ref(false);
const isEdit = ref(false);
const form = ref(null)

const initialForm = {
  name: null,
  capacity: null,
}
const formModel = ref(initialForm);

onMounted( () => {
  getData();
})

const columns = [
  { name: 'name', field: 'name', label: 'Nome', sortable: true, align: 'left' },
  { name: 'capacity', field: 'capacity', label: 'Capacidade', sortable: true, align: 'left' },
]

const openCreateDialog = () => {
  isEdit.value = false;
  formModel.value = initialForm;
  dialogModel.value = true;
}

const openUpdateDialog = (row) => {
  isEdit.value = true;
  dialogModel.value = true;

  formModel.value = { ...row }; //Necessário para os objetos não ficarem ligados por referência
  formModel.value.id = row.id;
}

const getData = async () => {
  isLoadingData.value = true;
  const response = await api.get(
    '/rooms'
  );

  if(response.data){
    eventsList.value = response.data;
  }
  isLoadingData.value = false;
}

const onSubmit = async () => {

  isLoadingSave.value = true;

  try{

    let response;

    if (isEdit.value) {
      const endpoint = `/rooms/${formModel.value.id}`;
      response = await api.put(endpoint, formModel.value);
    } else {
      response = await api.post('/rooms', formModel.value);
    }

    if(response.data){
      getData();
      dialogModel.value = false;
      notifySuccess('Alterações foram salvas');
      isLoadingSave.value = false
      return
    }
  }
  catch(error){
    notifyError(`Erro ao apagar dado: ${error?.message ?? error}`)
  }

  notifyError('Erro ao realizar alteração')
  isLoadingSave.value = false
}

const deleteData = async (id) => {
  isLoadingSave.value = true;
  
  try{
    const response = await api.delete(
      `/rooms/${id}`,
    );
  
    getData();
    notifySuccess('Dado foi apagado');
  }
  catch(error){
    notifyError('Erro ao apagar dado')
  }

  isLoadingSave.value = false
}

</script>
