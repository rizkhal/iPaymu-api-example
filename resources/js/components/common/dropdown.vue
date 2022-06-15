<template>
  <v-popover class="relative" v-slot="{ open }">
    <v-popover-button class="btn-primary flex items-center space-x-2 dark:focus:ring-offset-cool-gray-900">
      <slot name="button">
        <span v-if="text">{{ text }}</span>
        <span v-if="pill" class="rounded-lg bg-indigo-500/70 py-[1px] px-[5px]">{{ pill }}</span>
        <v-icon v-if="icon" :name="icon" type="outline" class="h-5 w-5" aria-hidden="true" />
        <img v-if="image" :src="image" alt="Image" class="rounded-full ml-6 w-10 h-10" />
      </slot>
    </v-popover-button>

    <transition enter-active-class="transition duration-200 ease-out" enter-from-class="translate-y-1 opacity-0" enter-to-class="translate-y-0 opacity-100" leave-active-class="transition duration-150 ease-in" leave-from-class="translate-y-0 opacity-100" leave-to-class="translate-y-1 opacity-0">
      <div>
        <v-popover-panel :class="[position == 'right' ? 'right-0' : position == 'left' ? 'left-0' : position]" class="absolute right-0 mt-2 min-w-[12rem] origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-cool-gray-800">
          <slot />
        </v-popover-panel>
      </div>
    </transition>
  </v-popover>
</template>
<script>
export default {
  props: {
    image: {
      type: String,
      required: false,
    },
    position: {
      type: String,
      default: "right",
    },
    icon: {
      type: String,
      required: false,
    },
    text: {
      type: String,
      required: false,
    },
    pill: {
      type: [String, Number],
      default: null,
    },
  },
};
</script>
