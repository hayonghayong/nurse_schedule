<template>
<!-- 仮フッター -->
    <v-bottom-navigation
    :value="activeBtn"
    grow
    color="teal"
  >
    <v-btn>
      <span>スケジュール</span>
      <v-icon>mdi-history</v-icon>
    </v-btn>

    <v-btn>
      <span>予定編集</span>
      <v-icon>mdi-pen</v-icon>
    </v-btn>

    <v-btn>
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
