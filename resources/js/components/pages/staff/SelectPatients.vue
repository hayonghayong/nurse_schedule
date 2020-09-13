<template>
    <!-- 仮オブジェクト -->
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【スタッフ】患者選択</v-list-item-title>
                <ul>
                    <li v-for="patient in patients" v-bind:key="patient.id">
                        <span>{{ patient.room }}号室</span>
                        <p>{{ patient.name }}さん
                        <span v-if="patient.sex　== 1">男</span>
                        <span v-else>女</span>
                        {{ patient.birthday }}
                        {{ today }}

                        </p>
                        <!-- dbには誕生日登録してるけど表示は年齢にしたい！ -->
                        
                        {{ patient.hospitalization_date }}
                        {{ patient.surgery_date }}
                        <p>{{ patient.memo }}</p>
                    </li>
                </ul>
                <v-text-field v-model="patients.id"></v-text-field>
                <v-btn
                    class="ma-2"
                    outlined
                    color="pink lighten-1"
                    @click="select(patients.id)"
                >
                    決定
                </v-btn>
            </v-list-item-content>
        </v-list-item>
    </v-card>
    <!-- ここまで -->
</template>
<script>
// コンポーネントのインポート
import moment from 'moment';
// Vue
export default {
    components: {},
    data: () => ({
        patients: [],
        usersPatients: []
    }),
    methods: {
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

        select: function(patientsId) {
            console.log(patientsId);
            axios
                .post("/api/users_patients/add/" + patientsId, {
                    id: patientsId
                    
                })
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.usersPatients = res.data;
                })
                .catch(err => {
                    "err:", err;
                });
        },
        age: function (patients) {
            var today = moment();
            var birthday = moment(birthday);
            return today.diff(this.birthday, 'years');
        }

    },
    computed: {
    },

    created() {
        this.fetchPatients();
    }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
