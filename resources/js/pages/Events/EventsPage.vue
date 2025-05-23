<template>
  
  <StandardTable :rows="eventsList" :columns="columns" row-key="id" :loading="isLoadingData">
    <template #table-top-right>
      <StandardButton label="Novo Evento" buttonClass="brand-button-secondary" leftIcon="add" @click="openCreateDialog" />
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
          leftIcon="delete" size="12px" tooltip="Remover Evento" @confirm="deleteData(row.id)" />
  
        <StandardButton flat buttonClass="brand-button-flat text-info" :loading="isLoadingSave" color="info"
          leftIcon="edit" size="12px" tooltip="Editar evento" @click="openUpdateDialog(row)" />

        <StandardButton flat buttonClass="brand-button-flat text-primary" :loading="isLoadingSave" color="primary"
          leftIcon="group" size="12px" tooltip="Pessoas no evento" @click="openPeopleEventDialog(row)" />
      </div>

    </template>
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

          <q-input dense outlined autogrow clearable v-model="formModel.description" label="Descrição do evento*"
            :rules="[val => val && val.length > 0 || 'Descrição é obrigatória']" />

          <div class="row q-gutter-x-md">
            <div class="col">

              <q-input
                :loading="loading"
                :disable="loading"
                dense
                outlined
                label="Data do evento*"
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
              <q-input type="number" min="1" dense outlined v-model="formModel.capacity" label="Capacidade máxima*"
                :rules="[val => val && val > 1 || 'Capacidade é obrigatória']" />
            </div>
            <div class="col">
              <q-input type="number" min="1" dense outlined v-model="formModel.quantity_stages" label="Quantidade de etapas (turnos)*"
                :rules="[val => val && val > 1 || 'Quantidade de estágios é obrigatório']" />
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


  <q-dialog v-model="dialogPeopleModel" persistent side="right" overlay bordered :width="450">

    <q-card style="width: 60vw; max-width: 95vw" class="brand-border-radius-16">
      <q-toolbar>
        <q-icon name="group" size="24px" />
        <q-toolbar-title>Pessoas no evento - {{eventDetails.description}} </q-toolbar-title>
        <q-btn flat round dense icon="close" v-close-popup :loading="loading" :disable="loading" />
      </q-toolbar>

      <q-card-section>
        <div class="text-caption q-mb-lg flex items-center">
          <q-icon name="info" class="q-mr-xs" />
          Aqui você acompanhará as pessoas que estão no evento
        </div>

        <StandardTable :rows="peopleInEventList" :columns="columnsPeopleInEvent" row-key="id" :loading="isLoadingPeopleData">
          <template #table-top-right>
            <StandardButton label="Adicionar pessoa" buttonClass="brand-button-secondary" leftIcon="add" @click="dialogAddPersonInEventModel = true" />
          </template>

          <template #column-entry_code="{row}">
            <span v-if="row.pivot?.entry_code">
              {{ row.pivot?.entry_code }} 
            </span>
            <span v-else class="text-negative">
              Não informado
            </span>
          </template>

          <template #column-actions="{row}">

            <div class="flex items-center justify-center">
              <StandardButton flat buttonClass="brand-button-flat text-negative" :loading="isLoadingSave" popupProxy color="negative"
                leftIcon="cancel" size="12px" tooltip="Remover pessoa do evento" @confirm="detachPersonEvent(eventDetails.id, row.id)" />
            </div>
      
          </template>
        </StandardTable>

      </q-card-section>
    </q-card>
  </q-dialog>

  <q-dialog v-model="dialogAddPersonInEventModel" persistent side="right" overlay bordered :width="450">

    <q-card style="width: 60vw; min-height: 38vh; max-width: 95vw" class="brand-border-radius-16">
      <q-toolbar>
        <q-icon name="person_add" size="24px" />
        <q-toolbar-title>Adicionar pessoa no evento</q-toolbar-title>
        <q-btn flat round dense icon="close" v-close-popup :loading="loading" :disable="loading" />
      </q-toolbar>

      <q-card-section>
        <div class="text-caption q-mb-lg flex items-center">
          <q-icon name="info" class="q-mr-xs" />
          Adicione as informações da pessoa e clique em "Salvar"
        </div>

        <q-form @submit="onSubmitEventPerson" autofocus class="q-gutter-y-sm" v-model="formPersonModel" ref="formPersonEvent">

          <q-select
            v-model="formPersonModel.person_id"
            use-input
            @filter="filterOptionsPeople"
            :options="optionsPeople"
            label="Selecione a pessoa"
            emit-value
            option-value="id"
            option-label="name"
            map-options
            dense
            outlined
          >
          </q-select>

          <q-input dense outlined autogrow clearable v-model="formPersonModel.entry_code" label="Código de Entrada"
            mask="AAA-####" unmasked-value hint="Digite 3 letras e 4 números"
            :rules="[
              val => !val || /^[A-Za-z]{3}\d{4}$/.test(val) || 'Formato: 3 letras + 4 números (ex: ABC1234)'
            ]" />
    
          <div class="q-mt-lg q-gutter-x-sm flex items-center q-gutter-x-sm justify-end">
            <StandardButton v-if="isEdit" label="Cancelar" buttonClass="brand-button-negative" v-close-popup :loading="isLoadingSave" />
            <StandardButton label="Salvar" buttonClass="brand-button-secondary" @click="formPersonEvent.submit()" :loading="isLoadingSave" />
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
const isLoadingSave = ref(false);
const isLoadingData = ref(false);
const isLoadingPeopleData = ref(false);
const eventsList = ref([]);
const peopleInEventList = ref([]);
const dialogModel = ref(false);
const dialogPeopleModel = ref(false);
const dialogAddPersonInEventModel = ref(false);
const eventDetails = ref();
const isEdit = ref(false);
const form = ref(null)
const formPersonEvent = ref(null)
const optionsPeople = ref([[]])

const initialForm = {
  description: null,
  date: null,
  capacity: null,
  quantity_stages: 2
}
const formModel = ref(initialForm);

const formPersonModel = ref({
  person_id: null,
  entry_code: null,
});
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

const columnsPeopleInEvent = [
  { name: 'name', field: 'name', label: 'Descrição', sortable: true, align: 'left' },
  { name: 'cpf', field: 'cpf', label: 'CPF', sortable: true, align: 'left' },
  { name: 'entry_code', field: 'entry_code', label: 'Entrada', sortable: true, align: 'left' },
]

const openPeopleEventDialog = (eventRow) => {
  dialogPeopleModel.value = true;
  eventDetails.value = eventRow;

  getPersonEvent(eventRow.id);
}

const filterOptionsPeople = async (val, update, abort) => {
  const people = await getPeople();

  if (val === '') {
    update(() => {
      // filtra apenas por pessoas que não estão no evento;
      optionsPeople.value = people.filter(person => 
        !peopleInEventList.value.some(personInEvent => personInEvent.id === person.id)
      );
    })
    return
  }
  update(() => {
    const needle = val.toLowerCase()
    optionsPeople.value = people.filter(
      v => v.name.toLowerCase().indexOf(needle) > -1
    )
  })
}

const getPeople = async () => {
  const response = await api.get(
    `/people`
  );

  return response.data
}

const getPersonEvent = async (eventId) => {
  isLoadingPeopleData.value = true;
  const response = await api.get(
    `/events/${eventId}/people`
  );

  if(response.data){
    peopleInEventList.value = response.data;
  }

  isLoadingPeopleData.value = false;
}

const detachPersonEvent = async (eventId, personId) => {
  isLoadingPeopleData.value = true;
  const response = await api.delete(
    `/events/${eventId}/people/${personId}`
  );

  if(response.data){
    getPersonEvent(eventId);
    notifySuccess('Alterações foram salvas');
  }

  isLoadingPeopleData.value = false;
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
  formModel.value.date = row.date ? date.formatDate(row.date, 'YYYY-MM-DD') : null;
}

const getEvents = async () => {
  isLoadingData.value = true;
  const response = await api.get(
    '/events'
  );

  if(response.data){
    eventsList.value = response.data;
  }
  isLoadingData.value = false;
}

const onSubmit = async () => {
  isLoadingSave.value = true;

  let response;

  if (isEdit.value) {
    const endpoint = `/events/${formModel.value.id}`;
    response = await api.put(endpoint, formModel.value);
  } else {
    response = await api.post('/events', formModel.value);
  }

  if(response.data){
    getEvents();
    dialogModel.value = false;
    notifySuccess('Alterações foram salvas');
    isLoadingSave.value = false
    return
  }

  notifyError('Erro ao realizar alteração')
  isLoadingSave.value = false
}

const onSubmitEventPerson = async () => {
  isLoadingPeopleData.value = true;
  const eventId = eventDetails.value.id;

  const response = await api.post(`events/${eventId}/people`, formPersonModel.value);

  if(response.data){
    getPersonEvent(eventId);
    dialogAddPersonInEventModel.value = false;
    notifySuccess(`Pessoa adicionada no evento: ${eventDetails.value.description}`);
    isLoadingSave.value = false

    formPersonModel.value = {
      person_id: null,
      entry_code: null
    }
    return
  }

  notifyError('Erro ao realizar alteração')
  isLoadingPeopleData.value = false
}

const deleteData = async (id) => {
  isLoadingSave.value = true;
  
  try{
    const response = await api.delete(
      `/events/${id}`,
    );
  
    getEvents();
    notifySuccess('Dado foi apagado');
  }
  catch(error){
    notifyError('Erro ao apagar dado')
  }

  isLoadingSave.value = false
}

</script>
