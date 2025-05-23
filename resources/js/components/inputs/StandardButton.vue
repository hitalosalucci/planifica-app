<template>
  <div :class="containerClass" :title="hasTitle && label ? label : null">
    <q-btn unelevated :ripple="false" class="brand-standard-button" :class="[buttonClass,
      { 'brand-button-disabled': disabled },
      { 'brand-rounded': rounded },
    ]" no-caps :round="round" :disabled="disabled || loading" >
      <div class="flex no-wrap items-center relative-position"
        :class="[{ 'hidden-visibility': loading }, contentClass]">
        <q-icon v-if="leftIcon" :name="leftIcon" :size="leftSizeIcon" class="q-mr-xs" />
        <span v-if="label" class="q-ma-none" :class="labelContainerClass">
          {{ label }}
        </span>
        <q-icon v-if="rightIcon" :name="rightIcon" :size="rightSizeIcon" />
      </div>
      <q-spinner v-if="loading" size="24px" class="absolute" :class="`${classSpinner} text-${$attrs.color}`"  />
      <slot></slot>
      <q-popup-proxy v-if="popupProxy">
        <q-banner style="max-width: 380px">
          <div class="text-subtitle1">
            <q-icon size="20px" name="fa-solid fa-circle-question" color="green-5" />
            <span class="q-pl-sm text-center" v-html="popupProxyTitle"></span>
          </div>
          <q-separator class="q-mb-md" />
          <div class="flex items-center justify-between q-gutter-x-md" style="min-width: 265px">
            <div>
              <StandardButton outline buttonClass="brand-button-negative" label="Cancelar" v-close-popup />
            </div>
            <div>
              <StandardButton buttonClass="brand-button-positive" label="Confirmar" @click="confirm" v-close-popup />
            </div>
          </div>
        </q-banner>
      </q-popup-proxy>
      <q-tooltip v-if="!!tooltip" :class="$attrs.disable ? 'bg-grey' : `bg-${$attrs.color}`" transition-show="rotate"
        transition-hide="rotate" ref="tooltip">
        {{ tooltip }}
      </q-tooltip>
    </q-btn>
  </div>
</template>

<script setup>
defineOptions({
  name: "StandardButton",
});

//Usado na confirmação do popupProxy
const emits = defineEmits(['confirm']);

const props = defineProps({
  label: String,
  leftIcon: String,
  leftSizeIcon: String,
  rightIcon: String,
  rightSizeIcon: String,
  containerClass: String,
  contentClass: String,
  labelContainerClass: String,
  buttonClass: {
    type: String,
    default: 'brand-button-primary',
  },
  round: {
    type: Boolean,
    default: false,
  },
  rounded: {
    type: Boolean,
    default: true,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  classSpinner: {
    type: String,
    default: "brand-text-light",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  hasTitle: {
    type: Boolean,
    default: true,
  },
  popupProxy: {
    type: Boolean,
    required: false,
    default: false
  },
  popupProxyTitle: {
    type: String,
    required: false,
    default: 'Deseja realizar essa ação?'
  },
  tooltip: {
    type: String,
    required: false
  },
});

const confirm = () => {
  emits('confirm');
}

</script>
