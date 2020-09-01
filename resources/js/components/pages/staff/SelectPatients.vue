<template> 
    <!-- 仮オブジェクト -->
    <v-card>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title>【スタッフ】患者選択</v-list-item-title>
          <ul >
            <li v-for="patient in patients" v-bind:key="patient.id"> 
              {{patient.room}} 
              {{ patient.name }} 
              <!-- dbには番号で登録してるけど表示は日本語で -->
              {{patient.sex}}
              <!-- dbには誕生日登録してるけど表示は年齢にしたい！ -->
              {{patient.birthday}}
              {{patient.hospitalization_date}}
              {{patient.surgery_date}}
              {{patient.memo}}
            </li>
          </ul>
          <v-btn class="ma-2" outlined color="pink lighten-1" @click="select(patients.id)">
                決定
          </v-btn>
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
    usersPatients:[],
  }),
  methods: {
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

    select:function(patientsId){
      console.log(patientsId)
      axios.post("/api/add/"+patientsId
      ,{
        id:patientsId
      })
      .then(res => {
        console.log('status:', res.status);
        console.log('body:', res.data);
        this.usersPatients = res.data 
      })
      .catch(err => {'err:', err})
            } 
    },
  created() {
    this.fetchPatients()
  },
  };


  
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
