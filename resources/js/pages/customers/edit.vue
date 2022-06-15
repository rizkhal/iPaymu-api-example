<script setup>
import { inject } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const modal = inject("$modal");

const props = defineProps({
  customer: Object,
});

const form = useForm({
  name: props.customer.name,
  job: props.customer.job,
  birth_date: props.customer.birth_date.hidden_value,
});

const update = () => {
  form.put(route("customer.update", { customer: props.customer.id }), {
    onSuccess: () => modal.close(),
  });
};
</script>
<template>
  <form class="flex flex-col space-y-5">
    <v-text-input :error="form.errors.name" label="Name" v-model="form.name" autocomplete="off" />
    <v-text-input :error="form.errors.job" label="Job" v-model="form.job" autocomplete="off" />
    <v-datepicker :error="form.errors.birth_date" label="Birth Date" v-model="form.birth_date" />
    <button @click.prevent="update" class="btn-primary">Update</button>
  </form>
</template>