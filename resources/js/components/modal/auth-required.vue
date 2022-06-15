<script setup>
import { Inertia } from "@inertiajs/inertia";
import { inject } from "vue";

const modal = inject("$modal");

const login = () => {
  modal.close();
  Inertia.visit(route("auth.login.create"));
};
</script>
<template>
  <div class="flex flex-col">
    <h1 class="font-bold text-2xl mb-1">Authentication required</h1>
    <span>Only authenticated user can perform this action</span>

    <div class="flex flex-row mt-6 space-x-2">
      <button @click.stop="login" class="btn-primary">Login</button>
    </div>
  </div>
</template>