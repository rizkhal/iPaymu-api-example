<script setup>
import { inject } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const modal = inject("$modal");

const form = useForm({
  name: null,
  job: null,
  birth_date: null,
});

const save = () => {
  form.post(route("customer.store"), {
    onSuccess: () => modal.close(),
  });
};
</script>
<template>
  <form class="flex flex-col space-y-5">
    <v-text-input :error="form.errors.name" label="Name" v-model="form.name" autocomplete="off" />
    <v-text-input :error="form.errors.job" label="Job" v-model="form.job" autocomplete="off" />
    <v-datepicker :error="form.errors.birth_date" label="Birth Date" v-model="form.birth_date" />
    <button @click.prevent="save" class="btn-primary">Save</button>
  </form>
</template>