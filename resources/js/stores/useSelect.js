import axios from "axios";
import { throttle } from "lodash";
import { defineStore } from "pinia";

export const useSelect = defineStore("select", {
  actions: {
    options: throttle(async function (query) {
      try {
        const { data } = await axios.get(`${process.env.MIX_APP_URL}/select/categories?q=${query}`, {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        });

        return data.data.map((v) => {
          return {
            value: v.id,
            label: v.name,
          };
        });
      } catch (error) {
        console.log(error);
      }
    }, 500),
  },
});
