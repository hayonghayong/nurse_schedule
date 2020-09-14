<template> 
    <!-- 仮オブジェクト -->
    <v-card>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>【スタッフ】処置スケジュール一覧</v-list-item-title>
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
      schedules:[],
    }),
    methods: {
      fetchSchedule: function() {
            axios
                .get("/api/schedules/get/all")
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
      this.fetchSchedule();
    },
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
