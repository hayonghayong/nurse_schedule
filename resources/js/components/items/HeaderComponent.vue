<template>
  <!-- 仮ヘッダー -->
  <div>
    <v-app-bar color="blue" dark>
      <div>
        <span @click="back" style="cursor: pinter;">＜戻る</span>
      </div>
      <v-spacer></v-spacer>
      <v-toolbar-title id="header" class="white--text title">{{pageTitle}}</v-toolbar-title>

      <v-spacer></v-spacer>

      <!--<v-btn icon>
        <v-icon @click="logout" style="cursor: pointer;">mdi-account-cog</v-icon>
      </v-btn>-->

      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

      <!--<v-menu left bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item v-for="n in 5" :key="n" @click="() => {}">
                        <v-list-item-title>Option {{ n }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
      -->
    </v-app-bar>

    <!-- ▼仮ルーティングナビゲーション-->
    <!--  ※作業が進んできたら消します -->
    <v-navigation-drawer v-model="drawer" absolute temporary >
      <v-toolbar
      color="#2196F3"
      dark
      >
        <v-toolbar-title></v-toolbar-title>
        <v-spacer></v-spacer>

        <!--<v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>-->
      </v-toolbar>
      <v-list nav dense >
        <v-list-item-group v-model="group" active-class="primary--text text--accent-4">
          <router-link :to="{ name: 'UpdateUsersPatients' }">
            <v-list-item>
              <v-list-item-title>担当患者引継ぎ</v-list-item-title>
            </v-list-item>
          </router-link>
        <v-divider></v-divider>
          <router-link :to="{ name: 'LogoutCheck' }">
            <v-list-item>
              <v-list-item-title>ログアウト</v-list-item-title>
            </v-list-item>
          </router-link>
        </v-list-item-group>


        <v-list-item-group v-model="group" active-class="deep-purple--text text--accent-4">
          スタッフページ
          <router-link :to="{ name: 'SelectRole' }">
            <v-list-item>
              <v-list-item-title>【スタッフ】役割選択</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'SelectPatients' }">
            <v-list-item>
              <v-list-item-title>【スタッフ】患者選択</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'RegistTreatmentSchedule' }">
            <v-list-item>
              <v-list-item-title>【スタッフ】処置スケジュール登録</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'RegistSchedule' }">
            <v-list-item>
              <v-list-item-title>【スタッフ】処置スケジュール調整</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'StaffSchedule' }">
            <v-list-item>
              <v-list-item-title>【スタッフ】スケジュール一覧</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'PatientSchedule' }">
            <v-list-item>
              <v-list-item-title>【スタッフ】患者ごとのスケジュール</v-list-item-title>
            </v-list-item>
          </router-link>リーダーページ
          <router-link :to="{ name: 'SelectStaff' }">
            <v-list-item>
              <v-list-item-title>【リーダー】スタッフ選択</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'ScheduleList' }">
            <v-list-item>
              <v-list-item-title>【リーダー】スケジュール一覧</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'PatientsList' }">
            <v-list-item>
              <v-list-item-title>【リーダー】患者一覧</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'RegistPatient' }">
            <v-list-item>
              <v-list-item-title>【リーダー】患者の登録</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'EditPatient' }">
            <v-list-item>
              <v-list-item-title>【リーダー】患者の編集</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'EditTreatment' }">
            <v-list-item>
              <v-list-item-title>【リーダー】処置の編集</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'TreatmentList' }">
            <v-list-item>
              <v-list-item-title>【リーダー】処置一覧</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'RegistTreatment' }">
            <v-list-item>
              <v-list-item-title>【リーダー】処置の登録</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'UpdateUsersPatients' }">
            <v-list-item>
              <v-list-item-title>【リーダー】担当患者更新</v-list-item-title>
            </v-list-item>
          </router-link>管理者ページ
          <router-link :to="{ name: 'Setting' }">
            <v-list-item>
              <v-list-item-title>【管理者】設定</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'StaffList' }">
            <v-list-item>
              <v-list-item-title>【管理者】スタッフ一覧</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'RegistStaff' }">
            <v-list-item>
              <v-list-item-title>【管理者】スタッフ登録</v-list-item-title>
            </v-list-item>
          </router-link>
          <router-link :to="{ name: 'EditStaff' }">
            <v-list-item>
              <v-list-item-title>【管理者】スタッフ編集</v-list-item-title>
            </v-list-item>
          </router-link>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
    <!-- ▲仮ルーティングナビゲーション -->
  </div>
</template>
<script>
import { mapActions, mapGetters, mapState } from "vuex"; //vuexで使用

export default {
  components: {},
  data: () => ({
    // 仮ドロワートグル
    drawer: false,
    group: null
  }),
  watch: {
    // 仮ドロワートグル
    group() {
      this.drawer = false;
    }
  },
  created() {
    //ログインしているユーザーの情報を取得：参照したactionsを発火
    this.getLoginUserData();
  },
  computed: {
    //ログインしているユーザーの情報を取得：stateを参照
    ...mapState("auth", ["loginUser"]),
    ...mapGetters({
      pageTitle: "common/pageTitle"
    })
  },
  methods: {
    //ログインしているユーザーの情報を取得：Actionsを参照
    ...mapActions("auth", ["getLoginUserData"]),
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
.link {
  color: white;
  text-decoration: none;
}
.link:hover {
  opacity: 0.6;
}
.title {
  font-weight: bold;
}
 a{
  text-decoration:none;
}

</style>
