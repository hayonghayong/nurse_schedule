import axios from "axios";

const state = {
    loginUser: "未ログイン",
};

const mutations = {
    setLoginUser(state, loginUser) {
        state.loginUser = loginUser;
    }
};

const actions = {
    async getLoginUserData({ commit }) {
        await axios
            .get("/api/users/login-user")
            .then(res => {
                commit("setLoginUser", res.data);
            })
            .catch(err => console.log(err));
    }
};

const getters = {};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
};
