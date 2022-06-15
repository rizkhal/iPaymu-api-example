<template>
  <div v-if="links.length > 3">
    <div class="-mb-1 flex flex-wrap">
      <template v-for="(link, key) in links">
        <div
          v-if="link.url === null"
          :key="key"
          class="
            mb-1
            mr-1
            rounded
            border
            px-4
            py-3
            text-sm
            leading-4
            text-cool-gray-700
            dark:border-cool-gray-700
          "
          v-html="link.label"
        />
        <v-app-link
          v-else
          :key="`link-${key}`"
          class="
            mb-1
            mr-1
            rounded
            border
            px-4
            py-3
            text-sm
            leading-4
            text-cool-gray-700
            hover:bg-white
            focus:border-indigo-500 focus:text-indigo-500
            dark:border-cool-gray-700
            dark:text-white
            dark:hover:bg-cool-gray-700
            dark:hover:text-cool-gray-50
          "
          :class="{
            'border-indigo-500 dark:bg-cool-gray-800 dark:text-white':
              link.active,
          }"
          :href="link.url"
          v-html="link.label"
        />
      </template>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    links: Array,
  },
};
</script>
