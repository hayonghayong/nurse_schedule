<template>
    <!-- 仮オブジェクト -->
    <div>
        <h1>【スタッフ】役割選択</h1>
        <p>{{ loginUser.name }}さん</p>
        <p>今日の役割を選択してください</p>
        <!-- ▼リーダーボタン -->
        <div class="my-2">
            <router-link
                :to="{ name: 'SelectStaff' }"
                style="text-decoration: none;"
            >
                <v-btn color="primary" @click="postTeam()">リーダー</v-btn>
            </router-link>
        </div>
        <!-- ▲リーダーボタンここまで -->

        <!-- ▼スタッフボタン -->
        <div class="my-2">
            <router-link
                :to="{ name: 'SelectPatients' }"
                style="text-decoration: none;"
            >
                <v-btn color="warning">スタッフ</v-btn>
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
                    console.log("status:", res.status);
                    console.log("body:", res.data);
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
</style>
