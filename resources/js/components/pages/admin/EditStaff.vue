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
         *
         **/
        userData: ""
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
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.userData = res.data;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        // ユーザー情報を更新 <今は名前のみ
        updateUser: function() {
            axios
                .post("/api/users/update/", this.userData)
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
