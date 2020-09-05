<template>
    <v-container fluid class="pt-4">
        <v-dialog v-model="isDialogOpen.successDialog" width="400">
            <v-card>
                <v-card-title
                    class="headline lighten-2 text--secondary"
                    color="#62ABF8"
                    primary-title
                    >完了</v-card-title
                >
                <v-card-text
                    >下記内容で患者登録が完了しました！
                    <p class="successMessage">部屋番号：{{ patient.room }}</p>
                    <p class="successMessage">患者名：{{ patient.name }}</p>
                    <p class="successMessage">性別：{{ selectedGender }}</p>
                    <p class="successMessage">
                        生年月日：{{ patient.birthday }}
                    </p>
                    <p class="successMessage">
                        入院日：{{ patient.hospitalization_date }}
                    </p>
                    <p class="errorMessage">
                        手術日：{{ patient.surgery_date }}
                    </p>
                    <p class="errorMessage">特記事項：{{ patient.memo }}</p>
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

        <v-card-text class="text-center">
            <h1 class="headline">患者登録</h1>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            label="部屋番号"
                            v-model="patient.room"
                            placeholder="201"
                            suffix="号室"
                            color="#62ABF8"
                            clearable
                            :readonly="readOnly.room"
                            :rules="[
                                validationRules.required,
                                validationRules.roomInt
                            ]"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="患者名"
                            v-model="patient.name"
                            placeholder="那須花子"
                            color="#62ABF8"
                            clearable
                            :readonly="readOnly.name"
                            :rules="[
                                validationRules.required,
                                validationRules.nameCounter
                            ]"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            v-model="patient.sex"
                            :items="gender"
                            label="性別"
                            color="#62ABF8"
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            v-model="patient.birthday"
                            :readonly="readOnly.birthday"
                            label="生年月日"
                            color="#62ABF8"
                            clearable
                        >
                            <template v-slot:append-outer>
                                <BirthDayPicker v-model="patient.birthday" />
                            </template>
                        </v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            v-model="patient.hospitalization"
                            :readonly="readOnly.hospitalization"
                            label="入院日"
                            color="#62ABF8"
                            clearable
                        >
                            <template v-slot:append-outer>
                                <date-picker
                                    v-model="patient.hospitalization"
                                />
                            </template>
                        </v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            v-model="patient.surgery"
                            :readonly="readOnly.surgery"
                            label="手術日"
                            color="#62ABF8"
                            clearable
                        >
                            <template v-slot:append-outer>
                                <DatePicker v-model="patient.surgery" />
                            </template>
                        </v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea
                            label="特記事項"
                            v-model="patient.memo"
                            rows="3"
                            color="#62ABF8"
                            placeholder="金属アレルギー"
                            clearable
                        ></v-textarea>
                    </v-col>
                    <v-btn
                        class="mx-auto my-2 px-12 py-4 submit_btn"
                        color="#62ABF8"
                        rounded
                        dark
                        type="submit"
                        @click="savePatientProfileData"
                        >登録</v-btn
                    >
                </v-row>
            </v-form>
        </v-card-text>
    </v-container>
</template>

<script>
//使用するコンポーネントの読み込み
import DatePicker from "../../items/DatePicker";
import BirthDayPicker from "../../items/BirthDayPicker";

export default {
    components: {
        DatePicker,
        BirthDayPicker
    },
    data: () => ({
        /**
         *
         * @param {Object} validationRules・・・・・・・バリデーションルールの設定
         * @param {Boolean} valid・・・・・・・バリデーションチェック用の真偽値
         * @param {Object} readOnly・・・各フォームが読み取り専用かどうかの状態を管理
         * @param {Object} isDialogOpen・・・Dialogの表示非表示を管理。
         * @param {Object} patient・・・患者のプロフィールデータを管理
         * @param {Array} gender・・・性別選択肢を管理
         * @param {String} gender・・・選択済みの性別（文字列）を管理
         * @param {Array} axiosErrorMessages・・・DB側のバリデーションエラーを受け取る
         *
         **/
        validationRules: {
            required: value => !!value || "入力必須です。",
            roomInt: value =>
                !/[^0-9]+/.test(value) || "半角数値で入力してください",
            nameCounter: value =>
                (value || "").length <= 20 ||
                "氏名は20字以下で入力してください。",
            memoCounter: value =>
                (value || "").length <= 200 ||
                "特記事項は200字以下で入力してください。"
        },
        valid: true,
        readOnly: {
            room: false,
            name: false,
            sex: false,
            birthday: true,
            hospitalization: true,
            surgery: true,
            memo: false
        },
        isDialogOpen: {
            successDialog: false,
            errorDialog: false
        },
        patient: {
            room: "",
            name: "",
            sex: "",
            birthday: "",
            hospitalization: "",
            surgery: "",
            memo: ""
        },
        gender: ["男性", "女性", "その他", "不明"],
        selectedGender: "",
        axiosErrorMessages: []
    }),
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        }
    },
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
        setPatientProfileData() {
            let formData = new FormData();
            //　性別を数値に変更
            let sexStr = this.patient.sex;
            let genderRole = 0;
            console.log(this.patient.sex);
            if (sexStr == "男性") {
                genderRole = 1;
            } else if (sexStr == "女性") {
                genderRole = 2;
            } else if (sexStr == "その他") {
                genderRole = 9;
            } else if (sexStr == "不明") {
                genderRole = 0;
            }

            Object.keys(this.patient).forEach(key => {
                if (this.patient[key]) {
                    console.log(key, this.patient[key]);
                    formData.append(key, this.patient[key]);
                }
            });
            formData.append("sex", genderRole);
            console.log(genderRole);
            return formData;
        },
        // formのデータの入力値のエラー確認とDB保存
        savePatientProfileData: function() {
            //入力値のエラーを確認
            if (this.$refs.form.validate()) {
                const formData = this.setPatientProfileData();

                var config = {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                };
                axios
                    .post("api/patients/post", formData, config)
                    .then(res => {
                        console.log("body:", res.data);
                        this.patient = res.data;
                        const selectedGenderRole = res.data.sex;
                        if (selectedGenderRole == 1) {
                            this.selectedGender = "男性";
                        } else if (selectedGenderRole == 2) {
                            this.selectedGender = "女性";
                        } else if (selectedGenderRole == 9) {
                            this.selectedGender = "その他";
                        } else if (selectedGenderRole == 0) {
                            this.selectedGender = "不明";
                        }
                        this.isDialogOpen.successDialog = true;
                    })
                    .catch(err => {
                        console.log(err);
                        this.setAxiosErrorData(err);
                    });
            } else {
                console.log("エラーがあるよ！");
            }
        },
        //月選択ボタンを年度の見た目にするfunction
        jpvDayFormat(str) {
            if (str === "") return str;
            let d = parseInt(str.split("-")[2]);
            return d;
        },
        save(date) {
            this.$refs.menu.save(date);
        },
        //　ダイアログを閉じる
        closeDialog(dialogName) {
            this.isDialogOpen[dialogName] = false;
            if (dialogName == "successDialog") {
                const transitionDestinationObj = {
                    name: "PatientsList"
                };
                this.patient = "";
                this.$refs.form.resetValidation();
            }
        }
    },

    created() {}
};
</script>

<style scoped>
.submit_btn {
    margin: auto;
}

/* Dialog */
.errorMessage {
    margin-bottom: 0;
}
.successMessage {
    margin-bottom: 0;
}
</style>
