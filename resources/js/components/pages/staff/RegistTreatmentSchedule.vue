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
              {{usersPatient.patient_id}} 
              {{usersPatient.name }} 
              <!-- dbには番号で登録してるけど表示は日本語で -->
              {{usersPatient.sex}}
              <!-- dbには誕生日登録してるけど表示は年齢にしたい -->
              {{usersPatient.birthday}}
            </li>
    </v-stepper>
    
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
  }),
  methods: {
    fetchPatients: function(){
      axios.get('/api/get')
      .then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
        this.usersPatients = res.data 
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
