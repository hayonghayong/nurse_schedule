import Vue from "vue";
import Vuex from "vuex";
// 作成したモジュールをインポート
import auth from "./modules/auth";
import patient from "./modules/patient";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        patient,
        common: {
            namespaced: true,
            state: {
              pageTitle: 'Home',
            },
            actions: {
              changePage({ commit }, title) {
                commit('cahgePageTitle', title);
              },
            },
            mutations: {
              cahgePageTitle(state, title) {
                const st = state;
                st.pageTitle = title;
              },
            },
            getters: {
              pageTitle(state) {
                const st = state;
                return st.pageTitle;
              },
             },
        },
    }
});
