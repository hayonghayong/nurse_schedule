<template>
<!-- 仮フッター -->
    <v-bottom-navigation
    grow
    color="blue lighten-1"
    fixed absolute
  >
    <v-btn :to="{ name: 'StaffSchedule' }">
      <span>スケジュール</span>
      <v-icon>mdi-history</v-icon>
    </v-btn>

    <v-btn :to="{ name: 'PatientSchedule' }">
      <span>患者別スケジュール</span>
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
