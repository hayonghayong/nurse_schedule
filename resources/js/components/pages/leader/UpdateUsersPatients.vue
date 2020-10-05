<template>
  <div>
    <p>引継ぎ元のスタッフ(チームメンバー)</p>
    <div class="cp_ipselect cp_sl02">
      <select v-model="changePatientData.change_from_id" @change="setPatient()">
        <option disabled value>選択してください</option>
        <option
          v-for="team_user in teamUsers"
          :value="team_user.id"
          :key="team_user.id"
        >{{ team_user.name }}</option>
      </select>
    </div>

    <p>引継ぐ患者(選択されたスタッフの担当患者)</p>
    <!-- 引継ぎ元スタッフが選択されると表示 -->
    <div class="cp_ipselect cp_sl02">
      <select v-model="changePatientData.patient_id">
        <option disabled value>選択してください</option>
        <option v-for="patient in patients" :value="patient.id" :key="patient.id">{{ patient.name }}</option>
      </select>
    </div>
    <p>引継ぎ先のスタッフ(前スタッフ)</p>
    <div class="cp_ipselect cp_sl02">
      <select v-model="changePatientData.change_to_id">
        <option disabled value>選択してください</option>
        <option v-for="user in users" :value="user.id" :key="user.id">{{ user.name }}</option>
      </select>
    </div>
    <v-btn rounded dark color="#62ABF8" class="mx-auto px-6" @click="updatePatientUser()">引継ぐ</v-btn>
    <!-- ここまで -->
  </div>
</template>

<script>
export default {
  components: {},
  data: () => ({
    users: [],
    teamUsers: [],
    patients: [],
    treatments: [],
    changePatientData: {} //postデータ
  }),
  methods: {
    // 【API】チームメンバーを取得
    fetchUsers: function() {
      axios
        .get(`/api/users/get/all`)
        .then(res => {
          this.users = res.data;
        })
        .catch(err => {
          console.log("err:", err);
        });
    },
    // 【API】チームメンバーを取得
    fetchTeamUsers: function() {
      axios
        .get(`/api/team_users/get/all/${this.$route.params.team_id}`)
        .then(res => {
          this.teamUsers = res.data;
        })
        .catch(err => {
          console.log("err:", err);
        });
    },
    // 【API】担当患者を取得
    setPatient: function() {
      const user_id = this.changePatientData.change_from_id;
      console.log(this.changePatientData.change_from_id);
      axios
        .get(`/api/users_patients/get/${user_id}`)
        .then(res => {
          this.patients = res.data;
        })
        .catch(err => {
          console.log("err:", err.response.data);
        });
    },
    // 【API】担当患者の変更
    updatePatientUser: function() {
        console.log('担当患者の変更')
      axios
        .post("/api/users_patients/update", this.changePatientData)
        .then(res => {
          console.log("body:", res.data);
        })
        .catch(err => {
          console.log("err:", err.response.data);
        });
    },
    // // 【API】タスクのスケジュール変更
    // updateSchedule: function() {
    //     console.log('スケジュール変更')
    // },
    // // 更新処理
    // takeover: function() {
    //   this.updatePatientUser();
    //   this.updateSchedule();
    // }
  },
  created() {
    this.fetchTeamUsers();
    this.fetchUsers();
  }
};
</script>

<style scoped>
/* スコープ付きのスタイル */

/* セレクトのスタイル */
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
/* セレクトのスタイル ここまで */
</style>
