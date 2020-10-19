<template>
<!-- 仮フッター -->
    <v-bottom-navigation
    grow
    color="blue lighten-1"
    fixed absolute
  >
    <v-btn :to="{ name: 'ScheduleList',params:{team_id:this.$route.params.team_id} }">
      <span>スタッフスケジュール</span>
      <v-icon>mdi-history</v-icon>
    </v-btn>

    <v-btn :to="{ name: 'TreatmentList' ,params:{team_id:this.$route.params.team_id}}">
      <span>処置一覧</span>
      <v-icon>mdi-account-group</v-icon>
    </v-btn>

    <v-btn :to="{ name: 'PatientsList' ,params:{team_id:this.$route.params.team_id}}">
      <span>患者一覧</span>
      <v-icon>mdi-account-group</v-icon>
    </v-btn>

  </v-bottom-navigation>
</template>
<script>
export default {
    components: {},
    data: () => ({bottomNav: 'recent'}),
    created() {},
    computed: {},
    methods: {}
};
</script>

<style lang="scss" scoped>
/* スコープ付きのスタイル */
</style>
