<template>
    <v-container fluid class="pt-4">
        <v-card-text class="text-center">
            <h1 class="headline">看護師を編集</h1>
            <v-form ref="form">
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            label="病棟"
                            v-model="userData.ward_id"
                            color="#62ABF8"
                            >{{ userData.ward_id }}</v-text-field
                        >
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="名前"
                            v-model="userData.name"
                            color="#62ABF8"
                            >{{ userData.name }}</v-text-field
                        >
                    </v-col>
                    <v-col cols="12">
                        <v-switch
                            v-model="switchToggle"
                            :label="`${switchToggle.toString()}`"
                        ></v-switch>
                    </v-col>

                    <v-btn
                        class="mx-auto my-2 px-12 py-4 submit_btn"
                        color="#62ABF8"
                        rounded
                        dark
                        @click="updateUser()"
                        >登録</v-btn
                    >
                </v-row>
            </v-form>
        </v-card-text>
    </v-container>
</template>

<script>
// コンポーネントのインポート

// Vue
export default {
    components: {},
    data: () => ({
        /**
         *
         * @param {Object} userData・・・選択したユーザーのデータを管理
         * @param {Boolean} switchToggle・・・退職フラグのオンオフを管理
         *
         **/
        userData: "",
        switchToggle: ""
    }),
    created() {
        this.getSelectUser(this.$route.params.user_id);
    },
    methods: {
        // 選択されたユーザーを取得
        getSelectUser: function(user_id) {
            axios
                .get("/api/users/get/" + user_id)
                .then(res => {
                    // 変数に格納
                    this.userData = res.data;
                    // 退職フラグをスイッチに反映
                    if (!res.data.deleted_at) this.switchToggle = false;
                    else this.switchToggle = true;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        // ユーザー情報を更新 <今は名前のみ
        updateUser: function() {
            // 退職フラグがtrueであれば削除する関数呼び出し
            if (this.switchToggle === true) this.deleteUser();
            else this.restoreUser();

            axios
                .post("/api/users/update/", this.userData)
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        // ユーザーを退職処理
        deleteUser: function() {
            axios
                .post("/api/users/delete/", this.userData)
                .then(res => {})
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        // 退職処理を解除
        // ユーザーを退職処理
        restoreUser: function() {
            axios
                .post("/api/users/restore/", this.userData)
                .then(res => {})
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
