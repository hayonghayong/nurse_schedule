<template>
    <div>
        <v-row>
            <v-col>
                <v-sheet height="700">
                    <v-calendar
                        ref="calendar"
                        v-model="focus"
                        color="primary"
                        :events="events"
                        :event-color="getEventColor"
                        :event-ripple="false"
                        type="day"
                        @click:event="showEvent"
                    >
                        <!-- nowライン設定 -->
                        <template #day-body="{ date, week }">
                            <div
                                class="v-current-time"
                                :class="{ first: date === week[0].date }"
                                :style="{ top: nowY }"
                            ></div>
                        </template>
                        <!-- nowライン設定ここまで -->
                    </v-calendar>
                </v-sheet>
            </v-col>
        </v-row>
        <!-- クリック時に開く詳細画面 -->
        <v-card
            v-if="selectedOpen"
            min-width="350px"
            flat
            class="detail-schedule"
        >
            <v-card-text>
                <p>{{ selectedEvent.room }}</p>
                <p>{{ selectedEvent.patient }}</p>
                <p>{{ selectedEvent.treatment }}</p>
                <MomentJs :time="selectedEvent.start" />
            </v-card-text>
            <v-card-actions>
                <v-btn text color="secondary" @click="selectedOpen = false">
                    閉じる
                </v-btn>
            </v-card-actions>
        </v-card>
        <!-- クリック時に開く詳細画面 ここまで-->
    </div>
    <!-- ここまで -->
</template>
<script>
import MomentJs from "../../items/MomentJs";
// Vue
export default {
    components: {
        MomentJs
    },
    data: () => ({
        schedules: [],
        // ▼カレンダー関連
        //   nowライン
        value: "",
        ready: false,
        // スケジュールを格納
        events: [],
        focus: "",
        colors: [
            "blue",
            "indigo",
            "deep-purple",
            "cyan",
            "green",
            "orange",
            "grey darken-1"
        ],
        // スケジュール詳細
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false
    }),
    computed: {
        cal() {
            return this.ready ? this.$refs.calendar : null;
        },
        nowY() {
            return this.cal
                ? this.cal.timeToY(this.cal.times.now) + "px"
                : "-10px";
        }
    },
    mounted() {
        //   nowライン
        this.ready = true;
        this.scrollToTime();
        this.updateTime();
    },
    methods: {
        fetchSchedule: function() {
            axios
                .get("/api/tasks/get/all")
                .then(res => {
                    console.log("status:", res.status);
                    console.log("body:", res.data);
                    this.schedules = res.data;
                    this.fetchEvents();
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
        // ------------ ▼nowライン ---------- //
        getCurrentTime() {
            return this.cal
                ? this.cal.times.now.hour * 60 + this.cal.times.now.minute
                : 0;
        },
        scrollToTime() {
            const time = this.getCurrentTime();
            const first = Math.max(0, time - (time % 30) - 30);

            this.cal.scrollToTime(first);
        },
        updateTime() {
            setInterval(() => this.cal.updateTimes(), 60 * 1000);
        }, // イベント登録
        // ------------ nowラインここまで ---------- //
        // ------------ イベントの生成 ---------- //
        fetchEvents() {
            const getEventsData = [];
            const eventCount = this.schedules.length;
            for (let i = 0; i < eventCount; i++) {
                // 開始時間と終了時刻の定義
                const startdate = new Date(this.schedules[i].start_date);
                const requiredTime = this.schedules[i].treatment.time_required;
                const addition_time = requiredTime * 60 * 1000;
                const endTime = startdate.getTime() + addition_time;
                // イベントにpush
                getEventsData.push({
                    name:
                        this.schedules[i].patient.name +
                        " / " +
                        this.schedules[i].treatment.name, // 処置の名前
                    start: this.schedules[i].start_date, // 開始時刻
                    end: endTime, // 終了時刻
                    color: this.colors[i],
                    timed: true,
                    id: this.schedules[i].id,
                    room: this.schedules[i].patient.room,
                    treatment: this.schedules[i].treatment.name,
                    patient: this.schedules[i].patient.name
                });
            }
            this.events = getEventsData;
        },
        getEventColor(event) {
            return event.color;
        },
        // ------------ イベントの生成ここまで ---------- //
        // ------------ クリックしたときの詳細画面 ---------- //
        showEvent({ nativeEvent, event }) {
            const open = () => {
                this.selectedEvent = event;
                this.selectedElement = nativeEvent.target;
                console.log(event);

                setTimeout(() => (this.selectedOpen = true), 10);
            };

            if (this.selectedOpen) {
                this.selectedOpen = false;
                setTimeout(open, 10);
            } else {
                open();
            }

            nativeEvent.stopPropagation();
        }
        // ------------ クリックしたときの詳細画面　ここまで ---------- //
    },
    created() {
        this.fetchSchedule();
    }
};
</script>

<style lang="scss" scoped>
body {
    box-sizing: border-box;
}
/* スコープ付きのスタイル */
/* nowラインのスタイル */
.v-current-time {
    height: 2px;
    background-color: #ea4335;
    position: absolute;
    left: -1px;
    right: 0;
    pointer-events: none;

    &.first::before {
        content: "";
        position: absolute;
        background-color: #ea4335;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-top: -5px;
        margin-left: -6.5px;
    }
}
/* nowラインのスタイル　ここまで */
/* スケジュール詳細のスタイル */
.detail-schedule {
    position: fixed;
    bottom: 56px;
    left: 0;
    right: 0;
    width: 100%;
    height: 250px;
    z-index: 5;
    background: #fff;
}
/* スケジュール詳細のスタイル　ここまで */
</style>
