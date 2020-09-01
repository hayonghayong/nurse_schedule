<template>
    <!-- 仮オブジェクト -->
    <div>
        <h1>【スタッフ】役割選択</h1>
        <p>ログイン中のユーザー</p>
        {{ loginUser }}
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
        ...mapActions("auth",["getLoginUserData"]),
    }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
