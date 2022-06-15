<script setup>
const props = defineProps({
  message: {
    type: String,
    default: "Empty lists",
  },
});
</script>

<template>
  <div class="flex flex-col items-center justify-center">
    <v-icon name="InboxIcon" class="w-24 h-24 mb-8 text-gray-400" />
    <h1 v-html="message" class="text-2xl text-gray-400"></h1>
  </div>
</template>