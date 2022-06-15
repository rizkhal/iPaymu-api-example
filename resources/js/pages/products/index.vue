<script setup>
import { inject, ref } from "vue";
import ProductCard from "./card.vue";
import { Inertia } from "@inertiajs/inertia";
import { useSelect } from "~/stores/useSelect";
import { useForm } from "@inertiajs/inertia-vue3";
import Pagination from "~/components/datatable/pagination";

const modal = inject("$modal");

const loadingRef = ref(false);

const filterForm = useForm({
  category: null,
});

const props = defineProps({
  auth: Object,
  products: Object,
  filters: Object,
});

const openByNowModal = (product) => {
  if (props.auth) {
    modal.open({
      product,
      component: require("./direc-payment.vue").default,
    });
  } else {
    modal.open({
      component: require("~/components/modal/auth-required.vue").default,
    });
  }
};

const handleFilter = () => {
  loadingRef.value = true;

  let params = {};

  if (filterForm.category) {
    params = Object.assign({}, { category: filterForm.category.value });
  }

  Inertia.get(`${window.location.pathname}`, params, {
    replace: true,
    preserveState: true,
    onFinish: () => (loadingRef.value = false),
  });
};
</script>
<template>
  <div class="mt-8">
    <div class="flex flex-col md:flex-row items-center text-sm justify-between uppercase">
      <div class="w-[25em] flex flex-row space-x-2">
        <v-multiselect class="w-full" v-model="filterForm.category" placeholder="Category" :options="async (q) => await useSelect().options(q)" />
        <button :disabled="loadingRef" @click.prevent="handleFilter" class="btn-primary disabled:cursor-not-allowed disabled:bg-opacity-70">
          <svg v-show="loadingRef" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>

          Filter
        </button>
      </div>
      <p class="text-gray-500 dark:text-gray-300 mt-8 lg:mt-0">{{ products.total }} Items</p>
    </div>

    <ProductCard :products="products.data" @onBuy="openByNowModal" />

    <div class="mt-8 flex justify-end">
      <Pagination :links="products.links" />
    </div>
  </div>
</template>