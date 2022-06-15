<script setup>
import { watch, inject } from "@vue/runtime-core";
import { useForm } from "@inertiajs/inertia-vue3";
import { formatNumber } from "~/utils";

const modal = inject("$modal");

const props = defineProps({
  product: Object,
});

const form = useForm({
  ...props.product,
  qty: null,
});

const buyNow = () => {
  form.post(route("redirect-payment"), {
    onSuccess: () => modal.close(),
  });
};

watch(
  () => form.qty,
  (value) => {
    if (value > props.product.qty) {
      form.errors.qty = `Qty not enough, must be less than or equal to ${props.product.qty}`;
    } else {
      form.errors.qty = null;
    }
  },
);
</script>


<template>
  <div class="flex flex-col space-y-4">
    <v-text-input type="text" label="Product" :value="product.name" disabled readonly />
    <v-text-input type="text" label="Price" :value="`Rp ${formatNumber(product.price)}`" disabled readonly />

    <v-text-input type="number" label="Qty" v-model="form.qty" :error="form.errors.qty" />

    <div class="flex flex-row justify-end space-x-2">
      <button class="btn-danger" @click.stop="$modal.close()">Cancel</button>
      <button class="btn-primary" @click.prevent="buyNow">Buy Now</button>
    </div>
  </div>
</template>