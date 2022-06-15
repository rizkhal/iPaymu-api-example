// inertia
import { Head, Link } from "@inertiajs/inertia-vue3";

// headlessui
import { MenuItem, MenuItems, MenuButton, Menu as MainMenu, Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";

// calendar
import "v-calendar/dist/style.css";
import { SetupCalendar, Calendar, DatePicker } from "v-calendar";

export default {
  install: (app, options) => {
    // inertia
    app.component("v-app-head", Head);
    app.component("v-app-link", Link);

    // calendar
    app.use(SetupCalendar, {});
    // Use the components
    app.component("Calendar", Calendar);
    app.component("DatePicker", DatePicker);

    // common
    app.component("v-icon", require("~/components/common/icon.vue").default);
    app.component("v-dropdown", require("~/components/common/dropdown.vue").default);
    app.component("v-text-input", require("~/components/common/text-input.vue").default);
    app.component("v-multiselect", require("~/components/common/multi-select.vue").default);
    app.component("v-datepicker", require("~/components/common/datepicker.vue").default);
    app.component("v-empty-box", require("~/components/common/empty-box.vue").default);
    app.component("v-datatable", require("~/components/datatable/datatable.vue").default);

    // modal
    app.component("v-modal", require("~/components/modal/default.vue").default);

    // headlessui
    app.component("v-main-menu", MainMenu);
    app.component("v-menu-item", MenuItem);
    app.component("v-menu-items", MenuItems);
    app.component("v-menu-button", MenuButton);
    // ...
    app.component("v-popover", Popover);
    app.component("v-popover-panel", PopoverPanel);
    app.component("v-popover-button", PopoverButton);
  },
};
