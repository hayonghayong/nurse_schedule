<template>
<!-- 仮フッター -->
    <v-bottom-navigation
    grow
    color="blue lighten-1"
    fixed
  >
    <v-btn :to="{ name: 'StaffSchedule' }">
      <span>スケジュール</span>
      <v-icon>mdi-history</v-icon>
    </v-btn>

    <v-btn :to="{ name: 'ScheduleDetail' }">
      <span>予定編集</span>
      <v-icon>mdi-pen</v-icon>
    </v-btn>

    <v-btn :to="{ name: 'SelectRole' }">
      <span>患者一覧</span>
      <v-icon>mdi-account-group</v-icon>
    </v-btn>
  </v-bottom-navigation>
</template>
<script>
export default {
    components: {},
    data: () => ({bottomNav: 'recent',}),
    created() {},
    computed: {},
    methods: {}
};
</script>

<style lang="scss" scoped>
/* スコープ付きのスタイル */

</style>
