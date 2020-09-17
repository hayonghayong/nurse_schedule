<template>
    <!-- 仮オブジェクト -->
        <div>
            <v-app-bar
            flat color="white" fixed light>
            <!--ここにログアウト付けたかった -->
                <router-link
                    :to="{ name: 'SelectStaff' }"
                    style="text-decoration: none;"
                >
                ＜ 戻る
                </router-link>

            </v-app-bar>

            <div class="message">
                <h1>役割選択</h1>
                <p>{{ loginUser.name }}さん</p>
                <p>今日の役割を選択してください</p>
            </div>
            <!-- ▼リーダーボタン -->
            <div class="button_wrap my-3">
                <v-btn depressed dark x-large height="110" width="260" class="button" color="#2196F3" @click="postTeam()">リーダー</v-btn>
            </div>
            <!-- ▲リーダーボタンここまで -->

            <!-- ▼スタッフボタン -->
            <div class="button_wrap my-6">
                <router-link
                    :to="{ name: 'SelectPatients' }"
                    style="text-decoration: none;"
                >
                    <v-btn depressed dark x-large height="110" width="260" class="button" color="#ff8000">スタッフ</v-btn>
                </router-link>
            </div>
            <!-- ▲スタッフボタンここまで -->
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
        // チーム生成
        postTeam: function() {
            axios
                .post("/api/teams/post")
                .then(res => {
                    console.log(res.data.id)
                    // ページ遷移
                    this.$router.push({
                    name: "SelectStaff",
                    params:{
                        team_id:res.data.id
                    }
                });
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        }
        
    }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
h1{
    font-size:22px;
    margin-bottom:1.4rem;
}

.message{
    text-align:center;
    margin-bottom:40px;
    margin-top:100px;
}

.v-application p{
    margin-bottom: 6px;
}

.button_wrap{
    width:260px;
    margin:50px auto;
}

button{
    font-weight:bold;
    color:#fff;
}
</style>
