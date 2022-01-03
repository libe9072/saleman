import Vue from "vue";
import Vuetify from "vuetify/lib";

Vue.use(Vuetify);
const ignoreWarnMessage =
  "The .native modifier for v-on is only valid on components but it was used on <div>.";
Vue.config.warnHandler = function (msg, vm, trace) {
  // `trace` is the component hierarchy trace
  if (msg === ignoreWarnMessage) {
    msg = null;
    vm = null;
    trace = null;
  }
};
export default new Vuetify({
  theme: {
    options: {
      customProperties: true
    },
    themes: {
      light: {
        primary: "#0A57FF", //기본컬러
        secondary: "#0032AB", //입고
        accent: "#0B6ABF", //세컨드 기본컬러
        error: "#FF5252",
        info: "#008EEC", //이동
        success: "#4CAF50",
        change: "#26C6DA", // 상태변경
        delete: "#F06292", // 삭제
        jego: "#FF7510", // 삭제
        sm: "#9264EE", // 삭제
        gry: "#757575"
      }
    }
  },
  icons: {
    iconfont: "mdi"
  }
});
