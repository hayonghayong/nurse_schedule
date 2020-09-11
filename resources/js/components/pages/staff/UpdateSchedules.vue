<template>
    <!-- 仮オブジェクト -->
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【スタッフ】担当患者更新</v-list-item-title>
                <ul>
                    <li v-for="usersPatientsSchedule in usersPatientsSchedules" v-bind:key="usersPatientsSchedule.id">
                        {{ usersPatientsSchedule.patients }}
                        {{ usersPatientsSchedule.treatments }}
                    </li>
                </ul>
                <v-text-field v-model="usersPatientsSchedules.id"></v-text-field>
                <v-btn
                    class="ma-2"
                    outlined
                    color="pink lighten-1"
                    @click="select(usersPatientsSchedules.id)"
                >
                    選択
                </v-btn>
            </v-list-item-content>
        </v-list-item>
        <v-list-item>
        <v-list-item-content>
          <v-list>
          <v-text-field  v-model="editSchedules.id"></v-text-field>
          <v-text-field  v-model="editSchedules.treatment"></v-text-field>
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
export default {
    components: {},
    data: () => ({
        usersPatientsSchedules:[],
        editSchedules:[]
    }),
    methods: {
        fetchUsersPatients: function() {
            axios
                .get("/api/schedules/get/patients")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.usersPatientsSchedules = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },

        select: function() {
            axios
                .get("/api/schedules/get/" + this.$route.params.scheduleId)
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.editSchedules = res.date;
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
        this.fetchUsersPatients();
    }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
