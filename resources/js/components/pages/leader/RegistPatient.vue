<template> 
    <!-- 仮オブジェクト -->
    <v-container fluid style="padding-top:0;">
        <v-card-text style="padding-top:0;">
          <h1>【リーダー】患者登録 </h1>
          <v-row>
            <v-col>
              <v-text-field label="部屋番号" v-model="patient.room"></v-text-field>
              <v-text-field label="患者名" v-model="patient.name"></v-text-field>
              <v-text-field label="性別" v-model="patient.sex"></v-text-field>
              <v-text-field label="生年月日" v-model="patient.birthday"></v-text-field>
              <v-text-field label="入院日" v-model="patient.hospitalization"></v-text-field>
              <v-text-field label="手術日" v-model="patient.surgery"></v-text-field>
              <v-text-field label="特記事項" v-model="patient.memo"></v-text-field>
              <v-btn class="ma-2" outlined color="pink lighten-1" type="submit" @click="add">登録</v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-container>
    
    <!-- ここまで -->
</template>
<script>
// コンポーネントのインポート

// Vue
export default {
    components: {},
    data: () => ({
      patient: {
        room:'',
        name:'',
        sex:'',
        birthday:'',
        hospitalization:'',
        surgery:'',
        memo:''
      },
    }),

    methods: {

      add: function() {
      axios.post('/api/add', {
          room: this.patient.room,
          name: this.patient.name,
          sex: this.patient.sex,
          birthday: this.patient.birthday,
          hospitalization: this.patient.hospitalization,
          surgery:this.patient.surgery,
          memo: this.patient.memo,
        })
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
    this.add()
  },
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
