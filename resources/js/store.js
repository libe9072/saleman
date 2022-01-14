import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    sessionData: {
      SSEQNO: null,
      SNAME: null,
      SUCP: null,
      SADMIN: null,
    },
    isRouterAlive: true // 라우터 갱신
  },
  mutations: {
    sessionDataUpdate(state, payload) {
      state.sessionData.SSEQNO = payload.datas.SSEQNO;
      state.sessionData.SNAME = payload.datas.SNAME;
      state.sessionData.SUCP = payload.datas.SUCP;
      state.sessionData.SADMIN = payload.datas.SADMIN;
    },
    sessionDataDelete(state) {
      state.sessionData.SSEQNO = null;
      state.sessionData.SNAME = null;
      state.sessionData.SUCP = null;
      state.sessionData.SADMIN = null;
    },
    routeReload1(state) {
      state.isRouterAlive = false;
      setTimeout(() => {
        state.isRouterAlive = true;
        // Code here
      }, 100);
    },
  },
  actions: {
  }
});
