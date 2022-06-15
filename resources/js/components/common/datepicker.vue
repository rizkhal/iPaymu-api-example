<script setup>
import { onMounted, watch } from "vue";
import { v4 as uuid } from "uuid";

const props = defineProps({
  id: {
    type: String,
    default() {
      return `datepicker-${uuid()}`;
    },
  },
  error: String,
  label: String,
  modelValue: [String, Date],
});

const emit = defineEmits(["update:modelValue"]);

const formatDate = (dtObject) => {
  return `${dtObject.getFullYear()}-${dtObject.getMonth() + 1}-${dtObject.getDate()}`;
};

watch(
  () => props.modelValue,
  (value) => {
    if (value) {
      const date = new Date(value);
      emit("update:modelValue", formatDate(date));
    }
  },
);
</script>
<template>
  <DatePicker v-model="modelValue" :masks="{ input: 'DD-MM-YYYY' }">
    <template v-slot="{ inputValue, togglePopover }">
      <div class="form-group">
        <label :for="id" v-if="label">
          {{ label }}
        </label>
        <input
          :id="id"
          type="text"
          class="cursor-pointer"
          :class="{
            'border-red-500 dark:border-red-500': error,
          }"
          :value="inputValue"
          v-bind="{ ...$attrs }"
          @click="togglePopover"
        />
        <div v-if="error" class="text-red-500 mt-2 text-sm">{{ error }}</div>
      </div>
    </template>
  </DatePicker>
</template>