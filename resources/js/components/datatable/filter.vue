<template>
  <v-dropdown-2>
    <div class="flex flex-col space-y-4 p-4">
      <template v-for="(field, key) in fields" :key="key">
        <div class="w-64">
          <v-multi-select
            :label="fields[key].name"
            @select="handleSelect($event, key)"
            v-model="models[key]"
            :url="fields[key].url"
          />
        </div>
      </template>
      <button
        class="btn-red btn-ring-red w-full"
        type="button"
        @click.prevent="handleClear"
      >
        Bersihkan
      </button>
    </div>
  </v-dropdown-2>
</template>
<script>
import { pickBy } from "lodash";

export default {
  props: {
    fields: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      models: Object.keys(this.fields).reduce(
        (ac, a) => ({ ...ac, [a]: null }),
        {}
      ),
      filters: [],
    };
  },
  methods: {
    handleSelect(event, key) {
      this.filters[`filters[${key}]`] = event.value;
      this.models[key] = event;
    },
    handleClear() {
      this.$inertia.get(`${window.location.pathname}`);
    },
  },
  watch: {
    models: {
      handler: function (event) {
        let params = pickBy(this.filters);

        this.$inertia.get(`${window.location.pathname}`, params, {
          replace: true,
          preserveState: true,
        });
      },
      deep: true,
    },
  },
};
</script>
