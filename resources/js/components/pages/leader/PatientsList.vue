<template>
  <v-container class="patientsLists">
    <v-list subheader>
      <div v-for="(patient, index) in patients" :key="patient.id">
        <v-list-item
          class="px-8"
          :to="{
                        name: 'EditPatient',
                        params: { patientId: patient.id }
                    }"
        >
          <v-list-item-content>
            <v-list-item-subtitle class="mb-1">{{ patient.room }}号室</v-list-item-subtitle>
            <v-list-item-title>{{ patient.name }}さん</v-list-item-title>
          </v-list-item-content>

          <v-list-item-icon>
            <v-icon
              class="ma-2"
              outlined
              color="#6c6c6c"
              @click.prevent="Delete(patient.id)"
            >mdi-delete</v-icon>
          </v-list-item-icon>
        </v-list-item>
        <v-divider v-if="index + 1 < patients.length" :key="index"></v-divider>
      </div>
    </v-list>
    <v-btn
      class="mx-2 regist_float_btn"
      fab
      dark
      small
      color="#62ABF8"
      :to="{
            name: 'RegistPatient'
      }"
    >
      <v-icon dark>mdi-plus</v-icon>
    </v-btn>
  </v-container>
</template>

<script>
// コンポーネントのインポート

// Vue
export default {
  components: {},
  data: () => ({
    patients: [],
    editPatient: {
      room: "",
      name: "",
      sex: "",
      birthday: "",
      hospitalization_date: "",
      surgery_date: "",
      memo: ""
    }
  }),
  created() {
    this.fetchPatients();
  },
  methods: {
    // 患者一覧取得
    fetchPatients: function() {
      axios
        .get("/api/patients/get/all")
        .then(res => {
          console.log("status:", res.status);
          console.log("body:", res.data);
          this.patients = res.data;
        })
        .catch(err => {
          console.log("err:", err);
        });
    },
    // 患者削除
    Delete: function(patientId) {
      if (confirm("削除してよろしいでしょうか?"))
        axios
          .delete("/api/patients/delete", {
            data: { id: patientId }
          })
          .then(res => {
            console.log("status:", res.status);
            console.log("body:", res.data);
            this.patients = res.data;
          })
          .catch(err => {
            console.log("err:", err);
          });
    }
  }
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
