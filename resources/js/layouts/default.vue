<template>
  <v-app-head :title="title" />

  <div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-12">
      <div class="mb-4">
        <div v-if="alertRef" class="p-4 mb-4 bg-indigo-100 rounded-lg dark:bg-indigo-200" role="alert">
          <div class="flex items-center">
            <svg class="mr-2 w-5 h-5 text-indigo-700 dark:text-indigo-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <h3 class="text-lg font-medium text-indigo-700 dark:text-indigo-800">Pending Payment Alert!</h3>
          </div>
          <div class="mt-2 mb-4 text-sm text-indigo-700 dark:text-indigo-800">You have {{ props.payments.length }} pending payment, please click button bellow to view and complete your payment process.</div>
          <div class="flex">
            <v-app-link :href="$route('payment.index')" class="text-indigo-700 bg-transparent border border-indigo-700 hover:bg-indigo-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:border-indigo-800 dark:text-indigo-800 dark:hover:text-white">View More</v-app-link>
          </div>
        </div>

        <div v-if="props.flash.error" class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
          <v-icon name="InformationCircleIcon" class="inline flex-shrink-0 mr-3 w-5 h-5" />
          <div>{{ props.flash.error }}</div>
        </div>
        <div v-if="props.flash.success" class="flex p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
          <v-icon name="InformationCircleIcon" class="inline flex-shrink-0 mr-3 w-5 h-5" />
          <div>{{ props.flash.success }}</div>
        </div>
      </div>

      <Heading :auth="auth" v-if="headerRef" />

      <slot />
    </div>
  </div>
</template>

<script setup>
import Heading from "~/components/pages/heading";
import { ref, onMounted, watch } from "vue";

const alertRef = ref(false);
const headerRef = ref(true);

const props = defineProps({
  app: Object,
  auth: Object,
  title: String,
  flash: Object,
  payments: Object,
});

const watchPayment = () => {
  if (props.payments.length && props.auth && !window.location.pathname.startsWith("/payment")) {
    alertRef.value = true;
  } else {
    alertRef.value = false;
  }
};

const watchHeader = () => {
  if (["/customer", "/auth/login"].includes(window.location.pathname)) {
    headerRef.value = false;
  } else {
    headerRef.value = true;
  }
};

onMounted(() => {
  watchHeader();
  watchPayment();
});

watch(
  () => props.payments,
  () => {
    watchHeader();
    watchPayment();
  },
  { deep: true },
);
</script>
