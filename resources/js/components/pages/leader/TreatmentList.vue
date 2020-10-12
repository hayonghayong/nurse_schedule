<template>
  <v-container class="treatmentsLists">
    <v-list subheader>
      <div v-for="(treatment, index) in treatments" :key="treatment.id">
        <v-list-item
          class="px-8"
          :to="{
            name: 'EditTreatment',
            params: { treatmentId: treatment.id },
          }"
        >
          <v-list-item-avatar>
            <span :style="'color:' + treatment.color_code">●</span>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>{{ treatment.name }}</v-list-item-title>
          </v-list-item-content>
          <!-- 削除モーダル -->
          <v-list-item-icon>
            <v-row justify="center">
              <v-btn icon color="pink">
                <v-icon
                  class="ma-2"
                  outlined
                  color="#6c6c6c"
                  @click.prevent="openModal(treatment)"
                  >mdi-delete</v-icon
                >
              </v-btn>
              <v-dialog v-model="dialog" max-width="290" :retain-focus="false">
                <v-card>
                  <v-card-title class="headline">
                    以下の処置を削除しますか？
                  </v-card-title>
                  <v-card-text>
                    {{ selectModalData.name }}
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="dialog = false">
                      戻る
                    </v-btn>
                    <v-btn
                      color="green darken-1"
                      text
                      @click="Delete(selectModalData.id)"
                    >
                      削除
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-row>
          </v-list-item-icon>
          <!-- 削除モーダル ここまで -->
        </v-list-item>
        <!--  -->
        <v-divider
          v-if="index + 1 < treatments.length"
          :key="index"
        ></v-divider>
      </div>
    </v-list>
    <!-- 追加ボタン -->
    <v-btn
      class="mx-2 regist_float_btn"
      fab
      dark
      small
      color="#62ABF8"
      :to="{
        name: 'RegistTreatment',
      }"
    >
      <v-icon dark> mdi-plus </v-icon>
    </v-btn>
  </v-container>
</template>
<script>
// Vue
export default {
  components: {},
  data: () => ({
    treatments: [],
    editTreatment: {
      name: "",
      time_required: "",
      required_flg: "",
    },
    dialog: false,
    selectModalData: "",
  }),
  created() {
    this.fetchTreatment();
  },
  methods: {
    fetchTreatment: function () {
      axios
        .get("/api/treatments/get/all")
        .then((res) => {
          console.log("status:", res.status);
          console.log("body:", res.data);
          this.treatments = res.data;
        })
        .catch((err) => {
          console.log("err:", err);
        });
    },
    //処置削除
    Delete: function (treatmentId) {
      // if (confirm("削除してよろしいでしょうか?"))
      axios
        .delete("/api/treatments/delete", {
          data: { id: treatmentId },
        })
        .then((res) => {
          console.log("status:", res.status);
          console.log("body:", res.data);
          this.treatments = res.data;
          this.dialog = false;
        })
        .catch((err) => {
          console.log("err:", err);
        });
    },
    openModal: function (treatment) {
      this.dialog = true;
      this.selectModalData = treatment;
    },
  },
};
</script>

<style scoped>
/* スコープ付きのスタイル */
.regist_float_btn {
  position: fixed;
  bottom: 80px;
  right: 20px;
}
</style>
