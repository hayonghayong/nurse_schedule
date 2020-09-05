<template>
    <!-- 仮オブジェクト -->
    <v-card>
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
        select: function(staffsId) {
            console.log(staffsId);
            axios
                .post("/api/team_users/add/" + staffsId, {
                    id: staffsId
                    
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
</style>
