<template> 
    <!-- 仮オブジェクト -->
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【リーダー】チーム全員の予定一覧</v-list-item-title>
                <ul>
                    <li v-for="staff in staffs" v-bind:key="staff.id">
                        {{ staff.name }}
                    </li>
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
      staffs: []
    }),
    methods: {
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
      
      fetchSchedule: function() {
            axios
                .get("/api/schedules/get/team")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.schedules = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
    },

    created() {
      this.fetchStaff();
      this.fetchSchedule();
    },
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
