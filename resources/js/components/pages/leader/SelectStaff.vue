<template>
  <v-item-group multiple v-model="saveSelecyedStaff">
    <v-container>
      <v-dialog v-model="errorDialog" max-width="350px" class="error_dialog">
        <v-card>
          <v-card-title class="headline lighten-2 text--secondary" color="#62ABF8" primary-title>エラー</v-card-title>
          <v-card-text>
            <p class="mb-0">
              担当患者が選択されていません。
              担当患者を選択の上、決定ボタンを押してください。
            </p>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="#62ABF8" text @click="errorDialog = false">閉じる</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-list-item-title class="center"
        >本日のチームスタッフを全て選択してください</v-list-item-title
      >
      <v-row>
        <v-col v-for="staff in staffs" :key="staff.id" cols="6">
          <v-item v-slot:default="{ active, toggle }" :value="staff.id">
            <v-hover v-slot:default="{ hover }">
              <v-card
                :color="active ? '#c6def7' : ''"
                class="d-flex align-center"
                :class="{ 'on-hover': hover }"
                outlined
                @click="toggle"
              >
                <v-card-text>
                  <div class="name">{{ staff.name }}</div>
                </v-card-text>
                <v-scroll-y-transition>
                  <div v-if="active" class="display-3 flex-grow-1"></div>
                </v-scroll-y-transition>
              </v-card>
            </v-hover>
          </v-item>
        </v-col>
      </v-row>
      <v-footer fixed class="font-weight-medium footer">
        <div>
          <p class="mb-1 caption">現在、{{ saveSelecyedStaff.length }}人選択中です。</p>
        </div>

        <v-btn
          class="mx-auto my-2 px-12 py-4 submit_btn"
          color="#62ABF8"
          rounded
          dark
          depressed
          width="220"
          type="submit"
          @click="checkSelectedStaffs()"
          >決定</v-btn
        >
      </v-footer>
    </v-container>
  </v-item-group>
</template>
<script>
// Vue
export default {
  components: {},
  data: () => ({
    staffs: [],
    saveSelecyedStaff: [],
    errorDialog: false
  }),
  methods: {
    // 【API】全スタッフ取得
    fetchStaff: function () {
      axios
        .get("/api/users/get/all")
        .then((res) => {
          this.staffs = res.data;
        })
        .catch((err) => {
          console.log("err:", err);
        });
    },
    // 【API】チームスタッフ取得
    fetchTeamStaff: function () {
      axios
        .get("/api/team_users/get/all/" + this.$route.params.team_id)
        .then((res) => {
          console.log(res.data);
          res.data.forEach((el) => {
            this.saveSelecyedStaff.push(el.id);
          });
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
    // 【API】スタッフ登録
    pushSelectedData: function () {
      axios
        .post(`/api/team_users/add/${this.$route.params.team_id}`, {
          id: this.saveSelecyedStaff,
        })
        .then((res) => {
          this.staffs = res.data;
          // ページ遷移
          this.$router.push({
            name: "ScheduleList",
            params: {
              team_id: this.$route.params.team_id,
            },
          });
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
    checkSelectedStaffs: function() {
      const selectedStaffslength = this.saveSelecyedStaff.length;
      if (selectedStaffslength == 0) {
        this.errorDialog = true;
      } else {
        this.pushSelectedData();
      }
    }
  },
  created() {
    this.fetchStaff();
    this.fetchTeamStaff();
  },
};
</script>

<style scoped>
/* スコープ付きのスタイル */
.footer {
  background: rgba(255, 0 0, 0.5);
  display: flex;
  flex-direction: column;

}
.name {
  font-size: 17px;
}
.center {
  text-align: center;
  padding: 1.2rem 0;
}
.theme--light.v-sheet--outlined {
  border: solid 2px rgb(98, 171, 248, 0.9);
}

.v-card:not(.on-hover) {
  opacity: 0.8;
  border: thin solid rgb(0, 0, 0, 0.12);
}
</style>
