<script setup>
const props = defineProps({
  payments: Object,
});
</script>
<template>
  <div class="mt-24">
    <ul v-if="payments.length" class="space-y-4">
      <p class="mb-4">Pending Payment Lists:</p>
      <li v-for="(p, _) in payments" :key="_" class="p-4 bg-indigo-500 rounded-md text-white flex flex-row justify-between items-center">
        <h1>TRX: {{ p.detail.trx_id }}</h1>
        <a :href="p.ipaymu_session_url" class="p-2 rounded-full bg-indigo-600/80 focus:bg-indigo-700 transition-all">
          <v-icon name="CashIcon" class="w-6 h-6" />
        </a>
      </li>
    </ul>
    <v-empty-box v-else message="You don't have pending payment" />
  </div>
</template>