<template>
    <!-- 仮オブジェクト -->
    <div>
        <h1>【スタッフ】患者選択</h1>
    <v-stepper value="1">
        <v-stepper-header>
            <v-stepper-step step="1">Select campaign settings</v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="2">Create an ad group</v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="3">Create an ad</v-stepper-step>
        </v-stepper-header>
    </v-stepper>
    </div>
    <!-- ここまで -->
</template>
<script>
// コンポーネントのインポート

// Vue
export default {
    components: {},
    data: () => ({}),
    created() {},
    methods: {}
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>