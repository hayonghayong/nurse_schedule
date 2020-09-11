<template>
    <!-- 仮オブジェクト -->
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【リーダー】担当患者更新</v-list-item-title>
                  <ul>
                    チームメンバー
                    <li v-for="user in users" v-bind:key="user.id">
                        {{ user.name }}
                        <v-icon
                            class="ma-2"
                            outlined
                            color="#6c6c6c"
                            @click="fetchUsersPatients(user.id)"
                            >mdi-pencil</v-icon
                        >
                    </li>
                </ul>

                選択したチームメンバーの担当患者
                <li v-for="usersPatient in usersPatients" v-bind:key="usersPatient.id"> 
              {{usersPatient.name }} 
              <!-- dbには番号で登録してるけど表示は日本語で -->
              {{usersPatient.sex}}
              <!-- dbには誕生日登録してるけど表示は年齢にしたい -->
              {{usersPatient.birthday}}
              <v-icon
                            class="ma-2"
                            outlined
                            color="#6c6c6c"
                            @click="selectPatients(usersPatient.id)"
                            >mdi-pencil</v-icon
                        >
            </li>
            選択した患者情報(上手くvueに表示させれませんでした、すいません)


                <v-btn
                    class="mx-auto my-6 px-12 py-4 submit_btn"
                    color="#62ABF8"
                    rounded
                    dark
                    type="submit"
                    @click="updatePatientUser( newUsersPatients.id)"
                    >担当看護師を変更する</v-btn
                > -->
            </v-list-item-content>
        </v-list-item>
    </v-card>
      
    <!-- ここまで -->
</template>

<script>
export default {
    components: {},
    data: () => ({
        users: [],
        usersPatients:[],
        patient:[],
        newUsersPatients:[]
    }),
    methods: {
      fetchUser: function() {
            axios
                .get("/api/team_users/get/all")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.users = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
      
      fetchUsersPatients: function(userId){
        axios.get("/api/users_patients/get/"+userId
      )
      .then((res)=>{
        console.log('status:', res.status);
        console.log('body:', res.data);
        this.usersPatients = res.data 
      })
      .catch(err =>{
      console.log('err:', err);
      })
    },

        selectPatients: function(patientId) {
          console.log(patientId)
            axios
                .get("/api/patients_users/get/"+patientId)
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.patient = res.date;
              })
              .catch(err =>{
              console.log('err:', err);
              })
            },
        
        updatePatientUser: function() {
            axios
                .post("/api/users_patients/update", newUsersPatients)
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.newUsersPatients = res.date;
              })
              .catch(err =>{
              console.log('err:', err);
              })
            },

            // 担当患者変更時のセレクター用のAPI
            fetchStaff: function() {
            axios
                .get("/api/team_users/get/all")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.staffs = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
    },
    created() {
      this.fetchUser();
    }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
