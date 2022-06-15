<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" :initialFocus="focusRef" @close="closeModal">
      <div class="fixed inset-0 z-30 overflow-y-auto bg-black/20 backdrop-blur-sm transition duration-100 dark:bg-cool-gray-700/20">
        <div class="flex min-h-screen px-4 items-center justify-center">
          <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
            <DialogOverlay class="fixed inset-0" />
          </TransitionChild>

          <!-- <span class="inline-block h-screen align-middle" aria-hidden="true"> &#8203; </span> -->

          <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
            <div class="fixed inline-block transform py-8 transition-all w-full max-w-lg">
              <div class="bg-white shadow-md p-6 rounded-md">
                <slot />
              </div>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { onMounted, ref, watch, watchEffect } from "vue";
import { TransitionRoot, TransitionChild, Dialog, DialogOverlay } from "@headlessui/vue";

const focusRef = ref(null);
const isOpen = ref(false);

const closeModal = function () {
  isOpen.value = false;
};

const openModal = function (attr) {
  isOpen.value = true;
};

defineExpose({
  openModal,
  closeModal,
});
</script>
