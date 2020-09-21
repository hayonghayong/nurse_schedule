import axios from "axios";

const state = {
    chargePatient: {},
    chargePatientCount: 0
};

const mutations = {
    setChargePatient(state, chargePatient) {
        state.chargePatient = chargePatient;
    }
};

const actions = {
    async getChargePatientData({ commit }) {
        await axios
            .get("/api/users_patients/get/all")
            .then(res => {
                commit("chargePatient", res.data, { root: true });
            })
            .catch(err => console.log(err.response.data));
    }
};

const getters = {
    chargePatient: state => {
        return state.chargePatient;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
};
