<template>
    <div class="patientsLists">
        <v-list subheader>
            <v-subheader>患者一覧</v-subheader>
            <div v-for="(patient, index) in patients" :key="patient.id">
                <v-list-item
                    class="px-8"
                    :to="{
                        name: 'EditPatient',
                        params: { patientId: patient.id }
                    }"
                >
                    <v-list-item-avatar>
                        <v-icon class="ma-2 mdi-36px" color="#62ABF8"
                            >mdi-account</v-icon
                        >
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-subtitle class="mb-1"
                            >{{ patient.room }}号室</v-list-item-subtitle
                        >
                        <v-list-item-title
                            >{{ patient.name }}さん</v-list-item-title
                        >
                    </v-list-item-content>

                    <v-list-item-icon>
                        <!-- <v-icon
                            class="ma-2"
                            outlined
                            color="#6c6c6c"
                            @click="Edit(patient.id)"
                            >mdi-pencil</v-icon
                        > -->
                        <v-icon
                            class="ma-2"
                            outlined
                            color="#6c6c6c"
                            @click="Delete(patient.id)"
                            >mdi-delete</v-icon
                        >
                    </v-list-item-icon>
                </v-list-item>
                <v-divider
                    v-if="index + 1 < patients.length"
                    :key="index"
                ></v-divider>
            </div>
        </v-list>
    </div>
</template>

<script>
// コンポーネントのインポート

// Vue
export default {
    components: {},
    data: () => ({
        patients: [],
        editPatient: {
            room: "",
            name: "",
            sex: "",
            birthday: "",
            hospitalization_date: "",
            surgery_date: "",
            memo: ""
        }
    }),
    created() {
        this.fetchPatients();
    },
    methods: {
        // 患者一覧取得
        fetchPatients: function() {
            axios
                .get("/api/patients/get/all")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.patients = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
        // 患者削除
        Delete: function(patientId) {
            if (confirm("削除してよろしいでしょうか?"))
                axios
                    .delete("/api/patients/delete", {
                        data: { id: patientId }
                    })
                    .then(res => {
                        console.log("status:", res.status);
                        console.log("body:", res.data);
                        this.patients = res.data;
                    })
                    .catch(err => {
                        console.log("err:", err);
                    });
        }
    }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
