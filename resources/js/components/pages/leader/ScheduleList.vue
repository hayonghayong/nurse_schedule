<template>
    <div>
        <!-- ▼カレンダー -->
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

                <!-- ▼カレンダー設定 -->
                <v-sheet height="600">
                    <v-calendar
                        class="test"
                        ref="calendar"
                        v-model="focus"
                        color="primary"
                        type="category"
                        category-show-all
                        :categories="categories"
                        :events="events"
                        :event-color="getEventColor"
                        :event-ripple="false"
                        @mousedown:event="startDrag"
                        @mousedown:time-category="startTime"
                        @mousemove:time-category="mouseMove"
                        @mouseup:time="endDrag"
                        @mouseleave.native="cancelDrag"
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
                        <template #event="{ event, timed,eventSummary}">
                            <div
                                class="v-event-draggable"
                                v-html="eventSummary()"
                            ></div>
                            <div
                                v-if="timed"
                                class="v-event-drag-bottom"
                                @mousedown.stop="extendBottom(event)"
                            ></div>
                        </template>
                        <!-- ドラック&ドロップ設定ここまで -->
                    </v-calendar>
                </v-sheet>
            </v-col>
        </v-row>
        <!-- ▲カレンダーここまで -->
        <!-- クリック時に開く詳細画面 -->
        <v-card
            v-if="selectedOpen"
            min-width="350px"
            flat
            class="detail-schedule"
        >
            <v-card-text>
                <p>{{ selectedEvent.category }}</p>
                <p>{{ selectedEvent.patient }}</p>
                <p>{{ selectedEvent.name }}</p>
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
</template>
<script>
// コンポーネントのインポート
import MomentJs from "../../items/MomentJs";

// Vue
export default {
    components: {
        MomentJs
    },
    data: () => ({
        staffs: [],
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
        //   イベントで使用するデータ
        focus: "",
        events: [], //ここを表示
        colors: ["blue"], // テスト用
        names: ["テスト", "テスト2"], // スケジュールの名前
        categories: [], //患者の名前
        // スケジュール詳細
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false
    }),
    created() {
        this.fetchStaff();
        this.fetchSchedule();
    },
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
        //   予定
        this.$refs.calendar.checkChange();
    },
    methods: {
        // 【API】スタッフを取得
        fetchStaff: function() {
            axios
                .get("/api/team_users/get/all/" + this.$route.params.team_id)
                .then(res => {
                    this.staffs = res.data;
                    //   カレンダー表記用の配列に格納
                    this.categories = this.staffs.map(el => el.name);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        // 【API】スケジュールを取得
        fetchSchedule: function() {
            axios
                .get("/api/schedules/get/team")
                .then(res => {
                    this.schedules = res.data;
                    //  イベントを取得
                    this.fetchEvents();
                })
                .catch(err => {
                    console.log("err:", err.response.data);
                });
        },
        // ---------- スケジュール表示関連 ---------- //
        // ▼イベント取得&表示
        // ▼nowライン表示
        // ▼ドラック&ドロップ機能
        // --------------------------------------- //

        // ------------ ▼イベント取得&表示 ---------- //
        getEventColor(event) {
            return event.color;
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
        // イベント登録
        fetchEvents() {
            const events = [];
            const eventCount = this.schedules.length;
            for (let i = 0; i < eventCount; i++) {
                // 開始時間と終了時刻の定義
                const startdate = new Date(this.schedules[i].start_date);
                const requiredTime = this.schedules[i].treatment.time_required;
                const addition_time = requiredTime * 60 * 1000;
                const endTime = startdate.getTime() + addition_time;
                // イベントにpush < テストデータ
                events.push({
                    category: this.schedules[i].user.name, //スタッフの名前
                    name:
                        this.schedules[i].patient.name +
                        " / " +
                        this.schedules[i].treatment.name, // 処置の名前
                    start: startdate, // 開始時刻
                    end: endTime, // 終了時刻
                    color: this.colors[0], //デフォルトのカラー
                    timed: true,
                    id: this.schedules[i].id,
                    room: this.schedules[i].patient.room,
                    treatment: this.schedules[i].treatment.name,
                    patient: this.schedules[i].patient.name
                });
            }
            this.events = events;
            console.log(this.events);
        },
        // -----------  イベント取得&表示ここまで ---------- //

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
        },
        // ------------ nowラインここまで ---------- //

        // ------------ ▼Drag and Drop ---------- //
        startDrag({ event, timed }) {
            if (event && timed) {
                this.dragEvent = event;
                this.dragTime = null;
                this.extendOriginal = null;
            }
        },
        startTime(tms) {
            const mouse = this.toTime(tms);
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
                    timed: true,
                    // 追記
                    category: tms.category
                };
                this.events.push(this.createEvent);
            }
        },
        extendBottom(event) {
            this.createEvent = event;
            this.createStart = event.start;
            this.extendOriginal = event.end;
        },
        mouseMove(tms) {
            const mouse = this.toTime(tms);

            // イベントドラッグ中
            if (this.dragEvent && this.dragTime !== null) {
                const start = this.dragEvent.start;
                const end = this.dragEvent.end;
                const duration = end - start;
                const newStartTime = mouse - this.dragTime;
                const newStart = this.roundTime(newStartTime);
                const newEnd = newStart + duration;
                const category = tms.category;
                this.dragEvent.start = newStart;
                this.dragEvent.end = newEnd;
                // カテゴリー追加
                this.dragEvent.category = category;
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
        }
        // ------------ クリックしたときの詳細画面 ここまで ---------- //
    }
};
</script>

<style lang="scss" scoped>
/* スコープ付きのスタイル */
// nowライン
.v-current-time {
    height: 2px;
    background-color: #ea4335;
    position: absolute;
    left: -1px;
    right: 0;
    pointer-events: none;
    //     // ↓丸いポイントが出る
    //     //   &.first::before {
    //     //     content: "";
    //     //     position: absolute;
    //     //     background-color: #ea4335;
    //     //     width: 12px;
    //     //     height: 12px;
    //     //     border-radius: 50%;
    //     //     margin-top: -5px;
    //     //     margin-left: -6.5px;
    //     //   }
}
// Drag and Drop
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
