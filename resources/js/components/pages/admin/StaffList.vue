<template>
    <!-- 仮オブジェクト -->
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【管理者】スタッフ一覧</v-list-item-title>
                <ul>
                    <li v-for="staff in staffs" v-bind:key="staff.id">
                        <router-link 
                            :to="{
                                name:'EditStaff',
                                params:{
                                    user_id:staff.id
                                }
                            }"
                        >
                            {{ staff.name }}
                        </router-link>
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
                .get("/api/users/get/all")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.staffs = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
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
