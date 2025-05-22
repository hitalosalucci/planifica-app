<template>
  <q-table v-if="processedRows" flat
    class="bg-light q-px-lg brand-border-radius-12"
    :class="($q.dark.isActive ? 'grid-dark' : 'grid') + (hasActions && ' sticky-last-column')"
    :loading="loading || !processedRows" :rows="processedRows" :columns="processedColumns"
    v-model:selected="selectedRows" :pagination="processedInitialPagination" :filter="filterModel"
    :selection="selection" :hide-bottom="hideBottom">
    <template #top>
      <div class="flex justify-between col-12">
        <div>
          <div v-if="!hideSearch">
            <div class="text-h6 q-mb-lg text-weight-bold">
              {{ title }}
            </div>
            <div class="q-mb-lg">
              <q-input :disable="loading || rows.length == 0" v-model="filterModel" style="min-width: 18rem;" clearable dense outlined autofocus
                autogrow debounce="600" placeholder="Buscar">
                <template v-slot:prepend>
                  <q-icon name="search" />
                </template>
              </q-input>
            </div>
          </div>
        </div>

        <div class="flex items-center">
          <slot name="table-top-right" />
        </div>

      </div>
    </template>
    <template #loading>
      <!-- <q-linear-progress indeterminate color="accent" style="position: absolute; z-index: 1; height: 2px;" /> -->
      <q-inner-loading showing>
        <q-spinner-oval color="accent" size="4em" />
      </q-inner-loading>
    </template>
    <template #no-data>
      <div class="text-center col">

        <div v-if="!rows || loading">
          <div class="flex items-center justify-center q-mt-xl">
            <img src="images/illustrations/cloud-storage.png" width="230px">
          </div>
          <div class="q-ma-none q-mt-md text-h6">
            Carregando informações
          </div>
          <div class="text-caption">
            Por favor, aguarde...
          </div>
        </div>

        <div v-else-if="rows.length == 0">

          <div v-if="slots['table-no-data']">
            <slot name="table-no-data"></slot>
          </div>

          <div v-else>
            <div class="flex items-center justify-center q-mt-xl">
              <img src="images/illustrations/nothing-here.png" width="200px">
            </div>
            <div class="q-ma-none q-mt-md text-h6">
              Não há dados
            </div>
            <div class="text-caption">
              Sem informações para mostrar
            </div>
          </div>

        </div>
        <div v-else>
          <div class="flex items-center justify-center q-mt-xl">
            <img src="images/illustrations/match-not-found.png" width="200px">
          </div>
          <h6 class="q-ma-none q-mt-md text-h6">Nada encontrado</h6>
          <div class="text-caption" v-if="filterModel">Verifique os filtros de busca</div>
        </div>
      </div>
    </template>
    <template #header="props">
      <q-tr :props="props">
        <q-th v-for="col in props.cols" :key="`td-header-${col.name}`"
        :class="`[col.align ? text-${col.align} : 'text-center']`" class="brand-bg-primary-light text-grey-7">
          {{ col.label }}
        </q-th>
      </q-tr>
    </template>
    <template #body="props">
      <q-tr :props="props">
        <q-td name="column-checkbox" auto-width v-if="selection != 'none'" :value="props.selected">
          <q-checkbox v-model="props.selected" />
        </q-td>

        <q-td auto-width v-for="col in props.cols" :key="`td-body-${col.name}`"
          :class="`[col.align ? text-${col.align} : 'text-center',  col.class]`" :style="col.style">
          <slot v-if="col.name != 'actions' && col.visible != false" :name="`column-${col.name}`" :value="col.value"
            :row="props.row" :col="col">
            {{ col.value }}
          </slot>
          <slot v-else-if="hasActions && col.visible != false">
            <slot name="column-actions" :col="col" :row="props.row" :index="props.rowIndex"></slot>
          </slot>
        </q-td>

      </q-tr>
    </template>
  </q-table>
  <q-markup-table v-else>
    <thead>
      <tr>
        <th class="text-left" style="width: 150px">
          <q-skeleton animation="blink" type="text" />
        </th>
        <th class="text-right">
          <q-skeleton animation="blink" type="text" />
        </th>
        <th class="text-right">
          <q-skeleton animation="blink" type="text" />
        </th>
        <th class="text-right">
          <q-skeleton animation="blink" type="text" />
        </th>
        <th class="text-right">
          <q-skeleton animation="blink" type="text" />
        </th>
        <th class="text-right">
          <q-skeleton animation="blink" type="text" />
        </th>
      </tr>
    </thead>

    <tbody>
      <tr v-for="n in 5" :key="n">
        <td class="text-left">
          <q-skeleton animation="blink" type="text" width="85px" />
        </td>
        <td class="text-right">
          <q-skeleton animation="blink" type="text" width="50px" />
        </td>
        <td class="text-right">
          <q-skeleton animation="blink" type="text" width="35px" />
        </td>
        <td class="text-right">
          <q-skeleton animation="blink" type="text" width="65px" />
        </td>
        <td class="text-right">
          <q-skeleton animation="blink" type="text" width="25px" />
        </td>
        <td class="text-right">
          <q-skeleton animation="blink" type="text" width="85px" />
        </td>
      </tr>
    </tbody>
  </q-markup-table>
</template>

<script setup>
defineOptions({
  name: "StandardTable",
});

import { ref, computed, useSlots } from 'vue';

const slots = useSlots();
const selectedRows = ref([]);
const filterModel = ref('');

const _initialPagination = {
  sortBy: 'desc',
  descending: false,
  page: 0,
  rowsPerPage: 50,
};

const props = defineProps({
  rows: { type: Array, required: true, default: () => null },
  columns: { type: Array, required: true, default: () => [] },
  initialPagination: { type: Object, required: false },
  loading: { type: Boolean, required: false, default: false },
  selection: { type: String, required: false, default: 'none' },
  hasActions: { type: Boolean, required: false, default: true },
  hideBottom: { type: Boolean, required: false, default: false },
  hideSearch: { type: Boolean, required: false, default: false },
  title: { type: String, required: false, default: '' },
})

const processedRows = computed(() => props.rows || null);

const processedColumns = computed(() => {
  const columns = [...props.columns];

  if (props.hasActions) {
    columns.push({
      name: 'actions',
      field: 'actions',
      label: 'Ações',
      sortable: false,
      align: 'center',
    });
  }

  return columns;
});

const processedInitialPagination = ref(props.initialPagination || _initialPagination);

</script>

<style lang="scss">
.grid-dark.sticky-last-column div thead tr th:last-child,
.grid-dark.sticky-last-column div tbody tr td:last-child {
  right: 0;
  opacity: 0.9;
}

.grid.sticky-last-column div thead tr th:last-child,
.grid.sticky-last-column div tbody tr td:last-child {
  right: 0;
  opacity: 1;
  border-left: 1px solid $grey-3;
}

.grid-dark.sticky-last-column div thead tr th:last-child {
  color: #fff;
  font-weight: bold;
}

.grid .q-table__top{
  padding: 0 !important;
}

.grid div thead tr th,
.grid-dark div thead tr th {
  font-weight: bold;
  font-size: 0.8rem;
  line-height: 2rem;
}

.grid.sticky-last-column div thead tr th:last-child {
  border-left: 1px solid $grey-3;
  border-radius: 0 10px 0 0
}

.grid.sticky-last-column div thead tr th:first-child {
  border-radius: 10px 0 0 0
}

.max-characters {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  max-width: 250px;
}

.icon-full-screen {
  position: absolute;
  top: 5px;
  right: 5px;
}

.grid tr:nth-child(even) {
  background-color: $grey-1;
}
</style>