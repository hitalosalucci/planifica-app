<template>
  <div :class="containerClass">
    <label v-if="label" :class="labelClass">
      {{ label }}
      <span v-if="required" class="brand-text-red">*</span>
    </label>

    <q-input v-model="valMask" @focus="hasFocusStyleClass = true" @blur="handleClearError"
      @keyup.enter="handleKeyupEnter" :type="type" :placeholder="placeholder" :disable="disabled" :readonly="isReadonly"
      :maxlength="maxLength" ref="inputElement" :class="[
        inputClass,
        inputStatusClass,
        { 'brand-focus-input': hasFocusStyleClass },
      ]" dense borderless no-error-icon :error="!!errorMessage">
      <template v-if="iconPrepend || titlePrepend" v-slot:prepend>
        <q-icon v-if="iconPrepend" :name="iconPrepend" :color="iconPrependColor" :size="iconSize" />
        <p v-if="titlePrepend" class="q-ma-none" :class="titlePrependClass">
          {{ titlePrepend }}
        </p>
      </template>
      <template v-if="iconAppend || titleAppend" v-slot:append>
        <q-icon v-if="iconAppend" :name="iconAppend" :color="iconAppendColor" :size="iconSize" />
        <p v-if="titleAppend" class="q-ma-none" :class="titleAppendClass">
          {{ titleAppend }}
        </p>
      </template>
    </q-input>
    <Transition name="fade">
      <span v-if="errorMessage" :class="errorClass">
        {{ errorMessage }}
      </span>
    </Transition>
  </div>
</template>

<script setup>
import { computed, ref, watchEffect, watch } from "vue";

defineOptions({
  name: "StandardInput",
});

const emit = defineEmits(["update:keyupEnter", "update:clearError"]);

const props = defineProps({
  containerClass: String,
  placeholder: String,
  label: String,
  errorMessage: String,
  iconPrepend: String,
  iconPrependColor: String,
  titlePrepend: String,
  titlePrependClass: String,
  iconAppend: String,
  iconAppendColor: String,
  titleAppend: String,
  titleAppendClass: String,
  iconSize: String,
  inputClass: {
    type: String,
    default: "brand-input-medium brand-text-m-regular",
  },
  errorClass: {
    type: String,
    default: "brand-text-error brand-text-m-regular",
  },
  labelClass: {
    type: String,
    default: "brand-text-m-regular",
  },
  type: {
    type: String,
    default: "text",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  mask: {
    type: String,
    default: "default",
  },
  max: {
    type: Number,
    default: 100,
  },
  isReadonly: {
    type: Boolean,
    default: false,
  },
  required: {
    type: Boolean,
    default: false,
  },
  isReplaceAll: {
    type: Boolean,
    default: false,
  },
  maxValue: {
    type: Number,
    default: Infinity,
  },
});

// Internal state
const text = defineModel();
const valMask = ref(text.value);
const maxLength = ref(props.max);
const inputElement = ref(null);
const hasFocusStyleClass = ref(false);

// Computed class for input status
const inputStatusClass = computed(() => {
  if (props.errorMessage) {
    return "brand-input-error";
  } else if (props.error === "success") {
    return "brand-input-success";
  }
  return "";
});

// Handles the Enter key event
const handleKeyupEnter = () => {
  inputElement.value.blur();
  emit("update:keyupEnter");
};

// Clears error messages on blur
const handleClearError = () => {
  emit("update:clearError", true);
  hasFocusStyleClass.value = false;
};

</script>
