import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

// ▼ページコンポーネントのインポート
// スタッフページ
import SelectRole from "./components/pages/staff/SelectRole.vue";
import SelectPatients from "./components/pages/staff/SelectPatients.vue";
import RegistSchedule from "./components/pages/staff/RegistSchedule.vue";
import RegistTreatmentSchedule from "./components/pages/staff/RegistTreatmentSchedule.vue";
import ScheduleDetail from "./components/pages/staff/ScheduleDetail.vue";
import StaffSchedule from "./components/pages/staff/StaffSchedule.vue";
// リーダーページ
import SelectStaff from "./components/pages/leader/SelectStaff.vue";
import ScheduleList from "./components/pages/leader/ScheduleList.vue";
import StaffScheduleDetail from "./components/pages/leader/StaffScheduleDetail.vue";
import EditStaffSchedule from "./components/pages/leader/EditStaffSchedule.vue";
import PatientsList from "./components/pages/leader/PatientsList.vue";
import EditPatient from "./components/pages/leader/EditPatient.vue";
import RegistPatient from "./components/pages/leader/RegistPatient.vue";
// 管理者ページ
import Setting from "./components/pages/admin/Setting.vue";
import StaffList from "./components/pages/admin/StaffList.vue";
import RegistStaff from "./components/pages/admin/RegistStaff.vue";
import EditStaff from "./components/pages/admin/EditStaff.vue";
// ▲ページコンポーネントのインポート


// ▼ルーティング１１
const routes = [
    // スタッフページ：6
    {
        path: "/staff/select-role",
        component: SelectRole,
        name: "SelectRole"
    },
    {
        path: "/staff/select-patients",
        component: SelectPatients,
        name: "SelectPatients"
    },
    {
        path: "/staff/regist-treatment-schedule",
        component: RegistTreatmentSchedule,
        name: "RegistTreatmentSchedule"
    },
    {
        path: "/staff/regist-schedule",
        component: RegistSchedule,
        name: "RegistSchedule"
    },
    {
        path: "/staff/schedule-detail",
        component: ScheduleDetail,
        name: "ScheduleDetail"
    },
    {
        path: "/staff/staff-schedule",
        component: StaffSchedule,
        name: "StaffSchedule"
    },
    // リーダーページ：7
    {
        path: "/leader/select-staff",
        component: SelectStaff,
        name: "SelectStaff"
    },
    {
        path: "/leader/schedule-list",
        component: ScheduleList,
        name: "ScheduleList"
    },

    {
        path: "/leader/staff-schedule-detail",
        component: StaffScheduleDetail,
        name: "StaffScheduleDetail"
    },
    {
        path: "/leader/edit-staff-schedule",
        component: EditStaffSchedule,
        name: "EditStaffSchedule"
    },
    {
        path: "/leader/patients-list",
        component: PatientsList,
        name: "PatientsList"
    },
    {
        path: "/leader/regist-patient",
        component: RegistPatient,
        name: "RegistPatient"
    },
    {
        path: "/leader/edit-patient",
        component: EditPatient,
        name: "EditPatient"
    },
    // 管理者ページ：4
    {
        path: "/admin/setting",
        component: Setting,
        name: "Setting"
    },
    {
        path: "/admin/staff-list",
        component: StaffList,
        name: "StaffList"
    },
    {
        path: "/admin/regist-staff",
        component: RegistStaff,
        name: "RegistStaff"
    },
    {
        path: "/admin/edit-staff",
        component: EditStaff,
        name: "EditStaff"
    }
];
// ▲ルーティング

const router = new VueRouter({
  mode: "history",
  base: process.env.baseUrl,
  routes
});

// VueRouterインスタンスを作成してエクスポート
export default router;
