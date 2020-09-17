<template>
    <!-- 仮オブジェクト -->
    <!--<div>
        <h1>【スタッフ】処置スケジュール登録-各患者の処置選択</h1>
    <v-stepper value="2">
        
          <li v-for="usersPatient in usersPatients" v-bind:key="usersPatient.id"> 
              {{usersPatient.patient_id}} 
              {{usersPatient.name }} -->
              <!-- dbには番号で登録してるけど表示は日本語で -->
              <!--{{usersPatient.sex}}-->
              <!-- dbには誕生日登録してるけど表示は年齢にしたい -->
              <!--{{usersPatient.birthday}}-->
            <!--</li>
          
          <li v-for="treatment in treatments" v-bind:key="treatment.id"> 
              {{treatment.id}} 
              {{treatment.name}} 
        </li>
    </v-stepper>
    </div>-->

    <!--
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
    -->
    <!-- ここまで -->
    <v-container>
        <v-stepper value="2" alt-labels>
              <v-stepper-header>
                  <v-stepper-step step="1" complete>患者選択</v-stepper-step>

                  <v-divider></v-divider>

                  <v-stepper-step step="2">処置設定</v-stepper-step>

                  <v-divider></v-divider>

                  <v-stepper-step step="3">スケジュール設定</v-stepper-step>
              </v-stepper-header>
        </v-stepper>
          <div class="patient_wrap">
            <!--<li v-for="usersPatient in usersPatients" v-bind:key="usersPatient.id"> -->
            <li v-for="usersPatient in usersPatients" v-bind:key="usersPatient.id"> 

              {{usersPatient.patient_id}}
              {{usersPatient.room }}号室
              {{usersPatient.name }}さん

              <span v-if="usersPatient.sex　== 1">男性</span>
              <span v-else>女性</span>

              <!-- dbには誕生日登録してるけど表示は年齢にしたい -->
              {{usersPatient.birthday}}
            </li>
          </div>
            <p class="center">今日行う処置を選択してください</p>

            <div class="select_wrap">
              <div class="cp_ipselect cp_sl02">
                <select>
                    <option disabled value="">選択してください</option>
                    <option v-for="treatment in treatments" v-bind:value="treatment.name" v-bind:key="treatment.id">{{treatment.name}}</option>
                </select>
              </div>
              <div class="button_wrap my-5">
                    <v-btn rounded depressed dark width="50" class="button" color="#2196F3" @click="">追加</v-btn>
              </div>
            </div>

            <div>
              <p>登録済みの処置（10）</p>
            </div>
              <table>
                <!-- テーブルヘッダー -->
                <thead>
                  <tr>
                    <!--<th class="id">ID</th>-->
                    <th class="comment"></th></th>
                    <th class="time_input"></th></th>
                    <th class="button"></th></th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                  <!--<th>1</th>-->
                  <td class="treatment_name center">点滴</td>
                  <td class="time_input">
                       <vue-timepicker
                       :minute-interval="10"
                        id="start_time"
                        name="startTime"
                        placeholder="開始時間"
                        input-class="form-control"
                       ></vue-timepicker>
                        <vue-timepicker
                         :minute-interval="10"
                          id="end_time"
                          name="endTime"
                          placeholder="終了時間"
                          input-class="form-control"
                        ></vue-timepicker>

                  </td>
                  <td class="button">
                    <!-- ★STEP10 削除ボタン -->
                    <v-btn color="blue lighten-1" depressed fab small icon>
                       <v-icon>mdi-trash-can</v-icon>
                    </v-btn>
                  </td>
                </tr>
              </tbody>
              </table>
    </v-container>
</template>
<script>
// コンポーネントのインポート
import VueTimepicker from 'vue2-timepicker'
import 'vue2-timepicker/dist/VueTimepicker.css'
// Vue
export default {
    components: {
      'vue-timepicker': VueTimepicker,
    },
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
.patient_wrap{
  margin:1em;
}
.patient_wrap li{
  color:#FD9549;
  font-weight:bold;
  list-style: none; 
  text-align:center;
}

.select_wrap,.time_input{
  display:flex;
}
.center{
  text-align:center;
  margin:0;
}
.comment{
  width:80px;
}
.time_input,.comment{
  width:100%;
}
.treatment_name{
  background-color:#E6F4FF;
  color:#62ABF8;
}

.cp_ipselect {
	overflow: hidden;
	width: 70%;
	margin: 1em;
}
.cp_ipselect select {
	width: 100%;
	padding-right: 1em;
	cursor: pointer;
	text-indent: 0.01px;
	text-overflow: ellipsis;
	border: none;
	outline: none;
	background: transparent;
	background-image: none;
	box-shadow: none;
	-webkit-appearance: none;
	appearance: none;
}
.cp_ipselect select::-ms-expand {
    display: none;
}
.cp_ipselect.cp_sl02 {
	position: relative;
	border: 1px solid #bbbbbb;
	border-radius: 2px;
	background: #ffffff;
}
.cp_ipselect.cp_sl02::before {
	position: absolute;
	top: 0.8em;
	right: 0.9em;
	width: 0;
	height: 0;
	padding: 0;
	content: '';
	border-left: 6px solid transparent;
	border-right: 6px solid transparent;
	border-top: 6px solid #666666;
	pointer-events: none;
}
.cp_ipselect.cp_sl02:after {
	position: absolute;
	top: 0;
	right: 2.5em;
	bottom: 0;
	width: 1px;
	content: '';
	border-left: 1px solid #bbbbbb;
}
.cp_ipselect.cp_sl02 select {
	padding: 8px 38px 8px 8px;
	color: #666666;
}
.button{
  width:10px;
}

.v-stepper{
    box-shadow: none;
}
.v-stepper__header{
    box-shadow: none;
}
.v-stepper--alt-labels .v-stepper__header .v-divider{
    margin: 22px -80px 0;
}
.v-divider{
    max-width: 90px;
}
.v-stepper__step{
    padding: 10px;
}
.v-stepper--alt-labels .v-stepper__step{
    flex-basis: 100px;
}

</style>
