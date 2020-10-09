<template>
  <v-item-group multiple v-model="saveSelectedPatient">
    <v-container>
      <v-stepper value="1" alt-labels>
        <v-stepper-header>
          <v-stepper-step step="1" color="#5e9ce6">患者選択</v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step step="2">処置選択</v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step step="3">スケジュール調整</v-stepper-step>
        </v-stepper-header>
      </v-stepper>

      <v-list-item-title class="center pt-0"
        >本日の担当の患者さんを全て選択してください</v-list-item-title
      >
      <v-row>
        <v-col v-for="patient in patients" :key="patient.id" cols="6">
          <v-item v-slot:default="{ active, toggle }" :value="patient.id">
            <v-hover v-slot:default="{ hover }">
              <v-card
                :color="active ? '#62ABF8' : ''"
                class="d-flex align-center"
                :class="{ 'on-hover': hover }"
                outlined
                height="230"
                @click="toggle"
              >
                <v-card-text>
                  <p class="ma-0">{{ patient.room }}号室</p>
                  <p class="ma-0">
                    {{ patient.name }}さん
                    <span v-if="patient.sex == 1" class="ml-2">男性</span>
                    <span v-else-if="patient.sex == 2" class="ml-2">女性</span>
                    <span v-else class="ml-2">性別未記入</span>
                  </p>
                  <BirthDayMomentJs :time="patient.birthday"></BirthDayMomentJs>
                  <p class="ma-0">
                    <span>入院日：</span>{{ patient.hospitalization_date }}
                  </p>
                  <p class="ma-0">
                    <span>手術日：</span>{{ patient.surgery_date }}
                  </p>
                  <p class="ma-0">特記事項</p>
                  <p class="ma-0">{{ patient.memo }}</p>
                </v-card-text>

                <v-scroll-y-transition>
                  <div v-if="active" class="display-3 flex-grow-1"></div>
                </v-scroll-y-transition>
              </v-card>
            </v-hover>
          </v-item>
        </v-col>
      </v-row>
      <!-- フッター -->
      <v-footer fixed class="font-weight-medium footer">
        <v-btn
          class="mx-auto my-2 px-12 py-4 submit_btn"
          color="#62ABF8"
          rounded
          dark
          depressed
          width="220"
          type="submit"
          @click="pushSelectedData()"
          >決定</v-btn
        >
      </v-footer>
    </v-container>
  </v-item-group>
</template>
<script>
// コンポーネントのインポート
import BirthDayMomentJs from "../../items/BirthdayMomentJs";
// Vue
export default {
  components: {
    BirthDayMomentJs,
  },
  data: () => ({
    patients: [],
    saveSelectedPatient: [],
    usersPatients: [],
    vertical: true,
    e1: 1,
  }),
  methods: {
    // 【API】患者一覧取得
    fetchPatients: function () {
      axios
        .get("/api/patients/get/all")
        .then((res) => {
          this.patients = res.data;
        })
        .catch((err) => {
          console.log("err:", err);
        });
    },
    // 【API】患者登録
    pushSelectedData: function () {
      console.log(this.saveSelectedPatient);
      axios
        .post(`/api/users_patients/add/${this.$route.params.schedule_id}`, {
          id: this.saveSelectedPatient,
        })
        .then((res) => {
          this.usersPatients = res.data;
          const transitionDestinationObj = {
            name: "RegistTreatmentSchedule",
            params: {
              schedule_id: this.$route.params.schedule_id,
            },
          };
          this.$router.push(transitionDestinationObj);
        })
        .catch((err) => {
          console.log("err:", err.response.data);
        });
    },
    // 【API】担当患者取得
    fetchUsersPatients: function () {
      axios
        .get(`/api/users_patients/get/all/${this.$route.params.schedule_id}`)
        .then((res) => {
          console.log("body:", res.data);
          res.data.forEach((el) => {
            this.saveSelectedPatient.push(el.id);
          });
        })
        .catch((err) => {
          console.log("err:", err);
        });
    },
  },
  computed: {},

  created() {
    this.fetchPatients();
    this.fetchUsersPatients();
  },
};
</script>

<style scoped>
/* スコープ付きのスタイル */
.footer {
  background: rgba(255, 0 0, 0.5);
}
.name {
  font-size: 17px;
}
.center {
  text-align: center;
  padding: 1.2rem 0;
}
/* レイアウトが崩れるので一旦コメントアウトしてます */
.theme--light.v-sheet--outlined {
  /* border: solid 2px rgb(98, 171, 248, 0.9); */
}

.v-card:not(.on-hover) {
  opacity: 0.8;
  border: thin solid rgb(0, 0, 0, 0.12);
}
.v-stepper {
  box-shadow: none;
}
.v-stepper__header {
  box-shadow: none;
}
.v-stepper--alt-labels .v-stepper__header .v-divider {
  margin: 22px -25px 0;
}
.v-divider {
  max-width: 90px;
}
.v-stepper__step {
  padding: 10px;
}
.v-stepper--alt-labels .v-stepper__step {
  flex-basis: 100px;
}
#app
  > div
  > main
  > div
  > div
  > div.v-stepper.v-stepper--vertical.v-stepper--alt-labels.theme--light
  > div
  > div.v-stepper__step.v-stepper__step--active
  > span {
  margin-right: 0px;
}
</style>

