<script setup>
const props = defineProps({
  auth: Object,
});
</script>
<template>
  <div class="w-full bg-indigo-500 flex flex-row justify-between items-center py-4 px-6 rounded-md text-white">
    <h1 class="font-bold text-4xl">
      <v-app-link :href="$route('product.index')">iPaymu</v-app-link>
    </h1>

    <div class="flex space-x-5">
      <div v-if="auth" class="flex flex-row items-center">
        <v-dropdown class="ml-2">
          <template #button>
            <img :src="auth.profile_picture" :alt="auth.name" class="rounded-full w-8 h-8" />
          </template>

          <div class="flex flex-col space-y-2 p-2 dark:bg-cool-gray-800">
            <v-app-link :href="$route('payment.history')" class="text-gray-800 flex flex-row items-center hover:bg-gray-300 p-2 rounded-md">
              <v-icon name="RefreshIcon" class="w-5 h-5 mr-2" type="outline" />
              <span>History</span>
            </v-app-link>
            <v-app-link :href="route('auth.logout')" method="delete" as="button" class="text-gray-800 flex flex-row items-center hover:bg-gray-300 p-2 rounded-md">
              <v-icon name="LogoutIcon" class="w-5 h-5 mr-2" type="outline" />
              <span>Logout</span>
            </v-app-link>
          </div>
        </v-dropdown>
      </div>

      <v-app-link :href="$route('auth.login.create')" v-if="!auth" class="hover:bg-indigo-400 focus:bg-indigo-400 p-2 rounded-md">
        <v-icon name="LockClosedIcon" class="w-8 h-8" type="outline" />
      </v-app-link>
    </div>
  </div>
</template>