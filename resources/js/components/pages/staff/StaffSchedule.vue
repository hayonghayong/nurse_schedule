<template>
    <div>
        <v-row class="fill-height">
            <v-col>
                <v-sheet height="64">
                    <v-toolbar flat color="white">
                        <v-btn
                            outlined
                            class="mr-4"
                            color="grey darken-2"
                            @click="setToday"
                            >Today</v-btn
                        >
                        <v-btn
                            fab
                            text
                            small
                            color="grey darken-2"
                            @click="prev"
                        >
                            <v-icon small>mdi-chevron-left</v-icon>
                        </v-btn>
                        <v-btn
                            fab
                            text
                            small
                            color="grey darken-2"
                            @click="next"
                        >
                            <v-icon small>mdi-chevron-right</v-icon>
                        </v-btn>
                        <v-toolbar-title v-if="$refs.calendar">{{
                            $refs.calendar.title
                        }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                </v-sheet>
                <v-sheet height="700">
                    <v-calendar
                        ref="calendar"
                        v-model="focus"
                        color="primary"
                        :events="events"
                        :event-color="getEventColor"
                        :event-ripple="false"
                        interval-height="80px"
                        type="day"
                        @mousedown:event="startDrag"
                        @touchstart:event="startDrag"
                        @mousedown:time="startTime"
                        @touchstart:time="startTime"
                        @mousemove:time="mouseMove"
                        @touchmove:time="mouseMove"
                        @mouseup:time="endDrag"
                        @touchendup:time="endDrag"
                        @mouseleave.native="cancelDrag"
                        @touchleave.native="cancelDrag"
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
                        <!-- ドラック&ドロップ設定 -->
                        <template #event="{ event, timed, eventSummary}">
                            <div
                                class="v-event-draggable"
                                v-html="eventSummary()"
                            ></div>
                            <!-- <div
                                v-if="timed"
                                class="v-event-drag-bottom"
                                @mousedown.stop="extendBottom(event)"
                            ></div> -->
                        </template>
                        <!-- ドラック&ドロップ設定ここまで -->
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
            <v-card-actions>
                <v-btn
                    text
                    color="#62ABF8"
                    class="mx-auto"
                    @click="selectedOpen = false"
                >
                    <v-icon class="ma-2 mdi-36px" color="#62ABF8"
                        >mdi-chevron-down</v-icon
                    >
                </v-btn>
            </v-card-actions>
            <v-card-text class="py-0 pl-8">
                <div class="d-flex mb-2 body-1 font-weight-bold cardTextTime">
                    <MomentJsTime
                        class="cardTextTime"
                        :time="selectedEvent.start_date"
                    /><span class="cardTextTime"> 〜 </span>
                </div>
                <p class="mb-2 body-1">
                    {{ selectedEvent.room }}号室 /
                    {{ selectedEvent.patient }}さん
                </p>
                <p class="mb-2 body-1">{{ selectedEvent.treatment }}</p>
                <div v-if="timepicker_show == true" class="mb-2">
                    <span class="body-2 mr-4">変更後時間</span>
                    <vue-timepicker
                        v-if="(timepicker_show = true)"
                        :minute-interval="10"
                        v-model="selectedEvent.update_time"
                        id="start_time"
                        name="startTime"
                        placeholder="開始時間"
                        hour-label="時"
                        minute-label="分"
                        input-class="form-control"
                    ></vue-timepicker>
                </div>
            </v-card-text>
            <v-card-actions class="flex-column">
                <v-btn
                    v-if="
                        selectedEvent.end_flg == null &&
                            timepicker_show == false
                    "
                    rounded
                    dark
                    color="#EF9C38"
                    class="mx-auto px-6 mb-3"
                    @click="saveEndFlag(selectedEvent.id)"
                >
                    処置完了
                </v-btn>
                <v-btn
                    v-else-if="
                        selectedEvent.end_flg == 1 && timepicker_show == false
                    "
                    rounded
                    dark
                    color="#c3c3c3"
                    class="mx-auto px-6 mb-3"
                    @click="saveEndFlag(selectedEvent.id)"
                >
                    未完了に変更
                </v-btn>
                <v-btn
                    v-if="timepicker_show == false"
                    rounded
                    dark
                    color="#62ABF8"
                    class="mx-auto px-6"
                    @click="timepicker_show = true"
                >
                    時間変更
                </v-btn>
                <v-btn
                    v-else
                    rounded
                    dark
                    color="#62ABF8"
                    class="mx-auto px-6"
                    @click="updateSchedule()"
                >
                    変更を保存
                </v-btn>
            </v-card-actions>
        </v-card>
        <!-- クリック時に開く詳細画面 ここまで-->
    </div>
    <!-- ここまで -->
</template>
<script>
import MomentJs from "../../items/MomentJs";
import MomentJsTime from "../../items/MomentJsTIme";
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";

// Vue
export default {
    components: {
        MomentJs,
        MomentJsTime,
        "vue-timepicker": VueTimepicker
    },
    data: () => ({
        schedules: [],
        postScheduleData: "", //postするスケジュールデータを格納
        today: "",
        // ▼カレンダー関連
        //   nowライン
        value: "",
        ready: false,
        // Drag and Drop
        dragEvent: null,
        dragStart: null,
        createEvent: null,
        createStart: null,
        extendOriginal: null,
        // selectedStaff: "",
        // スケジュールを格納
        events: [], //ここを表示
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
        selectedOpen: false,
        timepicker_show: false
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
        this.setToday();
        //   nowライン
        this.ready = true;
        this.scrollToTime();
        this.updateTime();
        //   予定
        this.$refs.calendar.checkChange();
    },
    methods: {
        // 【API】スケジュールを取得
        fetchSchedule: function() {
            axios
                .get("/api/tasks/get/all/1")
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
        // 【API】スケジュール登録更新
        updateSchedule: function() {
            this.postScheduleData = this.selectedEvent;
            // 時刻の整形
            const setTime = this.postScheduleData.update_time;
            if (setTime.HH && setTime.mm) {
                const startTime =
                    this.today + " " + setTime.HH + ":" + setTime.mm + ":00";
                this.postScheduleData.start_date = startTime;
            } else {
                const startTime = this.today;
                this.postScheduleData.start_date = startTime;
            }
            const schedule_id = this.postScheduleData.id;
            this.timepicker_show = false;
            axios
                .post(
                    "/api/schedules/update/" + schedule_id,
                    this.postScheduleData
                )
                .then(res => {
                    // 描画し直し
                    this.fetchSchedule();
                })
                .catch(err => {
                    console.log("err:", err.response.data);
                });
        },
        // DB保存用に日付を整形
        setDatetime: function() {
            var today = new Date();
            var year = today.getFullYear();
            var month = today.getMonth() + 1;
            var week = today.getDay();
            var day = today.getDate();
            if (month < 10) {
                month = "0" + month;
            }
            if (day < 10) {
                day = "0" + day;
            }
            return (this.today = year + "-" + month + "-" + day);
        },

        // ---------- スケジュール表示関連 ---------- //
        // ▼イベント取得&表示
        // ▼nowライン表示
        // ▼ドラック&ドロップ機能
        // --------------------------------------- //

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

        // ------------ ▼イベント取得&表示 ---------- //
        setToday() {
            this.focus = "";
        },
        setToday() {
            this.focus = "";
        },
        prev() {
            this.$refs.calendar.prev();
        },
        next() {
            this.$refs.calendar.next();
        },
        fetchEvents() {
            const getEventsData = [];
            const eventCount = this.schedules.length;
            for (let i = 0; i < eventCount; i++) {
                // 開始時間と終了時刻の定義
                const startdate = new Date(this.schedules[i].start_date);
                const unixStartdate = startdate.getTime();
                const requiredTime = this.schedules[i].treatment.time_required;
                const addition_time = requiredTime * 60 * 1000;
                const endTime = unixStartdate + addition_time;
                const endFlag = this.schedules[i].end_flg;
                const endFlagData = "";
                // 完了しているかでタスクの色を変更
                if (endFlag == null) {
                    endFlagData = "blue";
                } else if (endFlag == 1) {
                    endFlagData = "grey darken-1";
                }
                // イベントにpush
                getEventsData.push({
                    name:
                        this.schedules[i].patient.name +
                        " / " +
                        this.schedules[i].treatment.name, // 処置の名前
                    start: unixStartdate, // 開始時刻
                    // start: this.schedules[i].start_date, // 開始時刻
                    end: endTime, // 終了時刻(UNIX型)
                    color: endFlagData, // end_flgで判定した色
                    timed: true,
                    id: this.schedules[i].id,
                    room: this.schedules[i].patient.room,
                    treatment: this.schedules[i].treatment.name,
                    patient: this.schedules[i].patient.name,
                    end_flg: this.schedules[i].end_flg
                });
            }
            this.events = getEventsData;
        },
        getEventColor(event) {
            return event.color;
        },
        // ------------ イベントの生成ここまで ---------- //

        // ------------ ▼Drag and Drop ---------- //
        startDrag({ event, timed }) {
            if (event && timed) {
                this.dragEvent = event;
                this.dragTime = null;
                this.extendOriginal = null;
                this.selectedEvent = event;
            }
        },
        startTime(tms) {
            const mouse = this.toTime(tms);
            console.log(mouse);
            if (this.dragEvent && this.dragTime === null) {
                const start = this.dragEvent.start;

                this.dragTime = mouse - start;
            } else {
                // イベント追加
                this.createStart = this.roundTime(mouse);
                this.createEvent = {
                    name: `Event`,
                    color: this.rndElement(this.colors),
                    start: this.createStart,
                    end: this.createStart,
                    timed: true
                };
                this.events.push(this.createEvent);
            }
        },
        // イベントを伸ばした後の処理
        extendBottom(event) {
            this.createEvent = event;
            this.createStart = event.start;
            this.extendOriginal = event.end;
        },
        mouseMove(tms) {
            const mouse = this.toTime(tms);
            // イベントドラッグ中
            if (this.dragEvent && this.dragTime !== null) {
                const start = new Date(this.dragEvent.start);
                const toStart = start.getTime();
                const end = this.dragEvent.end;
                const duration = end - start;
                const newStartTime = mouse - this.dragTime;
                const newStart = this.roundTime(newStartTime);
                const newEnd = newStart + duration;
                this.dragEvent.start = newStart;
                this.dragEvent.end = newEnd;
            }
            // イベント作成中
            else if (this.createEvent && this.createStart !== null) {
                const mouseRounded = this.roundTime(mouse, false);
                const min = Math.min(mouseRounded, this.createStart);
                const max = Math.max(mouseRounded, this.createStart);

                this.createEvent.start = min;
                this.createEvent.end = max;
            }
        },
        endDrag() {
            const update_time = new Date(this.selectedEvent.start);
            const hour = update_time
                .getHours()
                .toString()
                .padStart(2, "0");
            const minutes = update_time
                .getMinutes()
                .toString()
                .padStart(2, "0");
            this.selectedEvent.update_time = {
                HH: hour,
                mm: minutes
            };
            // 更新
            this.updateSchedule();

            // 初期化
            this.dragTime = null;
            this.dragEvent = null;
            this.createEvent = null;
            this.createStart = null;
            this.extendOriginal = null;
        },
        cancelDrag() {
            if (this.createEvent) {
                if (this.extendOriginal) {
                    this.createEvent.end = this.extendOriginal;
                } else {
                    const i = this.events.indexOf(this.createEvent);
                    if (i !== -1) {
                        this.events.splice(i, 1);
                    }
                }
            }

            this.createEvent = null;
            this.createStart = null;
            this.dragTime = null;
            this.dragEvent = null;
        },
        roundTime(time, down = true) {
            const roundTo = 15; // minutes
            const roundDownTime = roundTo * 60 * 1000;

            return down
                ? time - (time % roundDownTime)
                : time + (roundDownTime - (time % roundDownTime));
        },
        toTime(tms) {
            return new Date(
                tms.year,
                tms.month - 1,
                tms.day,
                tms.hour,
                tms.minute
            ).getTime();
        },
        rnd(a, b) {
            return Math.floor((b - a + 1) * Math.random()) + a;
        },
        rndElement(arr) {
            return arr[this.rnd(0, arr.length - 1)];
        },
        // ------------ Drag and Dropここまで ---------- //

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
        },
        // end_flgの更新（独立したAPIを使用する場合）
        // saveEndFlag(schedule_id) {
        //     axios
        //         .post("/api/schedules/endflag/" + schedule_id)
        //         .then(res => {
        //             // 描画し直し
        //             this.fetchSchedule();
        //         })
        //         .catch(err => {
        //             console.log("err:", err.response.data);
        //         });
        // }
        // end_flgの更新（ /api/schedules/update/ APIを使用する場合）
        saveEndFlag(schedule_id) {
            const updateSchedule = this.selectedEvent;
            if (updateSchedule.end_flag == null) {
                updateSchedule.end_flag = 1;
                this.selectedEvent.end_flg = 1;
            } else if (updateSchedule.end_flag == 1) {
                updateSchedule.end_flag = null;
                this.selectedEvent.end_flg = null;
            }
            axios
                .post("/api/schedules/update/" + schedule_id)
                .then(res => {
                    // 描画し直し
                    this.fetchSchedule();
                })
                .catch(err => {
                    console.log("err:", err.response.data);
                });
        }
        // ------------ クリックしたときの詳細画面　ここまで ---------- //
    },
    created() {
        this.fetchSchedule();
        this.setDatetime();
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

/* Drag and Drop  */
.v-event-draggable {
    padding-left: 6px;
}

.v-event-timed {
    user-select: none;
    -webkit-user-select: none;
}
// .test {
//     position: relative;
// }

.v-event-drag-bottom {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 4px;
    height: 4px;
    cursor: ns-resize;

    &::after {
        display: none;
        position: absolute;
        left: 50%;
        height: 4px;
        border-top: 1px solid white;
        border-bottom: 1px solid white;
        width: 16px;
        margin-left: -8px;
        opacity: 0.8;
        content: "";
    }

    &:hover::after {
        display: block;
    }
}
/* Drag and Drop　ここまで */

/* スケジュール詳細のスタイル */
.cardTextTime {
    font-size: 20px;
}
@keyframes slideup {
    0% {
        opacity: 0;
        transform: translateY(64px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.detail-schedule {
    position: fixed;
    bottom: 56px;
    left: 0;
    right: 0;
    width: 100%;
    height: 250px;
    z-index: 5;
    background: #fff;
    animation-name: slideup;
    animation-duration: 0.3s;
}
/* スケジュール詳細のスタイル　ここまで */
</style>
