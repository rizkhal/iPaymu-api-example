<script setup>
const props = defineProps({
  histories: Object,
});
</script>
<template>
  <div class="mt-24">
    <ul v-if="histories.length" class="space-y-4">
      <p class="mb-4">Payment History Lists:</p>
      <li v-for="(p, _) in histories" :key="_" class="p-4 bg-indigo-500 rounded-md text-white flex flex-col">
        <h1>TRX: {{ p.detail.trx_id }}</h1>
        <span class="text-sm">Qty: {{ p.qty }}</span>
      </li>
    </ul>
    <v-empty-box v-else message="You don't have any histories" />
  </div>
</template>