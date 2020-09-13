<template>
  <!-- <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【リーダー】スタッフ一覧</v-list-item-title>
                <ul>
                    <li v-for="staff in staffs" v-bind:key="staff.id">
                        {{ staff.name }}
                    </li>
                </ul>

                <v-text-field v-model="staffs.id"></v-text-field>
                <v-btn
                    class="ma-2"
                    outlined
                    color="pink lighten-1"
                    @click="select(staffs.id)"
                >
                    決定
                </v-btn>
            </v-list-item-content>
        </v-list-item>
  </v-card>-->
  <v-item-group multiple v-model="saveSelecyedStaff">
    <v-container>
      <v-list-item-title class="center">本日のチームスタッフを全て選択してください</v-list-item-title>
      <v-row>
        <v-col v-for="staff in staffs" :key="staff.id" cols="6">
          <v-item v-slot:default="{ active, toggle }" :value="staff.id">
            <v-hover v-slot:default="{ hover }">
              <v-card
                :color="active ? '#62ABF8' : ''"
                class="d-flex align-center"
                :class="{ 'on-hover': hover }"
                outlined
                height="100"
                @click="toggle"
              >
                <v-card-text>
                  <div>〇〇科 {{ staff.id }}</div>
                  <p class="name">{{staff.name}} Ns</p>
                </v-card-text>

                <v-scroll-y-transition>
                  <div v-if="active" class="display-3 flex-grow-1"></div>
                </v-scroll-y-transition>
              </v-card>
            </v-hover>
          </v-item>
        </v-col>
      </v-row>
        {{saveSelecyedStaff}}

      <v-footer
      fixed
      class="font-weight-medium footer"
      >
          <v-btn
            class="mx-auto my-2 px-12 py-4 submit_btn"
            color="#62ABF8"
            rounded
            dark depressed width="220"
            type="submit"
            @click="pushSelectedData()"
          >決定</v-btn>
      </v-footer>
    </v-container>
  </v-item-group>
</template>
<script>
// Vue
export default {
  components: {},
  data: () => ({
    staffs: [],
    saveSelecyedStaff: []
  }),
  methods: {
    fetchStaff: function() {
      axios
        .get("/api/users/get/all")
        .then(res => {
          console.log("status:", res.status);
          console.log("body:", res.data);
          this.staffs = res.data;
        })
        .catch(err => {
          console.log("err:", err);
        });
    },
    pushSelectedData: function() {
      axios
        .post("/api/team_users/add/", {
          id: this.saveSelecyedStaff
        })
        .then(res => {
          console.log("status:", res.status);
          console.log("body:", res.data);
          this.staffs = res.data;
        })
        .catch(err => {
          "err:", err;
        });
    }
  },
  created() {
    this.fetchStaff();
  }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
.footer{
  background:rgba(255,0 0,0.5);
}
.name{
  font-size:17px;
}
.center{
  text-align:center;
  padding:1.2rem 0;
}
.theme--light.v-sheet--outlined{
  border:  solid 2px rgb(98,171,248,0.9);
}

.v-card:not(.on-hover) {
  opacity: 0.8;
  border: thin solid rgb(0,0,0,0.12);
}

</style>
