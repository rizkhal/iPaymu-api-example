<template>
  <div class="form-group">
    <label :for="id" v-if="label">
      {{ label }}
    </label>
    <input
      :id="id"
      ref="input"
      :type="type"
      :value="modelValue"
      :class="{
        'border-red-500 dark:border-red-500': error,
      }"
      v-bind="{ ...$attrs }"
      class="disabled:bg-gray-200/70"
      @input="emit('update:modelValue', $event.target.value)"
    />
    <div v-if="error" class="text-red-500 mt-2 text-sm">{{ error }}</div>
  </div>
</template>

<script setup>
import { v4 as uuid } from "uuid";

const props = defineProps({
  id: {
    type: String,
    default() {
      return `text-input-${uuid()}`;
    },
  },
  type: {
    type: String,
    default: "text",
  },
  error: String,
  label: String,
  modelValue: [String, Number],
});

const emit = defineEmits(["update:modelValue"]);
</script>
