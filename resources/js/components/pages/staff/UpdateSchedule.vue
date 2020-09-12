<template>
    <!-- 仮オブジェクト -->
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【スタッフ】スケジュール更新</v-list-item-title>
                <ul>
                    <li v-for="usersPatientsSchedule in usersPatientsSchedules" v-bind:key="usersPatientsSchedule.id">
                        {{ usersPatientsSchedule.patients }}
                        {{ usersPatientsSchedule.treatments }}
                    </li>
                </ul>
                <v-text-field placeholder="変更したいスケジュールidを入力" v-model="usersPatientsSchedules.id"></v-text-field>
                <v-btn
                    class="ma-2"
                    outlined
                    color="pink lighten-1"
                    @click="selectSchedule(usersPatientsSchedules.id)"
                >
                    選択
                </v-btn>
            </v-list-item-content>
        </v-list-item>
          <v-btn class="ma-2" outlined color="pink lighten-1"  type="submit" @click="updateSchedule(schedule.id)">
                変更
          </v-btn>
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

        selectSchedule: function(scheduleId) {
            axios
                .get("/api/schedules/get/" + scheduleId)
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.editSchedules = res.date;
              })
              .catch(err =>{
              console.log('err:', err);
              })
            },

        updateSchedule: function(schedule){
      axios.post('/api/schedules/update',{
        schedule_id:this.schedule.treatment_id,
        patient_id:this.schedule.patient_id,
        treatment_id:this.schedule.start_date
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
