<template>
  <v-container fluid class="editPatientCotainer pb-12">
    <v-card-text v-if="isActive.detailWrap" class="text-center detailCard">
      <v-row>
        <v-col cols="12 mt-4">
          <div class="d-flex justify-space-between px-4 detailTextWarp">
            <p class="patientItem">部屋番号</p>
            <p class="patientNode">{{ editPatientData.room }}</p>
          </div>
          <v-divider></v-divider>
        </v-col>
        <v-col cols="12">
          <div class="d-flex justify-space-between px-4 detailTextWarp">
            <p class="patientItem">患者名</p>
            <p class="patientNode">{{ editPatientData.name }}</p>
          </div>
          <v-divider></v-divider>
        </v-col>
        <v-col cols="12">
          <div class="d-flex justify-space-between px-4 detailTextWarp">
            <p class="patientItem">性別</p>
            <p class="patientNode">{{ editPatientData.sex }}</p>
          </div>
          <v-divider></v-divider>
        </v-col>
        <v-col cols="12">
          <div class="d-flex justify-space-between px-4 detailTextWarp">
            <p class="patientItem">誕生日</p>
            <p class="patientNode">{{ editPatientData.birthday }}</p>
          </div>
          <v-divider></v-divider>
        </v-col>
        <v-col cols="12">
          <div class="d-flex justify-space-between px-4 detailTextWarp">
            <p class="patientItem">入院日</p>
            <p class="patientNode">{{ editPatientData.hospitalization_date }}</p>
          </div>
          <v-divider></v-divider>
        </v-col>
        <v-col cols="12">
          <div class="d-flex justify-space-between px-4 detailTextWarp">
            <p class="patientItem">手術日</p>
            <p class="patientNode">{{ editPatientData.surgery_date }}</p>
          </div>
          <v-divider></v-divider>
        </v-col>
        <v-col cols="12">
          <div class="d-flex justify-space-between px-4 detailTextWarp">
            <p class="patientItem">特記事項</p>
            <p class="patientNode">{{ editPatientData.memo }}</p>
          </div>
          <v-divider></v-divider>
        </v-col>
        <v-btn
          class="mx-auto my-6 px-12 py-4 submit_btn"
          color="#62ABF8"
          rounded
          dark
          type="submit"
          @click="isActiveEditWrap"
        >編集する</v-btn>
      </v-row>
    </v-card-text>
    <v-card-text v-if="isActive.editWrap" class="text-center editCard">
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row>
          <v-col cols="12" class="py-0">
            <v-text-field
              label="部屋番号"
              v-model="editPatientData.room"
              color="#62ABF8"
              clearable
              :readonly="readOnly.room"
              :rules="[
                              validationRules.required,
                              validationRules.roomInt
                          ]"
            ></v-text-field>
          </v-col>
          <v-col cols="12" class="py-0">
            <v-text-field
              label="患者名"
              v-model="editPatientData.name"
              color="#62ABF8"
              clearable
              :readonly="readOnly.name"
              :rules="[
                              validationRules.required,
                              validationRules.nameCounter
                          ]"
            ></v-text-field>
          </v-col>
          <v-col cols="12" class="py-0">
            <v-select v-model="editPatientData.sex" :items="gender" label="性別" color="#62ABF8"></v-select>
          </v-col>
          <v-col cols="12" class="py-0">
            <v-text-field
              v-model="editPatientData.birthday"
              :readonly="readOnly.birthday"
              label="生年月日"
              color="#62ABF8"
              clearable
            >
              <template v-slot:append-outer>
                <BirthDayPicker v-model="editPatientData.birthday" />
              </template>
            </v-text-field>
          </v-col>
          <v-col cols="12" class="py-0">
            <v-text-field
              v-model="editPatientData.hospitalization_date"
              :readonly="readOnly.hospitalization"
              label="入院日"
              color="#62ABF8"
              clearable
            >
              <template v-slot:append-outer>
                <date-picker
                  v-model="
                                      editPatientData.hospitalization_date
                                  "
                />
              </template>
            </v-text-field>
          </v-col>
          <v-col cols="12" class="py-0">
            <v-text-field
              v-model="editPatientData.surgery_date"
              :readonly="readOnly.surgery"
              label="手術日"
              color="#62ABF8"
              clearable
            >
              <template v-slot:append-outer>
                <DatePicker v-model="editPatientData.surgery_date" />
              </template>
            </v-text-field>
          </v-col>
          <v-col cols="12" class="py-0">
            <v-textarea
              label="特記事項"
              v-model="editPatientData.memo"
              rows="3"
              color="#62ABF8"
              clearable
            ></v-textarea>
          </v-col>
          <v-btn
            class="mx-auto my-2 px-12 py-4 submit_btn"
            color="#62ABF8"
            rounded
            dark
            type="submit"
            @click="updatePatientData(editPatientData.id)"
          >変更を保存</v-btn>
        </v-row>
      </v-form>
    </v-card-text>
    <v-dialog v-model="isDialogOpen.successDialog" persistent　width="350">
      <v-card>
        <v-card-title class="headline lighten-2 text--secondary" color="#62ABF8" primary-title>完了</v-card-title>
        <v-card-text>患者編集が完了しました！</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="#62ABF8" text @click="closeDialog('successDialog')">閉じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="isDialogOpen.errorDialog" width="350">
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
//使用するコンポーネントの読み込み
import DatePicker from "../../items/DatePicker";
import BirthDayPicker from "../../items/BirthDayPicker";

// Vue
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
     * @param {Object} isActive・・・表示非表示を管理。
     * @param {Object} isDialogOpen・・・Dialogの表示非表示を管理。
     * @param {Object} editPatientData・・・患者のプロフィールデータを管理
     * @param {Array} gender・・・性別選択肢を管理
     * @param {Array} axiosErrorMessages・・・DB側のバリデーションエラーを受け取る
     *
     **/
    validationRules: {
      required: value => !!value || "入力必須です。",
      roomInt: value => !/[^0-9]+/.test(value) || "半角数値で入力してください",
      nameCounter: value =>
        (value || "").length <= 20 || "氏名は20字以下で入力してください。",
      memoCounter: value =>
        (value || "").length <= 200 || "特記事項は200字以下で入力してください。"
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
    editPatientData: {
      room: "",
      name: "",
      sex: "",
      birthday: "",
      hospitalization_date: "",
      surgery_date: "",
      memo: ""
    },
    gender: ["男性", "女性", "その他", "不明"],
    isActive: {
      detailWrap: true,
      editWrap: false
    },
    isDialogOpen: {
      successDialog: false,
      errorDialog: false
    },
    axiosErrorMessages: []
  }),
  watch: {
    menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
    }
  },
  created() {
    this.getPatientData();
  },
  methods: {
    // 更新する患者情報取得
    getPatientData: function() {
      axios
        .get("/api/patients/get/" + this.$route.params.patientId)
        .then(res => {
          console.log("status:", res.status);
          console.log("body:", res.data);
          const editPatientFetch = res.data;
          this.editPatientData = editPatientFetch;
          const patientSexInt = editPatientFetch.sex;
          // this.setStrSexData(res);
          //　性別を文字列に変更する処理
          if (patientSexInt == 1) {
            this.editPatientData.sex = "男性";
          } else if (patientSexInt == 2) {
            this.editPatientData.sex = "女性";
          } else if (patientSexInt == 9) {
            this.editPatientData.sex = "その他";
          } else if (patientSexInt == 0) {
            this.editPatientData.sex = "不明";
          }
        })
        .catch(err => {
          console.log("err:", err);
        });
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
    // formのデータを定義
    setPatientProfileData() {
      let formData = new FormData();
      //　性別を数値に変更
      let sexStr = this.editPatientData.sex;
      let genderRole = 0;
      console.log(this.editPatientData.sex);
      if (sexStr == "男性") {
        genderRole = 1;
      } else if (sexStr == "女性") {
        genderRole = 2;
      } else if (sexStr == "その他") {
        genderRole = 9;
      } else if (sexStr == "不明") {
        genderRole = 0;
      }

      Object.keys(this.editPatientData).forEach(key => {
        if (this.editPatientData[key]) {
          console.log(key, this.editPatientData[key]);
          formData.append(key, this.editPatientData[key]);
        }
      });
      formData.append("sex", genderRole);
      console.log(genderRole);
      return formData;
    },
    // 患者情報更新
    updatePatientData: function() {
      //入力値のエラーを確認
      if (this.$refs.form.validate()) {
        const formData = this.setPatientProfileData();

        var config = {
          headers: {
            "content-type": "multipart/form-data"
          }
        };
        axios
          .post(
            "/api/patients/update/" + this.$route.params.patientId,
            formData,
            config
          )
          .then(res => {
            console.log("status:", res.status);
            console.log("body:", res.data);
            this.patient = res.data;
            const selectedGenderRole = res.data.sex;
            if (selectedGenderRole == 1) {
              this.editPatientData.sex = "男性";
            } else if (selectedGenderRole == 2) {
              this.editPatientData.sex = "女性";
            } else if (selectedGenderRole == 9) {
              this.editPatientData.sex = "その他";
            } else if (selectedGenderRole == 0) {
              this.editPatientData.sex = "不明";
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
    // 編集画面の表示
    isActiveEditWrap: function() {
      this.isActive.detailWrap = false;
      this.isActive.editWrap = true;
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
        this.isActive.editWrap = false;
        this.isActive.detailWrap = true;

        const transitionDestinationObj = {
          name: "PatientsList"
        };
        this.$router.push(transitionDestinationObj);
      }
    }
  }
};
</script>

<style scoped>
.detailTextWarp p {
  margin-bottom: 8px;
}

.patientItem {
  color: #2699fb;
}
</style>
