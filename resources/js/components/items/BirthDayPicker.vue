<template>
    <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        min-width="290px"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                icon
                color="#62ABF8"
                dark
                elevation="0"
                v-on="on"
                v-bind="attrs"
            >
                <v-icon>mdi-calendar</v-icon>
            </v-btn>
        </template>
        <v-date-picker
            v-model="picker"
            ref="picker"
            :max="new Date().toISOString().substr(0, 10)"
            min="1900-01-01"
            locale="ja-jp"
            :day-format="jpvDayFormat"
            header-color="#62ABF8"
        ></v-date-picker>
    </v-menu>
</template>

<script>
export default {
    value: {
        type: String,
        default: new Date().toISOString().substr(0, 10)
    },
    data: () => ({
        menu: false
    }),
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        }
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
