<template>
    <div>
        <h1>【リーダー】患者編集</h1>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-row>
                <v-col cols="12">
                    <v-text-field
                        label="部屋番号"
                        v-model="editPatientData.room"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        label="患者名"
                        v-model="editPatientData.name"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        label="性別"
                        v-model="editPatientData.sex"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-select
                        v-model="editPatientData.sex"
                        :items="gender"
                        label="性別"
                        color="#62ABF8"
                    ></v-select>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        v-model="editPatientData.birthday"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        v-model="editPatientData.hospitalization_date"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        v-model="editPatientData.surgery_date"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field v-model="editPatientData.memo"></v-text-field>
                </v-col>
                <v-btn
                    class="ma-2"
                    outlined
                    color="pink lighten-1"
                    @click="updatePatientData(editPatientData.id)"
                >
                    変更
                </v-btn>
            </v-row>
        </v-form>
    </div>
</template>
<script>
// コンポーネントのインポート

// Vue
export default {
    components: {},
    data: () => ({
        patientData: {},
        editPatientData: {
            room: "",
            name: "",
            sex: "",
            birthday: "",
            hospitalization_date: "",
            surgery_date: "",
            memo: ""
        },
        gender: ["男性", "女性", "その他", "不明"]
    }),
    created() {
        this.getPatientData();
    },
    methods: {
        // 更新する患者情報取得
        getPatientData: function() {
            axios
                .get("/api/patients/get/" + this.$route.params.patientId)
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.editPatientData = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
        // 患者情報更新
        updatePatientData: function() {
            axios
                .post("/api/patients/update/" + this.$route.params.patientId, {
                    id: this.$route.params.patientId,
                    patient: this.editPatient,
                    room: this.editPatient.room,
                    name: this.editPatient.name,
                    sex: this.editPatient.sex,
                    birthday: this.editPatient.birthday,
                    hospitalization_date: this.editPatient.hospitalization_date,
                    surgery_date: this.editPatient.surgery_date,
                    memo: this.editPatient.memo
                })
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.patient = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        }
    }
};
</script>

<style scoped></style>
