<script setup>
import { formatNumber } from "~/utils";

const props = defineProps({
  products: {
    type: Array,
    default: [],
  },
});
</script>

<template>
  <v-empty-box v-if="!products.length" message="Products is empty" class="my-24" />
  <template v-else>
    <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <div v-for="(product, index) in products" :key="index" class="flex flex-col items-center justify-center w-full max-w-lg mx-auto bg-white shadow-md rounded-md p-4">
        <img class="object-cover w-full rounded-md h-72 xl:h-80" :src="product.image" :alt="product.name" />
        <div class="flex flex-col w-full my-4">
          <h4 class="text-lg font-medium text-gray-700">{{ product.name }}</h4>
          <div class="flex mt-1 items-center">
            <v-icon name="TagIcon" class="w-4 h-4 mr-1" type="outline" />
            <span class="text-md">{{ product.category.name }}</span>
          </div>
        </div>
        <div class="flex items-center space-x-2">
          <p class="text-blue-500 flex items-center">
            <span class="mr-2">Price: </span>
            Rp {{ formatNumber(product.price) }}
          </p>
          <p class="text-blue-500 flex items-center">
            <span class="mr-2">Stock: </span>
            {{ formatNumber(product.qty) }}
          </p>
        </div>

        <div class="flex flex-row space-x-2 items-center min-w-full">
          <!-- <button @click.prevent="$emit('onAddToCart', product)" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
            <v-icon name="ShoppingCartIcon" class="w-5 h-5 mx-1" />
            <span class="mx-1">Add to cart</span>
          </button> -->
          <button @click.prevent="$emit('onBuy', product)" class="flex items-center justify-center w-full px-2 py-2 mt-4 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-800 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700">
            <v-icon name="ReplyIcon" class="w-5 h-5 mx-1" />
            <span class="mx-1">Buy Now</span>
          </button>
        </div>
      </div>
    </div>
  </template>
</template>