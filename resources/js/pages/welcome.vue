<template>
  <div
    class="
      relative
      flex
      items-top
      justify-center
      min-h-screen
      bg-gray-900
      sm:items-center
      py-4
      sm:pt-0
    "
  >
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="mt-8 bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">
          <div class="p-6 border-gray-700 md:border-t-0 md:border-r">
            <div class="flex items-center">
              <v-icon name="CashIcon" class="w-8 h-8 text-gray-500" />
              <div class="ml-4 text-lg leading-7 font-semibold">
                <v-app-link
                  :href="$route('product.index')"
                  class="underline text-white"
                >
                  Payments
                </v-app-link>
              </div>
            </div>

            <div class="ml-12">
              <div class="mt-2 text-gray-400 text-sm">
                Sample payment page using iPaymu
              </div>
            </div>
          </div>
          <div class="p-6">
            <div class="flex items-center">
              <v-icon name="UsersIcon" class="w-8 h-8 text-gray-500" />
              <div class="ml-4 text-lg leading-7 font-semibold">
                <v-app-link
                  :href="route('customer.index')"
                  class="underline text-white"
                >
                  Customers
                </v-app-link>
              </div>
            </div>

            <div class="ml-12">
              <div class="mt-2 text-gray-400 text-sm">
                Sample CRUD with UUID
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
