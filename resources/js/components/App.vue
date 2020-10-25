<template>
    <v-app>
        <!-- ヘッダーコンポーネント読み込み -->
        <header-component v-if="$route.name !== 'SelectRole'"></header-component>
        <main>
            <!-- VueRouter読み込み -->
            <router-view></router-view>
        </main>
        <!-- フッターコンポーネント読み込み -->
        <footer-component v-if="$route.name !== 'SelectRole' && $route.name !== 'SelectStaff' && $route.name !== 'SelectPatients' 
                             && $route.name !== 'RegistSchedule' && $route.name !== 'RegistTreatmentSchedule' && $route.name !== 'LogoutCheck' && $route.name !== 'LogoutCheck'"></footer-component>
        <leader-footer-component v-if="$route.name !== 'SelectRole' && $route.name !== 'SelectStaff' && $route.name !== 'SelectPatients' 
                             && $route.name !== 'RegistSchedule' && $route.name !== 'RegistTreatmentSchedule' && $route.name !== 'StaffSchedule'
                              && $route.name !== 'PatientSchedule' && $route.name !== 'SelectStaff' && $route.name !== 'LogoutCheck'"></leader-footer-component>

    </v-app>
</template>

<script>
import HeaderComponent from "./items/HeaderComponent.vue";
import FooterComponent from "./items/FooterComponent.vue";
import LeaderFooterComponent from "./items/LeaderFooterComponent.vue";


// 全ページ共通のコンポーネント読み込み
export default {
    components: {
        HeaderComponent,
        FooterComponent,
        LeaderFooterComponent
    }
};
</script>


<style>
/* 全てのファイルにかけるCSS */
@media only screen and (max-width: 959px){
.v-stepper:not(.v-stepper--vertical) .v-stepper__label {
    display: flex;
}
}
.v-stepper__label{
    font-size:8px;
}
.vue__time-picker input.display-time,.vue__time-picker{
  width: 6em;}

.v-application--is-ltr .v-stepper--vertical .v-stepper__step__step{
    margin-right:0px;
}
.vue-swatches__wrapper{
  width:300px;
}
.vue-swatches__swatch{
  margin-right:11px;
}

/* カレンダーの日付を非表示 */
/* .v-calendar-daily_head-weekday {
  display: none;
}
.v-calendar-daily_head-day-label {
  display: none;
} */

/* カレンダーのカテゴリーサイズ調整 */
/* .v-calendar-category__column {
  flex-shrink: 0 !important;
  width: 200px !important;
}
.v-calendar-category__column-header {
  flex-shrink: 0 !important;
  width: 200px !important;
} */

</style>