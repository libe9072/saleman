const timeout = 500;

import axios from "axios";
import { store } from "../store";

export const Auth = {
  login(data) {
    return new Promise((resolve, reject) => {
      const token = Math.random()
        .toString(36)
        .substring(2);
      localStorage.token = token;
      store.commit({
        type: "sessionDataUpdate",
        datas: data
      });
      this.onChange(true);
      resolve({ token });
    });
  },
  logout() {
    return new Promise((resolve, reject) => {
      axios
        .post("/api/saleman/logoutSaleman?_method=PUT", {
          _token: this.csrfToken,
          params: { type: "mod" },
        })
        .then(({ data }) => {
          delete localStorage.token;
          store.commit({
            type: "sessionDataDelete"
          });
          this.onChange(false);
          resolve();
        });
    });
  },
  loggedIn: async function () {
    this.mixVersion = document.querySelector('meta[name="mixVersion"]').content;
    await axios
      .post("/api/saleman/showMid?_method=PUT", {
        _token: this.csrfToken,
        params: { type: "mod" },
      })
      .then(({ data }) => {
        console.info(data);
        if (data.mixVersion !== this.mixVersion) {
          window.location.reload();
        }
        if (typeof data.sessionData.SSEQNO === "undefined") {
          console.info(1);
          delete localStorage.token;
          store.commit({
            type: "sessionDataDelete"
          });
          this.onChange(false);
        } else {
          if (typeof localStorage.token === "undefined") {
            console.info(2);
            delete localStorage.token;
            store.commit({
              type: "sessionDataDelete"
            });
            this.onChange(false);
          } else if (store.state.sessionData.SSEQNO === null) {
            console.info(3);
            store.commit({
              type: "sessionDataUpdate",
              datas: data.sessionData
            });
          }
        }
      });
    return !!localStorage.token;
  },
  onChange() { }
};
