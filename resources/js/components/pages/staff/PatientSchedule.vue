<template>
    <div>
        <!-- ▼カレンダー -->
        <v-row class="fill-height">
            <v-col>
                <!-- ▼カレンダー設定 -->
                <v-sheet height="700">
                    <v-calendar
                        class="test"
                        ref="calendar"
                        v-model="focus"
                        locale="ja-jp"
                        color="primary"
                        type="category"
                        interval-height="100px"
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
                        @touchstart:event="startDrag"
                        @touchstart:time-category="startTime"
                        @touchmove:time-category="mouseMove"
                        @touchend:time="endDrag"
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
                        <template #event="{eventSummary}">
                            <div
                                class="v-event-draggable"
                                v-html="eventSummary()"
                            ></div>
                            <!-- <div
                                v-if="timed"
                                class="v-event-drag-bottom"
                                @mousedown.stop="extendBottom(event)"
                            ></div>-->
                        </template>
                        <!-- ドラック&ドロップ設定ここまで -->
                    </v-calendar>
                </v-sheet>
            </v-col>
        </v-row>
        <!-- ▲カレンダーここまで -->
        <!-- クリック時に開く詳細画面 -->
        <transition name="selectedOpenSlide">
            <v-card
                v-if="selectedOpen"
                min-width="350px"
                class="detail-schedule rounded-xl"
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
                    <p class="subtitle-1">タスク詳細</p>
                    <div
                        class="d-flex mb-2 body-1 font-weight-bold cardTextTime"
                    >
                        <MomentJsTime
                            class="cardTextTime"
                            :time="selectedEvent.start_date"
                        />
                        <span class="cardTextTime">〜</span>
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
                            selectedEvent.end_flg == 0 &&
                                timepicker_show == false
                        "
                        rounded
                        dark
                        color="#EF9C38"
                        class="mx-auto px-6 mb-3"
                        @click="saveEndFlagFinished(selectedEvent.task_id)"
                        >処置完了</v-btn
                    >
                    <v-btn
                        v-else-if="
                            selectedEvent.end_flg == 1 &&
                                timepicker_show == false
                        "
                        rounded
                        dark
                        color="#c3c3c3"
                        class="mx-auto px-6 mb-3"
                        @click="saveEndFlagUnfinished(selectedEvent.task_id)"
                        >未完了に変更</v-btn
                    >
                    <v-btn
                        v-if="timepicker_show == false"
                        rounded
                        dark
                        color="#62ABF8"
                        class="mx-auto px-6"
                        @click="timepicker_show = true"
                        >時間変更</v-btn
                    >
                    <v-btn
                        v-else
                        rounded
                        dark
                        color="#62ABF8"
                        class="mx-auto px-6"
                        @click="updateSchedule()"
                        >変更を保存</v-btn
                    >
                </v-card-actions>
            </v-card>
        </transition>
        <!-- タスク追加モーダル -->
                <transition name="selectedOpenSlide">
            <v-card
                v-if="registOpen"
                min-width="350px"
                class="detail-schedule rounded-xl"
            >
                <v-card-actions>
                    <v-btn
                        text
                        color="#62ABF8"
                        class="mx-auto"
                        @click="registOpen = false"
                    >
                        <v-icon class="ma-2 mdi-36px" color="#62ABF8"
                            >mdi-chevron-down</v-icon
                        >
                    </v-btn>
                </v-card-actions>
                <v-card-text class="pt-0">
                    <div class="card_selectBox">
                        <label>患者</label>
                        <div class="cp_ipselect cp_sl02">
                            <select 
                                v-model="registEvent.patient_id">
                                <option disabled value>選択してください</option>
                                <option
                                    v-for="patient in patients"
                                    :value="patient.id"
                                    :key="patient.id"
                                >
                                    {{ patient.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card_selectBox">
                        <label>処置</label>
                        <div class="cp_ipselect cp_sl02">
                            <select v-model="registEvent.treatment_id">
                                <option disabled value>選択してください</option>
                                <option
                                    v-for="treatment in treatments"
                                    :value="treatment.id"
                                    :key="treatment.id"
                                >
                                    {{ treatment.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card_selectBox">
                        <label class="card_label mr-4">時間</label>
                        <vue-timepicker
                            :minute-interval="10"
                            v-model="registEvent.start_time"
                            id="start_time"
                            name="startTime"
                            placeholder="開始時間"
                            hour-label="時"
                            minute-label="分"
                            input-class="form-control"
                            drop-direction="up"
                            close-on-complete
                        ></vue-timepicker>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        rounded
                        dark
                        color="#62ABF8"
                        class="mx-auto px-6 mb-3"
                        @click="registTask()"
                        >追加</v-btn
                    >
                </v-card-actions>
            </v-card>
        </transition>
        <!-- タスク作成時に開く詳細画面 ここまで-->
        <!-- スケジュール追加ボタン -->
        <v-btn
            class="mx-2 regist_float_btn"
            fab
            dark
            small
            color="#62ABF8"
            @click="registOpen = true"
        >
            <v-icon dark>mdi-plus</v-icon>
        </v-btn>
        <!-- スケジュール追加ボタンここまで -->
    </div>
</template>
<script>
// コンポーネントのインポート
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
        patients: [],
        postScheduleData: "", //postするスケジュールデータを格納
        today: "",
        treatments:"",
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
        selectedStaff: "",
        //   イベントで使用するデータ
        focus: "",
        events: [], //ここを表示
        categories: [], //患者の名前
        // スケジュール詳細
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false,
        timepicker_show: false,
        // タスク新規作成
        registEvent: {},
        registElement: null,
        registOpen:false,
    }),
    created() {
        this.fetchStaff();
        this.fetchSchedule();
        this.fetchTreatment();
        this.setDatetime();
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
        this.setToday();
        //   nowライン
        this.ready = true;
        this.scrollToTime();
        this.updateTime();
        //   予定
        this.$refs.calendar.checkChange();
    },
    methods: {
        // 【API】患者を取得
        fetchStaff: function() {
            axios
                .get(`/api/users_patients/get/all/${this.$route.params.schedule_id}`)
                .then(res => {
                    this.patients = res.data;
                    //   カレンダー表記用の配列に格納
                    this.categories = this.patients.map(el => el.name);
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        // 【API】処置取得
        fetchTreatment: function() {
            axios
                .get("/api/treatments/get/all")
                .then(res => {
                    this.treatments = res.data;
                })
                .catch(err => {
                    console.log("err:", err);
                });
        },
        // 【API】スケジュールを取得
        fetchSchedule: function() {
            axios
                .get(`/api/tasks/get/all/${this.$route.params.schedule_id}`)
                .then(res => {
                    this.schedules = res.data;
                    //  イベントを取得
                    this.fetchEvents();
                })
                .catch(err => {
                    console.log("err:", err.response.data);
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
            const task_id = this.postScheduleData.task_id;
            this.timepicker_show = false;
            axios
                .post(`/api/tasks/update/${task_id}`, this.postScheduleData)
                .then(res => {
                    // 描画し直し
                    this.fetchSchedule();
                })
                .catch(err => {
                    console.log("err:", err.response.data);
                });
        },       
        // 【API】新規タスク登録
        registTask: function() {
            // schedule_idを取得して格納
            const target = this.patients.find(el => {
                return el.name === this.registEvent.category;
            });
            this.registEvent.schedule_id = this.$route.params.schedule_id;
            //   時刻をDB登録用に整形
            const setTime = this.registEvent.start_time;
            const startTime =
                this.today + " " + setTime.HH + ":" + setTime.mm + ":00";
            this.registEvent.start_date = startTime;
            axios
                .post(`/api/tasks/post/new`, this.registEvent)
                .then(res => {
                    this.registOpen = false;
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
               const dateTime = this.replaceDate(this.schedules[i].start_date)
                const startdate = new Date(dateTime);
                const requiredTime = this.schedules[i].treatment.time_required;
                const addition_time = requiredTime * 60 * 1000;
                const endTime = startdate.getTime() + addition_time;
                const endFlag = this.schedules[i].end_flg;
                const endFlagData = "";
                // 完了しているかでタスクの色を変更
                if (endFlag == 0) {
                    endFlagData = this.schedules[i].treatment.color_code;
                } else if (endFlag == 1) {
                    endFlagData = "grey darken-1";
                }
                // イベントにpush
                events.push({
                    //   user_id: this.schedules[i].user_id, //ユーザーid
                    task_id: this.schedules[i].id, //タスクid
                    patient_id: this.schedules[i].patient_id, //患者id
                    treatment_id: this.schedules[i].treatment_id, //処置id
                    category: this.schedules[i].patient.name, //スタッフの名前
                    name: this.schedules[i].treatment.name, // 処置の名前
                    start: startdate, // 開始時刻
                    end: endTime, // 終了時刻
                    color: endFlagData, // end_flgで判定した色
                    timed: true,
                    room: this.schedules[i].patient.room,
                    treatment: this.schedules[i].treatment.name,
                    patient: this.schedules[i].patient.name,
                    end_flg: this.schedules[i].end_flg
                });
            }
            this.events = events;
        },
        // -----------  イベント取得&表示ここまで ---------- //
        replaceDate(dateStr) {
            const regexp = /^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9])(?:( [0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/;
            return dateStr.replace(regexp, (match, year, month, day, hour, minutes, seconds) => {
                return `${year}/${month}/${ day} ${hour}:${minutes}:${seconds}`;
            });
        } ,
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
                // ドラック前のスタッフ名を保持
                this.selectedStaff = event.category;
                // postデータ保持
                this.selectedEvent = event;
            }
        },
        startTime(tms) {
            const mouse = this.toTime(tms);
            if (this.dragEvent && this.dragTime === null) {
                const start = this.dragEvent.start;
                this.dragTime = mouse - start;
            }else{
                tms.start = this.roundTime(mouse);
                // this.showRegistEvent(tms);
                this.createStart = this.roundTime(mouse);
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
                const start = this.dragEvent.start;
                const end = this.dragEvent.end;
                const duration = end - start;
                const newStartTime = mouse - this.dragTime;
                const newStart = this.roundTime(newStartTime);
                const newEnd = newStart + duration;
                const category = tms.category;
                this.dragEvent.start = newStart;
                this.dragEvent.end = newEnd;
                // ここを記載すると患者間の移動がokになっちゃいます
                // this.dragEvent.category = category;
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
            // // *スタッフ間を移動した場合に、postデータのuser_idを変更
            // if (this.selectedStaff !== this.dragEvent.category) {
            //     const target = this.patients.find(el => {
            //         return el.name === this.dragEvent.category;
            //     });
            //     this.selectedEvent.user_id = target.schedule.id;
            // }
            if(this.selectedEvent.task_id){
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
            }

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

        // 【API】タスク完了処理
        saveEndFlagFinished(task_id) {
            axios
                .post(`/api/tasks/end_flg/finished/${task_id}`)
                .then(res => {
                    this.selectedEvent.end_flg = 1;
                    // 描画し直し
                    this.fetchSchedule();
                })
                .catch(err => {
                    console.log("err:", err.response.data);
                });
        },
        // 【API】タスク未完了処理
        saveEndFlagUnfinished(task_id) {
            axios
                .post(`/api/tasks/end_flg/unfinished/${task_id}`)
                .then(res => {
                    this.selectedEvent.end_flg = 0;
                    // 描画し直し
                    this.fetchSchedule();
                })
                .catch(err => {
                    console.log("err:", err.response.data);
                });
        },
        // ------------ クリックしたときの詳細画面 ---------- //
        showEvent({ nativeEvent, event }) {
            const open = () => {
                this.selectedEvent = event;
                this.selectedElement = nativeEvent.target;
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
        // ------------ クリックしたときの詳細画面 ここまで ---------- //
                // ------------ タスク作成時の詳細画面 ---------- //
        showRegistEvent(event) {
            const open = () => {
                this.registEvent.category = event.category;
                // 時刻を整形
                const update_time = new Date(event.start);
                const hour = update_time
                    .getHours()
                    .toString()
                    .padStart(2, "0");
                const minutes = update_time
                    .getMinutes()
                    .toString()
                    .padStart(2, "0");
                this.registEvent.start_time = {
                    HH: hour,
                    mm: minutes
                };
                // this.registElement = nativeEvent.target;
                setTimeout(() => (this.registOpen = true), 10);
            };

            if (this.registOpen) {
                this.registOpen = false;
                setTimeout(open, 10);
            } else {
                open();
            }
        },
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

@keyframes slidedown {
    0% {
        opacity: 1;
        transform: translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateY(64px);
    }
}

.detail-schedule {
    position: fixed;
    bottom: -20px;
    left: 0;
    right: 0;
    width: 100%;
    height: 350px;
    z-index: 5;
    padding-bottom: 40px;
    background: #fff;
}

.selectedOpenSlide-enter-active {
    animation: slideup 0.3s;
}

.selectedOpenSlide-leave-to {
    animation: slidedown 0.3s;
}
/* スケジュール詳細のスタイル　ここまで */

/* スケジュール登録のスタイル */
.cp_ipselect {
    overflow: hidden;
    width: 70%;
    margin: 1em;
}
.cp_ipselect select {
    width: 100%;
    padding-right: 1em;
    cursor: pointer;
    text-indent: 0.01px;
    text-overflow: ellipsis;
    border: none;
    outline: none;
    background: transparent;
    background-image: none;
    box-shadow: none;
    -webkit-appearance: none;
    appearance: none;
}
.cp_ipselect select::-ms-expand {
    display: none;
}
.cp_ipselect.cp_sl02 {
    position: relative;
    border: 1px solid #bbbbbb;
    border-radius: 2px;
    background: #ffffff;
}
.cp_ipselect.cp_sl02::before {
    position: absolute;
    top: 0.8em;
    right: 0.9em;
    width: 0;
    height: 0;
    padding: 0;
    content: "";
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #666666;
    pointer-events: none;
}
.cp_ipselect.cp_sl02:after {
    position: absolute;
    top: 0;
    right: 2.5em;
    bottom: 0;
    width: 1px;
    content: "";
    border-left: 1px solid #bbbbbb;
}
.cp_ipselect.cp_sl02 select {
    padding: 8px 38px 8px 8px;
    color: #666666;
}
.card_selectBox {
    display: flex;
    justify-content: flex-start;
    align-items: center;
}
/* スケジュール登録のスタイル ここまで */
// 追加ボタン
.regist_float_btn {
    position: fixed;
    bottom: 100px;
    right: 20px;
}
</style>
