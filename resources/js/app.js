require("./bootstrap");
// Vue読み込み
window.Vue = require("vue");
// Vuetify読み込み
import vuetify from "./vuetify";


// VueRouter読み込み
import router from "./router";
// VueX読み込み
import store from "./store/index";
// App.vue読み込み
import App from "./components/App.vue";

const app = new Vue({
    el: "#app",
    router,
    vuetify,
    store,
    components: {
        App
    },
    template: "<App />" // ルートコンポーネントを描画する
});

