<template>
    <!-- 仮オブジェクト -->
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【リーダー】処置一覧</v-list-item-title>
                <ul>
                    <li
                        v-for="treatment in treatments"
                        v-bind:key="treatment.id"
                    >
                        {{ treatment.name }}
                        <v-list-item-icon>
                            <v-icon
                                class="ma-2"
                                outlined
                                color="#6c6c6c"
                                @click="Edit(treatment.id)"
                                >mdi-pencil</v-icon
                            >
                            <v-icon
                                class="ma-2"
                                outlined
                                color="#6c6c6c"
                                @click="Delete(treatment.id)"
                                >mdi-delete</v-icon
                            >
                        </v-list-item-icon>
                    </li>
                </ul>
                <v-list>
                    <v-text-field v-model="editTreatment.name"></v-text-field>
                    <v-text-field
                        v-model="editTreatment.time_required"
                    ></v-text-field>
                    <v-text-field
                        v-model="editTreatment.required_flg"
                    ></v-text-field>
                    <v-btn
                        class="ma-2"
                        outlined
                        color="pink lighten-1"
                        @click="Update(editTreatment.id)"
                    >
                        変更
                    </v-btn>
                </v-list>
            </v-list-item-content>
        </v-list-item>
    </v-card>
    <!-- ここまで -->
</template>
<script>
// コンポーネントのインポート

// Vue
export default {
    components: {},
    data: () => ({
        treatments: [],
        editTreatment: {
            name: "",
            time_required: "",
            required_flg: ""
        }
    }),
    methods: {
        fetchTreatment: function() {
            axios
                .get("/api/treatments/get/all")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.treatments = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
        //処置削除
        Delete: function(treatmentId) {
            if (confirm("削除してよろしいでしょうか?"))
                axios
                    .delete("/api/treatments/delete", {
                        data: { id: treatmentId }
                    })
                    .then(res => {
                        console.log("status:", res.status);
                        console.log("body:", res.data);
                        this.treatments = res.data;
                    })
                    .catch(err => {
                        console.log("err:", err);
                    });
        },

        // 更新する処置情報取得
        Edit: function(treatmentId) {
            axios
                .get("/api/treatments/get/" + treatmentId, {})
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.editTreatment = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
        // 処置情報更新
        Update: function(editTreatmentId) {
            axios
                .post("/api/treatments/update/" + editTreatmentId, {
                    id: editTreatmentId,
                    treatment: this.editTreatment,
                    treatment_name: this.editTreatment.name,
                    treatment_time: this.editTreatment.time_required,
                    treatment_required: this.editTreatment.required_flg
                })
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.treatment = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        }
    },
    created() {
        this.fetchTreatment();
    }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
