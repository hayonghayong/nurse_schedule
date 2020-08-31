<template> 
    <!-- 仮オブジェクト -->
    <v-card>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title>【リーダー】患者一覧</v-list-item-title>
          <ul >
            <li v-for="patient in patients" v-bind:key="patient.id"> {{patient.room}} {{ patient.name }} 
              <v-btn class="ma-2" outlined color="pink lighten-1" @click="Edit(patient.id)">編集</v-btn>
              <v-btn class="ma-2" outlined color="pink lighten-1" @click="Delete(patient.id)">削除
              </v-btn>
            </li>
          </ul>
          <v-col>
              <v-text-field v-model="editPatient.room"></v-text-field>
              <v-text-field v-model="editPatient.name"></v-text-field>
              <v-text-field v-model="editPatient.sex"></v-text-field>
              <v-text-field v-model="editPatient.birthday"></v-text-field>
              <v-text-field v-model="editPatient.hospitalization_date"></v-text-field>
              <v-text-field v-model="editPatient.surgery_date"></v-text-field>
              <v-text-field v-model="editPatient.memo"></v-text-field>
              <v-btn class="ma-2" outlined color="pink lighten-1" @click="Update(editPatient.id)">変更
              </v-btn>
            </v-col>
        </v-list-item-content>
      </v-list-item>
    </v-card>
    <!-- ここまで -->
</template>
<script>
// コンポーネントのインポート

// Vue
export default {
  components: {},
  data: () => ({
    patients:[],
    editPatient:{
      room: "",
      name: "",
      sex: "",
      birthday: "",
      hospitalization_date: "",
      surgery_date: "",
      memo: ""
    },
  }),
  methods: {
    // 患者一覧取得
    fetchPatients: function(){
      axios.get('/api/allPatient')
      .then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
        this.patients = res.data 
      })
      .catch(err =>{
      console.log('err:', err);
      })
    },

    // 患者削除
    Delete: function(patientId){ 
      axios.delete('/api/delPatient', {
        data:{id: patientId}
        }).then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
      this.patient = res.data
    })
    .catch(err =>{
      console.log('err:', err);
      })
    },

    // 更新する患者情報取得
    Edit: function(patientId){
      console.log(patientId)
      axios.get('/api/getPatient/'+patientId,{
        }).then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
      this.editPatient = res.data
    })
    .catch(err =>{
      console.log('err:', err);
      })
    },

    // 患者情報更新
    Update: function(editPatientId){
      axios.post('/api/updatePatient/'+editPatientId
      ,{
        id:editPatientId,
        patient:this.editPatient,
        patient_room:this.editPatient.room,
        patient_name:this.editPatient.name,
        patient_sex:this.editPatient.sex,
        patient_birthday:this.editPatient.birthday,
        patient_hospitalization:this.editPatient.hospitalization_date,
        patient_surgery:this.editPatient.surgery_date,
        patient_memo:this.editPatient.memo
      } 
      ).then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
      this.patient = res.data
    })
    .catch(err =>{
      console.log('err:', err);
      })
    },
  },


  created() {
    this.fetchPatients()
  },
  };


  
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
