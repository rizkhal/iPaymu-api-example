<script setup>
import { inject } from "vue";
import { Inertia } from "@inertiajs/inertia";

const modal = inject("$modal");

const props = defineProps({
  datatable: Object,
});

const create = () => {
  modal.open({
    component: require("./create.vue").default,
  });
};

const edit = (customer) => {
  modal.open({
    customer: customer,
    component: require("./edit.vue").default,
  });
};

const destroy = (customer) => {
  modal.destroy({
    message: "This action will be delete customer permanently",
    onAccept: () => {
      Inertia.delete(route("customer.destroy", { customer }), {
        onSuccess: () => modal.close(),
      });
    },
  });
};
</script>
<template>
  <div class="flex flex-col">
    <div class="mb-8">
      <v-app-link href="/" class="btn-primary">
        <div class="flex flex-row items-center">
          <v-icon name="ArrowLeftIcon" class="w-4 h-4 mr-1" />
          Back to dashboard
        </div>
      </v-app-link>
    </div>

    <!-- click column name for sorting -->
    <v-datatable :datatable="datatable" :allowFilter="true">
      <template #attributes>
        <button @click.stop="create" type="button" class="btn-primary">
          <div class="flex flex-row items-center">
            <v-icon name="PlusCircleIcon" class="w-4 h-4 mr-1" />
            Tambah
          </div>
        </button>
      </template>
      <template #filtered="{ attributes }">
        <div>{{ attributes }}</div>
      </template>

      <template #birth_date="{ item: { birth_date } }">
        <span>{{ birth_date.value }}</span>
      </template>
      <template #action="{ item }">
        <div class="flex flex-row space-x-2">
          <button @click.stop="edit(item)" class="btn-warning">
            <v-icon name="PencilAltIcon" class="w-4 h-4" />
          </button>
          <button @click.stop="destroy(item.id)" class="btn-danger">
            <v-icon name="TrashIcon" class="w-4 h-4" />
          </button>
        </div>
      </template>
    </v-datatable>
  </div>
</template>