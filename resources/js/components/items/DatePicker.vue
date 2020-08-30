<template>
    <v-menu
        v-model="menu"
        offset-y
        :close-on-content-click="false"
        min-width="290px"
    >
        <template v-slot:activator="{ on }">
            <v-btn icon color="#62ABF8" dark elevation="0" v-on="on">
                <v-icon>mdi-calendar</v-icon>
            </v-btn>
        </template>
        <v-date-picker
            v-model="picker"
            scrollable
            header-color="#62ABF8"
            locale="ja-jp"
            :day-format="jpvDayFormat"
        >
            <v-spacer></v-spacer>
            <!-- <v-btn text color="#62ABF8" @click="menu = false">決定</v-btn> -->
        </v-date-picker>
    </v-menu>
</template>
<script>
export default {
    props: {
        value: {
            type: String,
            default: new Date().toISOString().substr(0, 10)
        }
    },
    data() {
        return {
            menu: false
        };
    },
    computed: {
        picker: {
            get() {
                return this.value;
            },
            set(val) {
                this.menu = false;
                this.$emit("input", val);
            }
        }
    },
    methods: {
        //月選択ボタンを年度の見た目にするfunction
        jpvDayFormat(str) {
            // realYMD → YYYY-MM-DD
            if (str === "") return str;
            let d = parseInt(str.split("-")[2]);
            return d;
        }
    }
};
</script>
