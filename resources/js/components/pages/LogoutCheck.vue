<template>
  <!-- 仮オブジェクト -->
  <div class="text-center">
    <div class="sentense">
    <p>本当にログアウトしますか？</p>
    </div>
    <div class="message">
      <v-icon class="alert" x-large> mdi-alert-octagram</v-icon>
      <p>本日の予定データが消えてしまうため</p>
      <p>退勤する時までは絶対に</p>
      <p>ログアウトしないでください</p>
    </div>
  
    <v-btn
      class="mx-auto my-2 px-12 py-4 submit_btn"
      color="rgb(98, 171, 248)"
      rounded
      dark
      depressed
      width="260"
      height="50"
      type="submit"
      @click="back" style="cursor: pinter;"
    >勤務中なので戻ります</v-btn>

    <v-btn
      class="mx-auto mt-4 my-2 px-12 py-4 submit_btn"
      outlined
      rounded
      depressed
      color="#999"
      width="260"
      height="50"
      type="submit"
      @click="logout" style="cursor: pointer;"
    >退勤するのでログアウトします</v-btn>

  </div>
  <!-- ここまで -->
</template>

<script>
// コンポーネントのインポート
import { mapActions, mapGetters, mapState } from "vuex"; //vuexで使用

// Vue
export default {
  components: {},
  data: () => ({}),
  created() {
    //ログインしているユーザーの情報を取得：参照したactionsを発火
    this.getLoginUserData();
  },
  computed: {
    //ログインしているユーザーの情報を取得：stateを参照
    ...mapState("auth", ["loginUser"])
  },
  methods: {
    //ログインしているユーザーの情報を取得：Actionsを参照
    ...mapActions("auth", ["getLoginUserData"]),

    // スケジュール生成 < スタッフ
    postSchedule: function() {
      axios
        .post("/api/schedules/post")
        .then(res => {
          console.log(res.data.id);
          // ページ遷移
          this.$router.push({
            name: "SelectPatients",
            params: {
              schedule_id: res.data.id
            }
          });
        })
        .catch(err => {
          console.log(err.response.data);
        });
    },
    // チーム生成 < リーダー
    postTeam: function() {
      axios
        .post("/api/teams/post")
        .then(res => {
          console.log(res.data.id);
          // ページ遷移
          this.$router.push({
            name: "SelectStaff",
            params: {
              team_id: res.data.id
            }
          });
        })
        .catch(err => {
          console.log(err.response.data);
        });
    },
    //ログアウト
    logout: function() {
      axios
        .post("/logout")
        .then(res => {
          location.href = "/";
        })
        .catch(err => console.log(err));
    },
    back() {
      this.$router.back();
    }
    
  }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
h1 {
  font-size: 22px;
  margin-bottom: 1.4rem;
}
.sentense{
  margin-top: 110px;
  font-weight:bold;
  color:#666;
}

.message {
  margin:15px 28px 40px;
  margin-bottom: 40px;
  border:3px solid #F15A55;
  border-radius:30px;   
  color:#666;
  padding:20px 10px;
  font-weight:bold;

}
.alert{
  color:#F15A55;
  margin-bottom:15px;
}

.v-application p {
  margin-bottom: 6px;
}

.button_wrap {
  width: 260px;
  margin: 50px auto;
}

button {
  font-weight: bold;
  color: #fff;
}
</style>
