<template>
  <q-layout view="hHh Lpr lff">
    <q-header>
      <q-toolbar class="brand-bg-primary row" style="height: 60px">
        <div class="cursor-pointer" @click="handleGoToPage('events')">
          <q-img v-if="drawer" :src="brandData?.imageLogoHorizontalLight" width="130px" />
          <q-img v-else :src="brandData?.imageIconogram" width="40px" />
        </div>
        <div class="col flex justify-between items-center q-px-sm">
          <div>
            <q-btn
              flat
              dense
              icon="menu_open"
              @click="handleShowDrawer()"
            />
          </div>
          <div>
            
            <AccountInformationMenu />
          </div>
        </div>
      </q-toolbar>
    </q-header>
    <q-drawer
      class="column no-wrap justify-between"
      show-if-above
      persistent
      v-model="drawer"
      :mini="miniState"
      @mouseover="miniState = true"
      @mouseout="miniState = true"
      :width="0"
      :breakpoint="150"
      v-if="!showDialogFirstAccess"
    >
      <q-list>
        <q-item
          v-for="link in menuItems"
          :key="link.name"
          v-bind="link"
          clickable
          v-ripple
          :active="
            link.name && link.name.includes($route.name)
          "
          active-class="brand-active-menu"
          class="q-py-md relative-position "
          @click="handleGoToPage(link.name)"
        >
          <q-tooltip
            anchor="center right"
            self="center left"
            :offset="[20, 20]"
            class="brand-text-light brand-bg-primary"
          >
            <div class="brand-text-s-regular">{{ link.label }}</div>
          </q-tooltip>
          <q-item-section avatar>
            <q-icon
              :name="link.icon"
              width="22"
              height="auto"
              color="primary"
            />
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <div class="q-px-xl q-py-lg">

        <q-breadcrumbs class="q-mb-sm text-primary" active-color="text-weight-bold" separator="/">
          <q-breadcrumbs-el
            icon="home"
            label="Início"
            @click="handleGoToPage('events')"
            class="cursor-pointer"
          />
          <q-breadcrumbs-el
            v-for="(crumb, index) in breadcrumbs"
            :key="index"
            :label="crumb.label"
            class="text-capitalize"
            :class="{ 'text-weight-bold': index === breadcrumbs.length - 1 }"
          />
        </q-breadcrumbs>
        
        <q-separator class="q-mb-md" />

        <div>
          <div>
            <h6 class="text-h6 q-ma-none"> {{ $route.meta.label }} </h6>
            <p class="text-caption"> {{ $route.meta.description }} </p>
          </div>
        </div>

        <router-view />
      </div>
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";
import { onMounted, ref, watch } from "vue";
import { useAuthStore } from "../stores/auth";
import { useGoToRouter } from "../composable/goToRouter";
import { brandData } from "../composable/globalVariables";
import AccountInformationMenu from "../components/AccountformationMenu.vue";
import useNotify from "../composable/useNotify";

const isLoadingButton = ref(false);
const isDisabledButton = ref(false);
const miniState = ref(true);
const drawer = ref(true);
const route = useRoute();
const router = useRouter();
const showDialogFirstAccess = ref(false);
const showDialogVeryRelevantAnnouncement = ref(true);
const authStore = useAuthStore();
const { handleGoToPage, handleGoToPageReplace } = useGoToRouter();
const { notifyError, notifySuccess, notifyInfo } = useNotify();

const menuItems = router
  .getRoutes()
  .filter(route => route.meta?.label)
  .map(route => ({
    name: route.name,
    label: route.meta.label,
    icon: route.meta.icon || 'chevron_right', // opcional
    path: route.path
}))

const handleShowDrawer = () => {
  sessionStorage.setItem("showDrawer", JSON.stringify(!drawer.value));
  drawer.value = !drawer.value;
};

// const getShowDrawer = () => {
//   let storageDrawer = sessionStorage.getItem("showDrawer");
//   if (storageDrawer) {
//     return JSON.parse(storageDrawer);
//   } else {
//     return drawer.value;
//   }
// };

// watch(
//   () => route.name,
//   () => {
//     drawer.value = getShowDrawer();
//   }
// );

</script>