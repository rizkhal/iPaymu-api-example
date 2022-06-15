<template>
  <div class="border border-cool-gray-200 shadow sm:rounded-lg">
    <div class="p-4" v-if="title">
      <h2 class="text-xl font-bold text-gray-700 dark:text-cool-gray-300">
        {{ title }}
      </h2>
    </div>

    <div class="flex items-center border-t border-dashed bg-white p-5" :class="[$slots['attributes'] ? 'justify-between' : 'justify-end']">
      <div class="flex items-center space-x-2">
        <slot name="attributes" />
      </div>

      <div class="flex items-center space-x-2">
        <!-- search -->
        <Search v-model="params.search" v-if="allowSearch" />

        <select v-model="params.perpage" v-if="allowPerPage" class="form-select text-sm dark:text-cool-gray-300">
          <option value="30">30</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>

        <!-- filters -->
        <v-dropdown text="Filter" :pill="pill" icon="FilterIcon" v-if="allowFilter && Object.keys(datatable.fields ?? []).length">
          <div class="flex flex-col space-y-4 p-4">
            <template v-for="(field, key) in datatable.fields" :key="key">
              <div v-if="field.type === 'date'">
                <v-datepicker @update:modelValue="handleDateFilter($event, key)" :label="datatable.fields[key].name" v-model="filtersModels[key]" />
              </div>
            </template>
            <button class="btn-danger w-full" type="button" @click.prevent="handleClearFilters">Clear</button>
          </div>
        </v-dropdown>
      </div>
    </div>

    <div class="overflow-auto border-b border-dashed">
      <div class="flex space-x-6 border-t border-dashed py-2 px-4" v-if="Object.keys(filtersModels).every((x) => filtersModels[x])">
        <div class="flex items-center space-x-2">
          <p class="text-sm">Filter Applied:</p>
          <slot name="filtered" :attributes="filtersModels" />
        </div>
      </div>

      <div class="flex space-x-6 border-t border-dashed py-2 px-4" v-if="params.column && params.direction">
        <div class="flex items-center space-x-2">
          <p class="text-sm">Sort Applied:</p>
          <span class="flex items-center rounded-md bg-indigo-500 text-sm text-white">
            <p class="py-1 px-2">{{ columnName }}: {{ params.direction === "asc" ? "A-Z" : "Z-A" }}</p>
            <button @click.prevent="handleClearSort" type="button" class="mr-1 rounded-md bg-indigo-600 py-1 px-1">
              <v-icon name="XIcon" class="h-3 w-3" />
            </button>
          </span>
        </div>
      </div>

      <table class="min-w-full divide-y divide-gray-200">
        <thead class="border-t bg-gray-50">
          <tr>
            <th v-if="allowCheckbox" class="px-4 py-4 text-left text-xs font-medium text-cool-gray-500 uppercase tracking-wider">
              <input @click="handleSelectCheckboxCheckboxAll" v-model="selectAll" type="checkbox" class="form-input-checkbox form-checkbox" />
            </th>
            <template v-for="(column, index) in datatable.columns" :key="index">
              <th v-if="!column.blank" scope="col" class="px-4 py-4 text-left text-xs font-medium text-cool-gray-500 uppercase tracking-wider">
                <div class="flex items-center" @click="handleSort(column)" :class="[column.sortable ? 'cursor-pointer' : 'cursor-default']">
                  {{ column.text }}

                  <v-icon name="ChevronUpIcon" type="solid" v-if="datatable.filters && column.sortable && params.direction == 'asc' && params.column == column.column" class="ml-2 h-4 w-4" />
                  <v-icon name="ChevronDownIcon" type="solid" v-if="datatable.filters && column.sortable && params.direction == 'desc' && params.column == column.column" class="ml-2 h-4 w-4" />
                </div>
              </th>
            </template>
          </tr>
        </thead>
        <tbody v-if="datatable.data.data.length" class="divide-y divide-gray-200 bg-white">
          <template v-if="!$slots['body']">
            <tr v-for="(item, index) in datatable.data.data" :key="index" class="hover:bg-cool-gray-100 dark:hover:bg-cool-gray-800">
              <td v-if="allowCheckbox" class="px-4 py-3 whitespace-nowrap text-xs">
                <input @change="handleSelectCheckbox" v-model="selected" :value="item[checkboxKey]" type="checkbox" class="form-input-checkbox form-checkbox" />
              </td>
              <template v-for="(column, columnIndex) in datatable.columns" :key="columnIndex">
                <td v-if="!column.blank" class="px-4 py-3 whitespace-nowrap text-xs">
                  <slot :name="column.column" :item="item" />

                  <div v-if="!$slots[column.column]">
                    {{ item[column.column] }}
                  </div>
                </td>
              </template>
            </tr>
          </template>
          <template v-else>
            <slot name="body" :data="datatable.data" :columns="datatable.columns" />
          </template>
        </tbody>
        <tbody v-else>
          <tr class="dark:bg-cool-gray-900">
            <td :colspan="datatable.columns.filter((c) => c.blank === false).length" class="bg-white py-8 text-center text-cool-gray-400">
              <div class="flex flex-col items-center justify-center space-y-1 text-gray-400">
                <v-icon name="InboxIcon" type="outline" class="h-8 w-8" />
                <span>Kosong</span>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="flex items-center justify-between p-4">
      <div class="text-sm text-cool-gray-800">
        Menampilkan <span class="font-bold">{{ datatable.data.from ?? 0 }}</span> ke <span class="font-bold">{{ datatable.data.to ?? 0 }}</span> dari
        <span class="font-bold">{{ datatable.data.total }}</span>
      </div>
      <Pagination :links="datatable.data.links" />
    </div>
  </div>
</template>
<script>
import { throttle, pickBy } from "lodash";
import Search from "./search.vue";
import Pagination from "./pagination.vue";

export default {
  components: {
    Search,
    Pagination,
  },
  props: {
    title: String,
    datatable: {
      type: Object,
      required: true,
    },
    allowPerPage: {
      type: Boolean,
      default: () => true,
    },
    allowSearch: {
      type: Boolean,
      default: () => true,
    },
    allowFilter: {
      type: Boolean,
      default: () => true,
    },
    allowCheckbox: {
      type: Boolean,
      default: false,
    },
    checkboxKey: {
      type: String,
      default: "id",
    },
  },
  mounted() {
    if (this.datatable.filters && this.datatable.filters.filters !== null) {
      let keys = Object.keys(this.datatable.filters.filters);
      const isDate = keys.filter((v) => this.datatable.fields[v].type === "date");

      if (isDate) {
        isDate.map((value) => {
          this.filtersModels[value] = this.datatable.filters.filters[value];
        });
      }
    }
  },
  data() {
    return {
      selected: [],
      selectAll: false,
      params: {
        column: this.datatable.filters?.column,
        search: this.datatable.filters?.search,
        direction: this.datatable.filters?.direction,
        perpage: this.datatable.filters?.perpage ?? 30,
        filters: this.datatable.filters.filters ? Object.keys(this.datatable.filters.filters).reduce((ac, a) => ({ ...ac, [a]: this.datatable.filters.filters[a] }), {}) : null,
      },
      filtersModels: this.datatable.fields ? Object.keys(this.datatable.fields).reduce((ac, a) => ({ ...ac, [a]: null }), {}) : null,
    };
  },
  computed: {
    columnName() {
      if (this.params.column) {
        return this.datatable.columns.filter((v) => v.column === this.params.column)[0].text;
      }
    },
    pill() {
      return this.datatable.filters.filters ? Object.keys(this.datatable.filters.filters).length : null;
    },
  },
  methods: {
    handleSort({ column, sortable }) {
      if (!sortable) return;

      this.params.column = column;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },
    handleClearSort() {
      this.params.column = null;
      this.params.direction = null;
    },
    handleDateFilter(event, key) {
      if (this.params.filters) {
        this.params.filters = Object.assign(this.params.filters, {
          [key]: event,
        });
      } else {
        this.params.filters = {
          [key]: event,
        };
      }
    },
    handleClearFilters() {
      if (this.params.filters) {
        Object.keys(this.params.filters).some((value) => {
          this.filtersModels[value] = null;
        });

        this.params.filters = null;
      }
    },
    handleSelectCheckbox() {
      let selected = this.datatable.data.data.filter((value) => Object.values(this.selected).includes(value[this.checkboxKey]));
      this.$emit("on-select", selected);
    },
    handleSelectCheckboxCheckboxAll() {
      let all = [];
      this.selected = [];

      if (!this.selectAll) {
        for (let item in this.datatable.data.data) {
          all.push(this.data.data[item]);
          this.selected.push(this.datatable.data.data[item][this.checkboxKey]);
        }
      }

      this.$emit("on-select-all", all);
    },
  },
  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(`${window.location.pathname}`, params, {
          replace: true,
          preserveState: true,
        });
      }, 500),
      deep: true,
    },
    selected: {
      handler: function () {
        if (this.datatable.data.data.length != this.selected.length) {
          this.selectAll = false;
        } else {
          this.selectAll = true;
        }
      },
      deep: true,
    },
  },
};
</script>
