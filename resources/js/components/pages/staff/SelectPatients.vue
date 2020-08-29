<template> 
    <!-- 仮オブジェクト -->
    <v-card>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title>【スタッフ】患者選択</v-list-item-title>
          <ul >
            <li v-for="patient in patients" v-bind:key="patient.id"> {{patient.room}} {{ patient.name }} </li>
          </ul>
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
  }),
  methods: {
    fetchPatients: function(){
      axios.get('/api/get')
      .then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
        this.patients = res.data 
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
