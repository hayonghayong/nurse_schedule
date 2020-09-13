<template>
    <v-app>
        <!-- ヘッダーコンポーネント読み込み -->
        <header-component v-if="$route.name !== 'SelectRole'"></header-component>
        <main>
            <!-- VueRouter読み込み -->
            <router-view></router-view>
        </main>
        <!-- フッターコンポーネント読み込み -->
        <footer-component v-if="$route.name !== 'SelectRole' && $route.name !== 'SelectStaff' && $route.name !== 'SelectPatients'"></footer-component>

    </v-app>
</template>

<script>
import HeaderComponent from "./items/HeaderComponent.vue";
import FooterComponent from "./items/FooterComponent.vue";

// 全ページ共通のコンポーネント読み込み
export default {
    components: {
        HeaderComponent,
        FooterComponent
    }
};
</script>


<style>
/* 全てのファイルにかけるCSS */
</style>