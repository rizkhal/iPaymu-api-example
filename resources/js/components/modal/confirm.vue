<template>
  <div class="rounded-md border bg-white shadow0">
    <div class="p-5 text-center">
      <div class="mx-auto flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-red-200">
        <v-icon name="TrashIcon" class="text-red-500 w-16 h-16" />
      </div>
      <div class="mt-5 text-3xl font-semibold">{{ title }}</div>
      <div class="mt-2 leading-7 text-gray-600">
        {{ message }}
      </div>
    </div>
    <div class="mt-4 flex justify-center space-x-2 p-5">
      <button @click.prevent="modal.close()" type="button" class="btn-secondary">Batal</button>
      <button @click.prevent="onAccept" class="btn-danger">Yes, Delete it!</button>
    </div>
  </div>
</template>
<script setup>
import { inject } from "vue";

const modal = inject("$modal");

const props = defineProps({
  title: {
    type: String,
    default: "Are you sure?",
  },
  message: String,
  onAccept: Function,
  onCancel: {
    type: [null, Function],
    default: () => null,
  },
});
</script>
