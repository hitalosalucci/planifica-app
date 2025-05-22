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
      <q-spinner v-if="loading" size="24px" class="absolute" :class="classSpinner" />
      <slot></slot>
    </q-btn>
  </div>
</template>

<script setup>
defineOptions({
  name: "StandardButton",
});

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
});

</script>
