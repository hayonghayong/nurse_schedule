import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";

Vue.use(VueRouter);

// ▼ページコンポーネントのインポート

// スタッフページ
import SelectRole from "./components/pages/staff/SelectRole.vue";
import SelectPatients from "./components/pages/staff/SelectPatients.vue";
import RegistSchedule from "./components/pages/staff/RegistSchedule.vue";
import RegistTreatmentSchedule from "./components/pages/staff/RegistTreatmentSchedule.vue";
import StaffSchedule from "./components/pages/staff/StaffSchedule.vue";
import PatientSchedule from "./components/pages/staff/PatientSchedule.vue";

// リーダーページ
import SelectStaff from "./components/pages/leader/SelectStaff.vue";
import ScheduleList from "./components/pages/leader/ScheduleList.vue";
import PatientsList from "./components/pages/leader/PatientsList.vue";
import EditPatient from "./components/pages/leader/EditPatient.vue";
import RegistPatient from "./components/pages/leader/RegistPatient.vue";
import RegistTreatment from "./components/pages/leader/RegistTreatment.vue";
import TreatmentList from "./components/pages/leader/TreatmentList.vue";
import EditTreatment from "./components/pages/leader/EditTreatment.vue";
import UpdateUsersPatients from "./components/pages/leader/UpdateUsersPatients.vue";
// ▲ページコンポーネントのインポート

// ▼ルーティング１１
const routes = [
    // スタッフページ：7
    {
        path: "/",
        component: SelectRole,
        name: "SelectRole",
        meta: { title: "役割選択" }
    },
    {
        path: "/staff/select-patients/:schedule_id",
        component: SelectPatients,
        name: "SelectPatients",
        meta: { title: "患者選択" }
    },
    {
        path: "/staff/regist-treatment-schedule/:schedule_id",
        component: RegistTreatmentSchedule,
        name: "RegistTreatmentSchedule",
        meta: { title: "処置選択" }
    },
    {
        path: "/staff/regist-schedule/:schedule_id",
        component: RegistSchedule,
        name: "RegistSchedule",
        meta: { title: "スケジュール調整" }
    },
    {
        path: "/staff/staff-schedule/:schedule_id",
        component: StaffSchedule,
        name: "StaffSchedule",
        meta: { title: "スケジュール" }
    },
    {
        path: "/staff/patient-schedule/:schedule_id",
        component: PatientSchedule,
        name: "PatientSchedule",
        meta: { title: "患者別スケジュール" }
    },

    // リーダーページ：10
    {
        path: "/leader/select-staff/:team_id",
        component: SelectStaff,
        name: "SelectStaff",
        meta: { title: "スタッフ選択" }
    },
    {
        path: "/leader/schedule-list/:team_id",
        component: ScheduleList,
        name: "ScheduleList",
        meta: { title: "スタッフスケジュール" }
    },
    {
        path: "/leader/patients-list",
        component: PatientsList,
        name: "PatientsList",
        meta: { title: "患者一覧" }
    },
    {
        path: "/leader/regist-patient",
        component: RegistPatient,
        name: "RegistPatient",
        meta: { title: "患者登録" }
    },
    {
        path: "/leader/edit-patient/:patientId",
        component: EditPatient,
        name: "EditPatient",
        meta: { title: "患者詳細情報" }
    },
    {
        path: "/leader/edit-treatment/:treatmentId",
        component: EditTreatment,
        name: "EditTreatment",
        meta: { title: "処置編集" }
    },
    {
        path: "/leader/regist-treatment",
        component: RegistTreatment,
        name: "RegistTreatment",
        meta: { title: "処置登録" }
    },
    {
        path: "/leader/treatment-list",
        component: TreatmentList,
        name: "TreatmentList",
        meta: { title: "処置一覧" }
    },
    {
        path: "/staff/update-users-patients/:team_id",
        component: UpdateUsersPatients,
        name: "UpdateUsersPatients",
        meta: { title: "担当患者引継ぎ" }
    }
];
// ▲ルーティング

const router = new VueRouter({
    mode: "hash",
    base: process.env.baseUrl,
    routes
});

// VueRouterインスタンスを作成してエクスポート
export default router;

router.afterEach((to, from) => {
    // console.log('呼ばれたよ!')
    // console.log(to.meta.title);
    if (to.meta && to.meta.title) {
        store.dispatch("common/changePage", to.meta.title);
    }
});
