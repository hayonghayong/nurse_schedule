<template>
    <v-container>
        <v-card-text class="text-center">
            <h1 class="headline">【リーダー】処置登録</h1>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-row>
                    <v-col cols="12" class="py-0">
                        <v-text-field
                            label="処置名"
                            v-model="treatment.name"
                            color="#62ABF8"
                            :rules="[validationRules.required]"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" class="py-0">
                        <v-select
                            v-model="treatment.time_required"
                            :items="timeRequired"
                            label="処置時間"
                            color="#62ABF8"
                            clearable
                            :rules="[validationRules.required]"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" class="py-0">
                        <header class="labelFlag text-left">優先</header>
                        <v-switch
                            v-model="treatment.required_flg"
                            :persistent-hint="true"
                            :true-value="0"
                            :false-value="1"
                            hint="時間不可の場合チェックをつけてください"
                            inset
                            color="#62ABF8"
                            class="mt-2"
                        ></v-switch>
                    </v-col>
                    <v-btn
                        class="mx-auto my-4 px-12 py-4 submit_btn"
                        rounded
                        dark
                        color="#62ABF8"
                        type="submit"
                        @click="addTreatment"
                    >
                        変更
                    </v-btn>
                </v-row>
            </v-form>
        </v-card-text>

        <v-dialog v-model="isDialogOpen.successDialog" width="400">
            <v-card>
                <v-card-title
                    class="headline lighten-2 text--secondary"
                    color="#62ABF8"
                    primary-title
                    >完了</v-card-title
                >
                <v-card-text
                    >下記内容で処置登録が完了しました！
                    <p class="successMessage">処置名：{{ treatment.name }}</p>
                    <p class="successMessage">
                        患者名：{{ treatment.time_required }}分
                    </p>
                    <p class="successMessage">
                        必須：{{ selectedrequiredFlg }}
                    </p>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="#62ABF8"
                        text
                        @click="closeDialog('successDialog')"
                        >閉じる</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="isDialogOpen.errorDialog" width="400">
            <v-card>
                <v-card-title
                    class="headline lighten-2 text--secondary"
                    primary-title
                    >エラー</v-card-title
                >
                <v-card-text>
                    <p
                        v-for="(message, index) in axiosErrorMessages"
                        :key="index"
                        class="errorMessage"
                    >
                        ・{{ axiosErrorMessages[index] }}
                    </p>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="#62ABF8"
                        text
                        @click="closeDialog('errorDialog')"
                        >閉じる</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
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
         * @param {Object} validationRules・・・・・・・バリデーションルールの設定
         * @param {Boolean} valid・・・・・・・バリデーションチェック用の真偽値
         * @param {Object} readOnly・・・各フォームが読み取り専用かどうかの状態を管理
         * @param {Object} isDialogOpen・・・Dialogの表示非表示を管理。
         * @param {Object} treatment・・・患者のプロフィールデータを管理
         * @param {Array} axiosErrorMessages・・・DB側のバリデーションエラーを受け取る
         *
         **/
        validationRules: {
            required: value => !!value || "入力必須です。",
            nameCounter: value =>
                (value || "").length <= 20 ||
                "氏名は20字以下で入力してください。",
            memoCounter: value =>
                (value || "").length <= 200 ||
                "特記事項は200字以下で入力してください。"
        },
        valid: true,
        isDialogOpen: {
            successDialog: false,
            errorDialog: false
        },
        treatment: {
            name: "",
            time_required: "",
            required_flg: ""
        },
        timeRequired: [15, 30, 45, 60, 90, 120, 150, 180, 210, 240, 270],
        selectedrequiredFlg: "",
        axiosErrorMessages: []
    }),
    methods: {
        //　サーバー側からのエラーを定義
        setAxiosErrorData(err) {
            const axiosErrorRes = err.response.data;
            let axiosErrorMessageArray = [];

            if (axiosErrorRes.errors) {
                const axiosvalidationErrorRes = axiosErrorRes.errors;

                axiosErrorMessageArray = Object.keys(
                    axiosvalidationErrorRes
                ).map(dataField => {
                    return axiosvalidationErrorRes[dataField][0];
                });
            } else {
                axiosErrorMessageArray.push(
                    "回答が送信されませんでした。再度送信してください。"
                );
            }
            this.axiosErrorMessages = axiosErrorMessageArray;
            console.log(this.axiosErrorMessages);
            this.isDialogOpen.errorDialog = true;
        },
        // formのデータを定義
        setTreatmentData() {
            let formData = new FormData();

            Object.keys(this.treatment).forEach(key => {
                if (this.treatment[key]) {
                    console.log(key, this.treatment[key]);
                    formData.append(key, this.treatment[key]);
                }
            });
            formData.append("required_flg", this.treatment.required_flg);
            return formData;
        },
        //　サーバー側からのエラーを定義
        addTreatment: function() {
            //入力値のエラーを確認
            if (this.$refs.form.validate()) {
                const formData = this.setTreatmentData();

                var config = {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                };
                axios
                    .post("/api/treatments/post", formData, config)
                    .then(res => {
                        console.log("status:", res.status);
                        console.log("body:", res.data);
                        const saveTreatment = res.data;
                        this.treatment = saveTreatment;
                        if (saveTreatment.required_flg == 0) {
                            this.selectedrequiredFlg = "必須";
                        } else {
                            this.selectedrequiredFlg = "必須ではない";
                        }
                        this.isDialogOpen.successDialog = true;
                    })
                    .catch(err => {
                        console.log("err:", err);
                        this.setAxiosErrorData(err);
                    });
            } else {
                console.log("エラーがあるよ！");
            }
        },
        //　ダイアログを閉じる
        closeDialog(dialogName) {
            this.isDialogOpen[dialogName] = false;
            if (dialogName == "successDialog") {
                const transitionDestinationObj = {
                    name: "TreatmentList"
                };
                this.treatment = "";
                this.$refs.form.resetValidation();
                this.$router.push(transitionDestinationObj);
            }
        }
    },
    created() {}
};
</script>

<style scoped>
.labelFlag {
    font-size: 16px;
}
.errorMessage {
    margin-bottom: 0;
}
.successMessage {
    margin-bottom: 0;
}
</style>
