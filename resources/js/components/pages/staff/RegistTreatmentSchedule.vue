<template>
    <!-- 仮オブジェクト -->
    <div>
        <h1>【スタッフ】処置スケジュール登録-各患者の処置選択</h1>
    <v-stepper value="2">
        <v-stepper-header>
            <v-stepper-step step="1">Select campaign settings</v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="2">Create an ad group</v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="3">Create an ad</v-stepper-step>
        </v-stepper-header>
          <li v-for="usersPatient in usersPatients" v-bind:key="usersPatient.id"> 
              {{usersPatient.id}} 
              {{usersPatient.name }} 
              <!-- dbには番号で登録してるけど表示は日本語で -->
              {{usersPatient.sex}}
              <!-- dbには誕生日登録してるけど表示は年齢にしたい -->
              {{usersPatient.birthday}}
            </li>
          
          <li v-for="treatment in treatments" v-bind:key="treatment.id"> 
              {{treatment.id}} 
              {{treatment.name}} 
        </li>
    </v-stepper>

    <v-card>
      <v-list-item>
        <v-list-item-content>
          <v-list>
          <v-text-field placeholder="patient_id:integer" v-model="schedule.treatment_id"></v-text-field>
          <v-text-field placeholder="treatment_id:integer" v-model="schedule.patient_id"></v-text-field>
          <v-text-field placeholder="開始時間 datetime (null ok) 2015-01-01 15:00" v-model="schedule.start_date"></v-text-field>
          <v-btn class="ma-2" outlined color="pink lighten-1"  type="submit" @click="add">
                決定
          </v-btn>
        </v-list>
        </v-list-item-content>
      </v-list-item>
    </v-card>
    
    </div>
    <!-- ここまで -->
</template>
<script>
// コンポーネントのインポート

// Vue
export default {
    components: {},
    data: () => ({
    usersPatients:[],
    treatments:[],
    schedule:{
        treatment_id:"",
        patient_id:"",
        start_date:""
      }
  }),
  methods: {
    fetchPatients: function(){
      axios.get('/api/users_patients/get/all')
      .then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
        this.usersPatients = res.data 
      })
      .catch(err =>{
      console.log('err:', err);
      })
    },
    fetchTreatment: function(){
      axios.get('/api/treatments/get/all')
      .then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
        this.treatments = res.data 
      })
      .catch(err =>{
      console.log('err:', err);
      })
    },
    add: function(schedule){
      axios.post('/api/schedules/post',{
        treatment_id:this.schedule.treatment_id,
        patient_id:this.schedule.patient_id,
        start_date:this.schedule.start_date
      })
      .then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
        this.treatment = res.data 
      })
      .catch(err =>{
      console.log('err:', err);
      })
    },
  },
    created() {
    this.fetchPatients()
    this.fetchTreatment()
  },
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
