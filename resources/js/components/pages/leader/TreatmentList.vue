<template>
    <v-container class="treatmentsLists">
        <v-list subheader>
            <v-subheader>処置一覧</v-subheader>
            <div v-for="(treatment, index) in treatments" :key="treatment.id">
                <v-list-item
                    class="px-8"
                    :to="{
                        name: 'EditTreatment',
                        params: { treatmentId: treatment.id }
                    }"
                >
                    <v-list-item-avatar>
                        <v-icon class="ma-2 mdi-36px" color="#62ABF8"
                            >mdi-hospital-box-outline</v-icon
                        >
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>{{
                            treatment.name
                        }}</v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-icon>
                        <v-btn icon color="pink">
                            <v-icon
                                class="ma-2"
                                outlined
                                color="#6c6c6c"
                                @click="Edit(treatment.id)"
                                >mdi-pencil</v-icon
                            >
                        </v-btn>
                        <v-btn icon color="pink">
                            <v-icon
                                class="ma-2"
                                outlined
                                color="#6c6c6c"
                                @click.prevent="Delete(treatment.id)"
                                >mdi-delete</v-icon
                            >
                        </v-btn>
                    </v-list-item-icon>
                </v-list-item>
                <v-divider
                    v-if="index + 1 < treatments.length"
                    :key="index"
                ></v-divider>
            </div>
        </v-list>
    </v-container>
</template>
<script>
// Vue
export default {
    components: {},
    data: () => ({
        treatments: [],
        editTreatment: {
            name: "",
            time_required: "",
            required_flg: ""
        }
    }),
    created() {
        this.fetchTreatment();
    },
    methods: {
        fetchTreatment: function() {
            axios
                .get("/api/treatments/get/all")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.treatments = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
        //処置削除
        Delete: function(treatmentId) {
            if (confirm("削除してよろしいでしょうか?"))
                axios
                    .delete("/api/treatments/delete", {
                        data: { id: treatmentId }
                    })
                    .then(res => {
                        console.log("status:", res.status);
                        console.log("body:", res.data);
                        this.treatments = res.data;
                    })
                    .catch(err => {
                        console.log("err:", err);
                    });
        }
    }
};
</script>

<style scoped>
/* スコープ付きのスタイル */
</style>
