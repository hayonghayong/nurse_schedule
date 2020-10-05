<template>
  <v-container>
    <v-stepper value="2" alt-labels>
      <v-stepper-header>
        <v-stepper-step step="1" complete>患者選択</v-stepper-step>

        <v-divider></v-divider>

        <v-stepper-step step="2">処置選択</v-stepper-step>

        <v-divider></v-divider>

        <v-stepper-step step="3">スケジュール調整</v-stepper-step>
      </v-stepper-header>
    </v-stepper>
    <div class="patient_wrap">
      <li v-if="usersPatients[setTreatmentPage]">
        {{ usersPatients[setTreatmentPage].room }}号室
        {{ usersPatients[setTreatmentPage].name }}さん
        <span
          v-if="usersPatients[setTreatmentPage].sex == 1"
        >男性</span>
        <span v-else-if="usersPatients[setTreatmentPage].sex == 2">女性</span>
        <BirthdayMomentJS :time="usersPatients[setTreatmentPage].birthday" />
      </li>
      {{ setTreatmentPage + 1 }}/{{ usersPatientsLength + 1 }}人
    </div>
    <p class="center">今日行う処置を選択してください</p>

    <div class="select_wrap">
      <div class="cp_ipselect cp_sl02">
        <select v-model="selectedTreatment">
          <option disabled value>選択してください</option>
          <option
            v-for="treatment in treatments"
            :value="treatment.id"
            :key="treatment.id"
          >{{ treatment.name }}</option>
        </select>
      </div>
      <div class="button_wrap my-5">
        <v-btn
          rounded
          depressed
          dark
          width="50"
          class="button"
          color="#2196F3"
          @click="pushSettreatmentData()"
        >追加</v-btn>
      </div>
    </div>

    <div>
      <p>登録済みの処置（{{ setTreatmentsData.length }}）</p>
    </div>
    <table>
      <!-- テーブルヘッダー -->
      <thead>
        <tr>
          <th class="comment"></th>
          <th class="time_input"></th>
          <th class="button"></th>
        </tr>
      </thead>
      <tbody v-if="setTreatmentsData.length > 0">
        <tr v-for="(setTreatment, index) in setTreatmentsData" :key="index">
          <td class="treatment_name center">{{ setTreatment.treatment_name }}</td>
          <td class="time_input">
            <vue-timepicker
              :minute-interval="10"
              v-model="treatmentTimes[index]"
              id="start_time"
              name="startTime"
              placeholder="開始時間"
              hour-label="時"
              minute-label="分"
              input-class="form-control"
              @input="updateSetTreatmentsData(index)"
            ></vue-timepicker>
          </td>
          <td class="button">
            <v-btn
              color="blue lighten-1"
              depressed
              fab
              small
              icon
              @click="deleteTreatmentData(index)"
            >
              <v-icon>mdi-trash-can</v-icon>
            </v-btn>
          </td>
        </tr>
      </tbody>
    </table>
    <v-btn
      class="mx-auto my-4 px-12 py-4 submit_btn"
      rounded
      dark
      color="#62ABF8"
      type="submit"
      @click="setTreatmentsSchedule()"
    >保存</v-btn>
  </v-container>
</template>
<script>
// コンポーネントのインポート
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";
import BirthdayMomentJS from "../../items/BirthdayMomentJs";
// Vue
export default {
  components: {
    "vue-timepicker": VueTimepicker,
    BirthdayMomentJS
  },
  data: () => ({
    /**
     *
     * @param {Array} usersPatients・・・・・・・ログインユーザーの担当患者データ
     * @param {Int} usersPatientsLength・・・・・・・ログインユーザーの担当患者数
     * @param {Array} treatments・・・ログインユーザーが所属する病棟に登録済みの処置データ
     * @param {Array} setTreatmentsData・・・DB側へ送るスケジュールデータ
     * @param {Object} setTreatmentPage・・・担当患者のうち何人目のデータのなのかを管理（index）
     * @param {Array} selectedTreatment・・・追加した処置スケジュールのデータ
     * @param {Array} schedule・・・DB側へ送るスケジュールデータ形式？　使ってないです・・・
     * @param {String} today・・・今日の日付
     *
     **/
    usersPatients: [],
    usersPatientsLength: 0,
    treatments: [],
    setTreatmentsData: [],
    setTreatmentPage: 0,
    selectedTreatment: [],
    treatmentTimes: [],
    schedule: {
      treatment_id: "",
      patient_id: "",
      start_date: ""
    },
    today: ""
  }),
  computed: {
    // DB保存用に日付を整形
    setToday: function() {
      var today = new Date();
      var year = today.getFullYear();
      var month = today.getMonth() + 1;
      var week = today.getDay();
      var day = today.getDate();
      if (month < 10) {
        month = "0" + month;
      }
      if (day < 10) {
        day = "0" + day;
      }
      return (this.today = year + "-" + month + "-" + day);
    }
  },
  methods: {
    fetchPatients: function() {
      axios
        .get("/api/users_patients/get/all")
        .then(res => {
          // console.log("status:", res.status);
          // console.log("body:", res.data);
          this.usersPatients = res.data;
          this.usersPatientsLength = res.data.length;
        })
        .catch(err => {
          console.log("err:", err);
        });
    },
    fetchTreatment: function() {
      axios
        .get("/api/treatments/get/all")
        .then(res => {
          // console.log("status:", res.status);
          console.log("body:", res.data);
          this.treatments = res.data;
        })
        .catch(err => {
          console.log("err:", err);
        });
    },
    // 処置を追加して入力欄を表示
    pushSettreatmentData: function() {
      const selectedTreatmentId = this.selectedTreatment;
      const selectedTreatmentName = this.treatments.filter(function(
        item,
        index
      ) {
        if (item.id == selectedTreatmentId) return true;
      });
      this.setTreatmentsData.push({
        treatment_id: selectedTreatmentId,
        treatment_name: selectedTreatmentName[0].name,
        patient_id: this.usersPatients[this.setTreatmentPage].id,
        start_date: ""
      });
    },
    // 登録したスケジュールの削除
    deleteTreatmentData: function(index) {
      this.setTreatmentsData.splice(index, 1);
    },
    // 登録したスケジュールの開始時間を更新
    updateSetTreatmentsData: function(index) {
      const setTime = this.treatmentTimes[index];
      if (setTime.HH && setTime.mm) {
        const startTime =
          this.setToday + " " + setTime.HH + ":" + setTime.mm + ":00";
        this.setTreatmentsData[index].start_date = startTime;
      } else {
        const startTime = this.setToday;
        this.setTreatmentsData[index].start_date = startTime;
      }
    },
    // 登録した処置をDBに保存
    setTreatmentsSchedule: function() {
      console.log(this.setTreatmentsData);
      axios
        .post(
          `/api/tasks/post/${this.$route.params.schedule_id}`,
          this.setTreatmentsData
        )
        .then(res => {
          console.log("status:", res.status);
          console.log("body:", res.data);
          this.setTreatmentPage++;
          this.setTreatmentsData = [];
          //全員分登録が完了したら...
          if (this.setTreatmentPage == this.usersPatientsLength) {
            const transitionDestinationObj = {
              name: "RegistSchedule"
            };
            this.$router.push(transitionDestinationObj);
          }
        })
        .catch(err => {
          console.log("err:", err.response.data);
        });
    }
  },
  created() {
    this.fetchPatients();
    this.fetchTreatment();
  }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
.patient_wrap {
  margin: 1em;
}
.patient_wrap li {
  color: #fd9549;
  font-weight: bold;
  list-style: none;
  text-align: center;
}

.select_wrap,
.time_input {
  display: flex;
}
.center {
  text-align: center;
  margin: 0;
}
.comment {
  width: 80px;
}
.time_input,
.comment {
  width: 100%;
}
.treatment_name {
  background-color: #e6f4ff;
  color: #62abf8;
}

.cp_ipselect {
  overflow: hidden;
  width: 70%;
  margin: 1em;
}
.cp_ipselect select {
  width: 100%;
  padding-right: 1em;
  cursor: pointer;
  text-indent: 0.01px;
  text-overflow: ellipsis;
  border: none;
  outline: none;
  background: transparent;
  background-image: none;
  box-shadow: none;
  -webkit-appearance: none;
  appearance: none;
}
.cp_ipselect select::-ms-expand {
  display: none;
}
.cp_ipselect.cp_sl02 {
  position: relative;
  border: 1px solid #bbbbbb;
  border-radius: 2px;
  background: #ffffff;
}
.cp_ipselect.cp_sl02::before {
  position: absolute;
  top: 0.8em;
  right: 0.9em;
  width: 0;
  height: 0;
  padding: 0;
  content: "";
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 6px solid #666666;
  pointer-events: none;
}
.cp_ipselect.cp_sl02:after {
  position: absolute;
  top: 0;
  right: 2.5em;
  bottom: 0;
  width: 1px;
  content: "";
  border-left: 1px solid #bbbbbb;
}
.cp_ipselect.cp_sl02 select {
  padding: 8px 38px 8px 8px;
  color: #666666;
}
.button {
  width: 10px;
}

.v-stepper {
  box-shadow: none;
}
.v-stepper__header {
  box-shadow: none;
}
.v-stepper--alt-labels .v-stepper__header .v-divider {
  margin: 22px -80px 0;
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
</style>
