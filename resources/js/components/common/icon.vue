<template>
  <div>
    <component :is="component"></component>
  </div>
</template>
<script setup>
import { computed } from "vue";

const props = defineProps({
  name: {
    type: String,
    required: true,
  },
  type: {
    type: String,
    default: "solid",
  },
});

const component = computed(() => {
  let iconName = String;

  if (props.type === "solid") {
    let solidIcon = require(`@heroicons/vue/solid`);
    iconName = solidIcon[props.name];
  }

  if (props.type === "outline") {
    let outlineIcon = require(`@heroicons/vue/outline`);
    iconName = outlineIcon[props.name];
  }

  return iconName;
});
</script>
