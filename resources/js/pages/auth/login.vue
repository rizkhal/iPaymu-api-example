<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
  email: 'user@mail.com',
  password: 'secret123',
});

const login = () => {
  form.post(route("auth.login.store"));
};
</script>
<template>
  <div class="container mx-auto max-w-lg w-max">
    <form @submit.prevent="login" class="flex flex-col space-y-6 bg-white p-4 rounded-md shadow-md">
      <v-text-input label="Email" :error="form.errors.email" v-model="form.email" />

      <v-text-input type="password" label="Password" :error="form.errors.password" v-model="form.password" />

      <button type="submit" class="btn-primary" :disabled="form.processing">
        <svg v-show="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>

        Login
      </button>
    </form>
  </div>
</template>