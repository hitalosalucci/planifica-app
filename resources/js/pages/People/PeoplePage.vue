<template>

  <StandardTable :rows="dataList" :columns="columns" row-key="id" :loading="isLoadingData">
    <template #table-top-right>
      <StandardButton label="Novo Cadastro" buttonClass="brand-button-secondary" leftIcon="add" @click="openCreateDialog" />
    </template>

    <template #column-birth_date="{value}">
      <span v-if="value">
        {{ date.formatDate(value, 'DD/MM/YYYY') }}
      </span>
      <span v-else class="text-negative">
        Não informado
      </span>
    </template>

    <template #column-actions="{row}">

      <div class="flex items-center justify-center">
        <StandardButton flat buttonClass="brand-button-flat text-negative" :loading="isLoadingSave" popupProxy color="negative"
          leftIcon="delete" size="12px" tooltip="Remover Pessoa" @confirm="deleteData(row.id)" />
  
        <StandardButton flat buttonClass="brand-button-flat text-info" :loading="isLoadingSave" color="info"
          leftIcon="edit" size="12px" tooltip="Editar Pessoa" @click="openUpdateDialog(row)" />

        <StandardButton flat buttonClass="brand-button-flat text-primary" :loading="isLoadingSave" color="primary"
          leftIcon="event" size="12px" tooltip="Pessoas no evento" @click="openEventPeopleDialog(row)" />
      </div>

    </template>
  </StandardTable>

  <q-dialog v-model="dialogModel" persistent side="right" overlay bordered :width="450">

    <q-card style="width: 56vw; max-width: 95vw" class="brand-border-radius-16">
      <q-toolbar>
        <q-icon name="person" size="24px" />
        <q-toolbar-title v-if="!isEdit"> Novo cadastro </q-toolbar-title>
        <q-toolbar-title v-else> Editar cadastro </q-toolbar-title>
        <q-btn flat round dense icon="close" v-close-popup :loading="loading" :disable="loading" />
      </q-toolbar>

      <q-card-section>
        <div class="text-caption q-mb-lg flex items-center">
          <q-icon name="info" class="q-mr-xs" />
          Adicione as informações do evento e clique em "Salvar"
        </div>

        <q-form @submit="onSubmit" autofocus class="q-gutter-y-sm" v-model="formModel" ref="form">

          <q-input dense outlined autogrow clearable v-model="formModel.name" label="Nome Completo*"
            :rules="[val => val && val.length > 0 || 'Nome é obrigatório']" />

          

          <div class="row q-gutter-x-md">
            <div class="col">
              <q-input dense outlined autogrow clearable v-model="formModel.cpf" label="CPF*"
                :rules="[val => val && val.length > 0 || 'CPF é obrigatório']" mask="###.###.###-##" unmasked-value />
            </div>

            <div class="col">
              <q-input
                :loading="loading"
                :disable="loading"
                dense
                outlined
                label="Data de Nascimento"
                cursor="pointer"
                :model-value="
                  formModel.birth_date
                    ? date.formatDate(new Date(formModel.birth_date + 'T00:00:00'), 'DD/MM/YYYY')
                    : null
                "
              >
                <q-popup-proxy
                  transition-show="flip-up"
                  transition-hide="flip-up"
                >
                  <q-date
                    color="primary"
                    v-model="formModel.birth_date"
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
                    v-if="formModel.birth_date"
                    name="cancel"
                    class="cursor-pointer"
                    @click="formModel.birth_date = null"
                  />
                </template>
              </q-input>

            </div>
            
          </div>

          <div class="row  q-gutter-x-md">
            <div class="col">
              <q-input dense outlined autogrow clearable v-model="formModel.phone" label="Telefone"
                mask="(##) #####-####" unmasked-value />
            </div>

            <div class="col">
              <q-input dense outlined autogrow clearable v-model="formModel.email" label="Email" />
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

  <q-dialog v-model="dialogEventPeopleModel" persistent side="right" overlay bordered :width="450">

    <q-card style="width: 60vw; max-width: 95vw" class="brand-border-radius-16">
      <q-toolbar>
        <q-icon name="group" size="24px" />
        <q-toolbar-title>Eventos de {{personDetails.name}} </q-toolbar-title>
        <q-btn flat round dense icon="close" v-close-popup :loading="loading" :disable="loading" />
      </q-toolbar>

      <q-card-section>
        <div class="text-caption q-mb-lg flex items-center">
          <q-icon name="info" class="q-mr-xs" />
          Aqui você acompanhará as pessoas que estão no evento
        </div>

        <StandardTable :rows="eventsPeopleList" :columns="columnsEventPeople" row-key="id" :loading="isLoadingEventsData">

          <template #column-entry_code="{row}">
            <span v-if="row.pivot?.entry_code">
              {{ row.pivot?.entry_code }} 
            </span>
            <span v-else class="text-negative">
              Não informado
            </span>
          </template>

          <template #column-date="{value}">
            <span v-if="value">
              {{ date.formatDate(value, 'DD/MM/YYYY') }}
            </span>
            <span v-else class="text-negative">
              Não informado
            </span>
          </template>

          <template #column-actions="{row}">

            <div class="flex items-center justify-center">
              <StandardButton flat buttonClass="brand-button-flat text-negative" :loading="isLoadingSave" popupProxy color="negative"
                leftIcon="cancel" size="12px" tooltip="Remover evento" @confirm="detachPersonEvent(row.id, personDetails.id)" />
            </div>
      
          </template>
        </StandardTable>

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
  name: "PeoplePage",
});

const { notifyError, notifySuccess } = useNotify();
const isLoadingSave = ref(false);
const isLoadingData = ref(false);
const isLoadingEventsData = ref(false);
const dataList = ref([]);
const eventsPeopleList = ref([]);
const dialogModel = ref(false);
const dialogEventPeopleModel = ref(false);
const isEdit = ref(false);
const form = ref(null)
const personDetails = ref();

const initialForm = {
  name: null,
  cpf: null,
  birth_date: null,
  phone: null,
  email: null,
  gender: null
}
const formModel = ref(initialForm);
const todayDate = date.formatDate(new Date(), 'YYYY-MM-DD')

const validateDateMin = val => {
  return val >= todayDate || 'A data não pode ser anterior a hoje'
}

onMounted( () => {
  getData();
})

const columns = [
  { name: 'cpf', field: 'cpf', label: 'CPF', sortable: true, align: 'left' },
  { name: 'name', field: 'name', label: 'Nome', sortable: true, align: 'left' },
  { name: 'birth_date', field: 'birth_date', label: 'Data de nascimento', sortable: true, align: 'left' },
  { name: 'phone', field: 'phone', label: 'Telefone', sortable: true, align: 'left' },
  { name: 'email', field: 'email', label: 'Email', sortable: true, align: 'left' },
]

const columnsEventPeople = [
  { name: 'description', field: 'description', label: 'Evento', sortable: true, align: 'left' },
  { name: 'date', field: 'date', label: 'Data', sortable: true, align: 'left' },
]

const openEventPeopleDialog = (personRow) => {
  dialogEventPeopleModel.value = true;
  personDetails.value = personRow;

  getEventsPerson(personRow.id);
}

const getEventsPerson = async (personId) => {
  isLoadingEventsData.value = true;
  const response = await api.get(
    `/people/${personId}/events`
  );

  if(response.data){
    eventsPeopleList.value = response.data;
  }

  isLoadingEventsData.value = false;
}

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
  formModel.value.birth_date = row.birth_date ? date.formatDate(row.birth_date, 'YYYY-MM-DD') : null;
}

const getData = async () => {
  isLoadingData.value = true;
  const response = await api.get(
    '/people'
  );

  if(response.data){
    dataList.value = response.data;
  }
  isLoadingData.value = false;
}

const onSubmit = async () => {

  isLoadingSave.value = true;

  let response;

  if (isEdit.value) {
    const endpoint = `/people/${formModel.value.id}`;
    response = await api.put(endpoint, formModel.value);
  } else {
    response = await api.post('/people', formModel.value);
  }

  if(response.data){
    getData();
    dialogModel.value = false;
    notifySuccess('Alterações foram salvas');
    isLoadingSave.value = false
    return
  }

  notifyError('Erro ao realizar alteração')
  isLoadingSave.value = false
}

const deleteData = async (id) => {
  isLoadingSave.value = true;
  
  try{
    const response = await api.delete(
      `/people/${id}`,
    );
  
    getData();
    notifySuccess('Dado foi apagado');
  }
  catch(error){
    notifyError('Erro ao apagar dado')
  }

  isLoadingSave.value = false
}

const detachPersonEvent = async (eventId, personId) => {
  isLoadingEventsData.value = true;
  const response = await api.delete(
    `/events/${eventId}/people/${personId}`
  );

  if(response.data){
    getEventsPerson(personId);
  }

  isLoadingEventsData.value = false;
}

</script>
