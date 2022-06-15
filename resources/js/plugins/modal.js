import { h, render } from "vue";

let currentModalComponent = null;

export const useModal = (app, options) => {
  const component = (props, child) => {
    const node = h(require("~/components/modal/default.vue").default, props, child);

    if (app?._context) {
      node.appContext = app._context;
    }

    render(node, document.body);

    currentModalComponent = node.component;
  };

  return {
    open(props) {
      const childComponent = () => h(props.component, props);

      component(props, childComponent);

      currentModalComponent.exposed.openModal();
    },
    destroy(props) {
      const childComponent = () => h(require("~/components/modal/confirm.vue").default, props);

      component(props, childComponent);

      currentModalComponent.exposed.openModal();
    },
    close() {
      currentModalComponent.exposed.closeModal();
    },
  };
};

export default {
  install: (app, options) => {
    const instance = useModal(app, options);

    app.config.globalProperties.$modal = instance;
    app.provide("$modal", instance);
  },
};
