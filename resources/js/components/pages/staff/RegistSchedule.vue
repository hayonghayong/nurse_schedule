<template>
    <!-- 仮オブジェクト -->
    <div>
        <h1>【スタッフ】処置スケジュール登録-スケジュール調整</h1>
        <v-stepper value="3">
            <v-stepper-header>
                <v-stepper-step step="1"
                    >Select campaign settings</v-stepper-step
                >

                <v-divider></v-divider>

                <v-stepper-step step="2">Create an ad group</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3">Create an ad</v-stepper-step>
            </v-stepper-header>
        </v-stepper>
        <v-card>
          <ul>
                    <li v-for="schedule in schedules" v-bind:key="schedule.id">
                        {{ schedule.id }}
                        {{ schedule.patient.room }}
                        {{ schedule.patient.name}}
                        {{ schedule.treatment.name}}
                        {{ schedule.treatment.required_flg}}
                        {{ schedule.treatment.time_required}}
                        
                    </li>
                </ul>
          <v-text-field placeholder="変更したいスケジュールidを入力" v-model="schedules.id"></v-text-field>
                <v-btn
                    class="ma-2"
                    outlined
                    color="pink lighten-1"
                    @click="selectSchedule(schedules.id)"
                >
                    選択
                </v-btn>

      <v-list-item>
        <v-list-item-content>
          <v-list>
          <v-text-field placeholder="処置id integer" v-model="editSchedule.treatment_id">
          </v-text-field>
          <v-text-field placeholder="patient_id integer" v-model="editSchedule.patient_id"></v-text-field>
          <v-text-field placeholder="開始時間 datetime (null ok) 2015-01-01 15:00" v-model="editSchedule.start_date"></v-text-field>
          <v-btn class="ma-2" outlined color="pink lighten-1"  type="submit" @click="updateSchedule">
                スケジュール変更
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
      schedules:[],
      editSchedule: {
        treatment_id:"",
        patient_id:"",
        start_date:""
      }
    }),
    methods: {

      fetchSchedule: function() {
            axios
                .get("/api/tasks/get/all")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.schedules = res.data;
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
                    this.editSchedule = res.date;
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
      }

     
     },
    created() {
      this.fetchSchedule();
    }
   
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
