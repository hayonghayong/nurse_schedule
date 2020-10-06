<template>
  <v-container class="editTreatment">
    <v-card-text class="text-center">
      <h1 class="headline">処置編集</h1>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row>
          <v-col cols="12" class="py-0">
            <v-text-field
              label="処置名"
              v-model="editTreatment.name"
              color="#62ABF8"
              :rules="[validationRules.required]"
            ></v-text-field>
          </v-col>
          <v-col cols="12" class="py-0">
            <v-select
              v-model="editTreatment.time_required"
              :items="timeRequired"
              label="処置時間"
              color="#62ABF8"
              clearable
              :rules="[validationRules.required]"
            ></v-select>
          </v-col>
          <p>スケジュールに表示される色を選択してください</p>
          <v-col cols="12" class="py-0">
            <v-color-picker
              class="ma-2"
              hide-canvas
              hide-inputs
              show-swatches
              swatches-max-height="100px"
              v-model="editTreatment.color_code"
            ></v-color-picker>
          </v-col>
          <v-col cols="12" class="py-0">
            <header class="labelFlag text-left">優先</header>
            <v-switch
              v-model="editTreatment.required_flg"
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
            @click="updateTreatmentData()"
          >変更</v-btn>
        </v-row>
      </v-form>
    </v-card-text>

    <v-dialog v-model="isDialogOpen.successDialog" width="400">
      <v-card>
        <v-card-title class="headline lighten-2 text--secondary" color="#62ABF8" primary-title>完了</v-card-title>
        <v-card-text>
          下記内容で処置登録が完了しました！
          <p class="successMessage mb-0">処置名：{{ editTreatment.name }}</p>
          <p class="successMessage mb-0">患者名：{{ editTreatment.time_required }}分</p>
          <p class="successMessage mb-0">
            色：
            <span :style="color">●</span>
          </p>
          <p class="successMessage mb-0">必須：{{ selectedrequiredFlg }}</p>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="#62ABF8" text @click="closeDialog('successDialog')">閉じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="isDialogOpen.errorDialog" width="400">
      <v-card>
        <v-card-title class="headline lighten-2 text--secondary" primary-title>エラー</v-card-title>
        <v-card-text>
          <p
            v-for="(message, index) in axiosErrorMessages"
            :key="index"
            class="errorMessage"
          >・{{ axiosErrorMessages[index] }}</p>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="#62ABF8" text @click="closeDialog('errorDialog')">閉じる</v-btn>
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
    validationRules: {
      required: value => !!value || "入力必須です。",
      nameCounter: value =>
        (value || "").length <= 20 || "処置名は20字以下で入力してください。"
    },
    valid: true,
    isDialogOpen: {
      successDialog: false,
      errorDialog: false
    },
    setTreatmentRequiredFlag: true,
    editTreatment: {
      name: "",
      time_required: "",
      color_code: "",
      required_flg: ""
    },
    timeRequired: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60],
    selectedrequiredFlg: true,
    axiosErrorMessages: [],
    color: {
      color: ""
    }
  }),
  created() {
    this.getTreatmentData(this.$route.params.treatmentId);
  },
  methods: {
    // 更新する処置情報取得
    getTreatmentData: function(treatmentId) {
      axios
        .get("/api/treatments/get/" + treatmentId)
        .then(res => {
          console.log("status:", res.status);
          console.log("body:", res.data);

          const fetchTreatmentData = res.data;
          this.editTreatment = fetchTreatmentData;
          const fetchRequiredFlag = fetchTreatmentData.required_flg;
          console.log(this.setTreatmentRequiredFlag);
        })
        .catch(err => {
          console.log("err:", err);
        });
    },
    // formのデータを定義
    setTreatmentData() {
      let formData = new FormData();

      Object.keys(this.editTreatment).forEach(key => {
        if (this.editTreatment[key]) {
          console.log(key, this.editTreatment[key]);
          // カラーコードを格納
          if (this.editTreatment[key].hex) {
            this.treatment[key] = this.treatment[key].hex;
          }
          formData.append(key, this.editTreatment[key]);
        }
      });
      formData.append("required_flg", this.editTreatment.required_flg);
      return formData;
    },
    //　サーバー側からのエラーを定義
    setAxiosErrorData(err) {
      const axiosErrorRes = err.response.data;
      let axiosErrorMessageArray = [];

      if (axiosErrorRes.errors) {
        const axiosvalidationErrorRes = axiosErrorRes.errors;

        axiosErrorMessageArray = Object.keys(axiosvalidationErrorRes).map(
          dataField => {
            return axiosvalidationErrorRes[dataField][0];
          }
        );
      } else {
        axiosErrorMessageArray.push(
          "回答が送信されませんでした。再度送信してください。"
        );
      }
      this.axiosErrorMessages = axiosErrorMessageArray;
      console.log(this.axiosErrorMessages);
      this.isDialogOpen.errorDialog = true;
    },
    // 処置情報更新
    updateTreatmentData: function() {
      //入力値のエラーを確認
      if (this.$refs.form.validate()) {
        const formData = this.setTreatmentData();
        var config = {
          headers: {
            "content-type": "multipart/form-data"
          }
        };
        axios
          .post(
            "/api/treatments/update/" + this.$route.params.treatmentId,
            formData,
            config
          )
          .then(res => {
            console.log("status:", res.status);
            console.log("body:", res.data);
            this.color.color = this.editTreatment.color_code;
            const updateTreatment = res.data;
            const updateTreatmentRequiredFlg = updateTreatment.required_flg;
            this.editTreatment = updateTreatment;
            if (updateTreatmentRequiredFlg == 0) {
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
  }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
