<template> 
    <!-- 仮オブジェクト -->
    <v-card>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title>【リーダー】処置登録</v-list-item-title>
          <ul >
          </ul>
          <v-list>
          <v-text-field v-model="treatment.name"></v-text-field>
          <v-text-field v-model="treatment.time_required"></v-text-field>
          <v-text-field v-model="treatment.required_flg"></v-text-field>
          <v-btn class="ma-2" outlined color="pink lighten-1"  type="submit" @click="add">
                変更
          </v-btn>
        </v-list>
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
    treatment:{
      name:"",
      time_required:"",
      required_flg:""
    },
  }),
  methods: {
    add: function(treatment){
      axios.post('/api/treatments/post',{
        name:this.treatment.name,
        time_required:this.treatment.time_required,
        required_flg:this.treatment.required_flg
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
  created() {},
  };
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
