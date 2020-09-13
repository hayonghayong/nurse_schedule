<template>
    <!-- 仮オブジェクト -->
    <!--<v-card>
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
                         dbには誕生日登録してるけど表示は年齢にしたい！ 
                        
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
    </v-card>-->
    <!-- ここまで -->

      <v-item-group multiple v-model="saveSelectedPatient">
        <v-container>
            <v-stepper v-model="e1"
            :vertical="vertical"
            alt-labels>
                <v-stepper-header>
                    <v-stepper-step step="1">患者選択</v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step step="2">処置設定</v-stepper-step>

                    <v-divider></v-divider>

                    <v-stepper-step step="3">スケジュール設定</v-stepper-step>
                </v-stepper-header>
            </v-stepper>

        <v-list-item-title class="center">本日の担当の患者さんを全て選択してください</v-list-item-title>
        <v-row>
            <v-col v-for="patient in patients" :key="patient.id" cols="6">
            <v-item v-slot:default="{ active, toggle }" :value="patient.id">
                <v-hover v-slot:default="{ hover }">
                <v-card
                    :color="active ? '#62ABF8' : ''"
                    class="d-flex align-center"
                    :class="{ 'on-hover': hover }"
                    outlined
                    height="200"
                    @click="toggle"
                >
                    <v-card-text>
                        <div>{{ patient.room }}号室</div>
                        <p>{{ patient.name }}さん
                        <span v-if="patient.sex　== 1">男</span>
                        <span v-else>女</span>
                        {{ patient.birthday }}
                        {{ today }}
                        </p>
                        
                        <p>{{ patient.hospitalization_date }}<br>
                        {{ patient.surgery_date }}<br>
                        {{ patient.memo }}</p>
                    </v-card-text>

                    <v-scroll-y-transition>
                    <div v-if="active" class="display-3 flex-grow-1"></div>
                    </v-scroll-y-transition>
                </v-card>
                </v-hover>
            </v-item>
            </v-col>
        </v-row>
            {{saveSelectedPatient}}

        <v-footer
        fixed
        class="font-weight-medium footer"
        >
            <v-btn
                class="mx-auto my-2 px-12 py-4 submit_btn"
                color="#62ABF8"
                rounded
                dark depressed width="220"
                type="submit"
                @click="pushSelectedData()"
            >決定</v-btn>
        </v-footer>
        </v-container>
    </v-item-group>

</template>
<script>
// コンポーネントのインポート
import moment from 'moment';
// Vue
export default {
    components: {},
    data: () => ({
        patients: [],
        saveSelectedPatient: [],
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

        pushSelectedData: function(patientsId) {
            console.log(patientsId);
            axios
                .post("/api/users_patients/add/" + patientsId, {
                    id: this.saveSelectedPatient
                    
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
.footer{
  background:rgba(255,0 0,0.5);
}
.name{
  font-size:17px;
}
.center{
  text-align:center;
  padding:1.2rem 0;
}
.theme--light.v-sheet--outlined{
  border:  solid 2px rgb(98,171,248,0.9);
}

.v-card:not(.on-hover) {
  opacity: 0.8;
  border: thin solid rgb(0,0,0,0.12);
}
.v-stepper{
    box-shadow: none;
}
.v-stepper__header{
    box-shadow: none;
}
.v-stepper--alt-labels .v-stepper__header .v-divider{
    margin: 22px -80px 0;
}
.v-divider{
    max-width: 90px;
}
.v-stepper__step{
    padding: 10px;
}
.v-stepper--alt-labels .v-stepper__step{
    flex-basis: 100px;
}
</style>
