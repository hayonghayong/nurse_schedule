import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

// ▼ページコンポーネントのインポート
// 管理者ページ
import Setting from "./components/pages/admin/Setting.vue";
import StaffList from "./components/pages/admin/StaffList.vue";
import RegistStaff from "./components/pages/admin/RegistStaff.vue";
import EditStaff from "./components/pages/admin/EditStaff.vue";
// ▲ページコンポーネントのインポート

// ▼ルーティング１１
const routes = [
    // 管理者ページ：4
    {
        path: "/",
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
        path: "/admin/edit-staff/:user_id",
        component: EditStaff,
        name: "EditStaff"
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
