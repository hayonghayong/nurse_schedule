<template>
  <!-- 仮オブジェクト -->
  <v-container>
    <v-stepper value="3" alt-labels>
      <v-stepper-header>
        <v-stepper-step step="1" complete color="#5e9ce6"
          >患者選択</v-stepper-step
        >

        <v-divider></v-divider>

        <v-stepper-step step="2" complete color="#5e9ce6"
          >処置選択</v-stepper-step
        >

        <v-divider></v-divider>

        <v-stepper-step step="3" color="#5e9ce6"
          >スケジュール調整</v-stepper-step
        >
      </v-stepper-header>
    </v-stepper>

    <!-- ▼カレンダー -->
    <v-row class="fill-height">
      <v-col>
        <v-sheet height="600">
          <v-calendar
            locale="ja-jp"
            :day-format="(timestamp) => new Date(timestamp.date).getDate()"
            ref="calendar"
            v-model="focus"
            color="primary"
            type="day"
            interval-height="100px"
            :events="events"
            :event-color="getEventColor"
            :event-ripple="false"
            @mousedown:event="startDrag"
            @mousedown:time="startTime"
            @mousemove:time="mouseMove"
            @mouseup:time="endDrag"
            @mouseleave.native="cancelDrag"
            @touchstart:event="startDrag"
            @touchstart:time="startTime"
            @touchmove:time="mouseMove"
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
            <template #event="{ event, timed, eventSummary }">
              <div class="v-event-draggable" v-html="eventSummary()"></div>
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
    <!-- ▲カレンダー ここまで -->
    <!-- フッター -->
    <v-footer fixed class="font-weight-medium footer">
      <div class="footer_text" v-if="leftTaskCount != 0">
        <p class="mb-1 caption">
          上部のタスクをタッチして、時刻を登録してください。
        </p>
        <p class="mb-1 caption">残り {{ leftTaskCount }} つ</p>
      </div>
      <div class="footer_conp" v-if="leftTaskCount == 0">
        <p class="mb-1 caption">ドラッグ&ドロップでタスクを移動できます</p>
        <router-link
          :to="{
            name: 'StaffSchedule',
            params: {
              schedule_id: this.$route.params.schedule_id,
            },
          }"
        >
          <v-btn
            class="mx-auto my-2 px-12 py-4 submit_btn"
            color="#62ABF8"
            rounded
            dark
            depressed
            width="220"
            type="submit"
            >決定</v-btn
          >
        </router-link>
      </div>
    </v-footer>
  </v-container>

  <!-- ここまで -->
</template>
<script>
// コンポーネントのインポート

// Vue
export default {
  components: {},
  data: () => ({
    schedules: [],
    postScheduleData: "", //postするスケジュールデータを格納
    editSchedule: {
      treatment_id: "",
      patient_id: "",
      start_date: "",
    },
    leftTaskCount: 0,
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
    selectedStaff: "",
    //   イベントで使用するデータ
    focus: "",
    events: [], //ここを表示
    // スケジュール詳細
    selectedEvent: {},
    selectedElement: null,
    selectedOpen: false,
  }),
  created() {
    // this.fetchStaff();
    // this.fetchSchedule();
    this.setDatetime();
    this.fetchTasks();
  },
  computed: {
    cal() {
      return this.ready ? this.$refs.calendar : null;
    },
    nowY() {
      return this.cal ? this.cal.timeToY(this.cal.times.now) + "px" : "-10px";
    },
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
    // 【API】スケジュール取得
    fetchTasks: function () {
      axios
        .get("/api/tasks/get/all/" + this.$route.params.schedule_id)
        .then((res) => {
          this.schedules = res.data;
          this.fetchEvents();
        })
        .catch((err) => {
          console.log("err:", err.response.data);
        });
    },
    // 【API】スケジュール取得
    // selectSchedule: function(scheduleId) {
    //   axios
    //     .get("/api/schedules/get/" + scheduleId)
    //     .then(res => {
    //       this.editSchedule = res.date;
    //     })
    //     .catch(err => {
    //       console.log("err:", err.response.data);
    //     });
    // },
    // 【API】スケジュール更新
    updateSchedule: function () {
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

      axios
        .post("/api/tasks/update/" + task_id, this.postScheduleData)
        .then((res) => {
          this.fetchTasks();
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
    // DB保存用に日付を整形

    setDatetime: function () {
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
      this.leftTaskCount = 0;
      for (let i = 0; i < eventCount; i++) {
        // 開始時間と終了時刻の定義
        let startdate, endTime, timed;
        const requiredTime = this.schedules[i].treatment.time_required;

        // 指定されているイベント
        if (this.schedules[i].start_date) {
          startdate = new Date(this.schedules[i].start_date);
          const addition_time = requiredTime * 60 * 1000;
          endTime = startdate.getTime() + addition_time;
          timed = true;
        }
        // 指定されていないイベント
        else {
          this.leftTaskCount++;
          startdate = this.today;
          endTime = null;
          timed = false;
        }

        // イベントにpush
        events.push({
          task_id: this.schedules[i].id, //スケジュールid
          patient_id: this.schedules[i].patient_id, //患者id
          treatment_id: this.schedules[i].treatment_id, //処置id,
          required_time: requiredTime,
          start_date: startdate,
          color: this.schedules[i].treatment.color_code,
          name:
            this.schedules[i].patient.name +
            " / " +
            this.schedules[i].treatment.name, // 処置の名前
          start: startdate, // 開始時刻
          end: endTime, // 終了時刻
          timed: timed,
          room: this.schedules[i].patient.room,
          treatment: this.schedules[i].treatment.name,
          patient: this.schedules[i].patient.name,
        });
      }
      this.events = events;
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
    // カレンダー内のイベントmousedown処理
    startDrag({ event, timed }) {
      if (event && timed) {
        // ドラッグ中の値を格納
        this.dragEvent = event;
        // ドラッグtimeを初期化
        this.dragTime = null;
        // ?
        this.extendOriginal = null;
        // postデータ保持
        this.selectedEvent = event;
      }
      // dayイベントクリック時にnowラインへイベント追加
      else if (event && !timed) {
        // nowライン上に表示
        this.selectedEvent = event;
        var today = new Date();
        this.selectedEvent.start = today.getTime();
        // 時刻を整形
        const update_time = new Date(this.selectedEvent.start);
        const hour = update_time.getHours().toString().padStart(2, "0");
        const minutes = update_time.getMinutes().toString().padStart(2, "0");
        this.selectedEvent.update_time = {
          HH: hour,
          mm: minutes,
        };
        this.updateSchedule();
      }
    },
    // カレンダー内のmousedown処理
    startTime(tms) {
      // mouseの位置からunix時間へ整形
      const mouse = this.toTime(tms);
      // イベント選択時
      if (this.dragEvent && this.dragTime === null) {
        // ドラッグ中の時刻をunix時間でdragTimeに格納
        const start = this.dragEvent.start;
        this.dragTime = mouse - start;
      }
      // 新規タスク追加処理は保留中
      //  else {
      //   // イベント追加
      //   this.createStart = this.roundTime(mouse);
      //   this.createEvent = {
      //     name: `Event`,
      //     color: this.rndElement(this.colors),
      //     start: this.createStart,
      //     end: this.createStart,
      //     timed: true
      //   };
      //   this.events.push(this.createEvent);
      // }
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
    // 👷‍♂️< テスト中 > 時間未選択のタスクmoveイベント処理
    // mouseMoveEvent(tms) {
    //   // this.dragEvent.start = new Date(this.today);

    //   tms.time = "00:00";
    //   tms.hour = 0;
    //   tms.minute = 0;
    //   const mouse = this.toTime(tms);
    //   console.log(mouse);
    //   // console.log(`mouse:${mouse}`);
    //   // console.log(this.dragTime);
    //   this.dragTime = mouse;
    //   // イベントドラッグ中
    //   if (this.dragEvent && this.dragTime !== null) {
    //     const requiredTime = this.dragEvent.required_time;
    //     const addition_time = requiredTime * 60 * 1000;
    //     const endTime = this.dragEvent.startdate.getTime() + addition_time;
    //     this.dragEvent.end = endTime;
    //     const start = this.dragEvent.start;
    //     const end = this.dragEvent.end;
    //     const duration = end - start;
    //     const newStartTime = mouse - this.dragTime;
    //     const newStart = this.roundTime(newStartTime);
    //     const newEnd = newStart + duration;
    //     this.dragEvent.start = newStart;
    //     this.dragEvent.end = newEnd;
    //   }
    // },
    endDrag() {
      if (this.dragEvent) {
        // 時刻を整形
        const update_time = new Date(this.selectedEvent.start);
        const hour = update_time.getHours().toString().padStart(2, "0");
        const minutes = update_time.getMinutes().toString().padStart(2, "0");
        this.selectedEvent.update_time = {
          HH: hour,
          mm: minutes,
        };
        // 更新
        this.updateSchedule();
      }
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
  },
};
</script>

<style  lang="scss" scoped>
/* スコープ付きのスタイル */
/* スコープ付きのスタイル */
/*  nowライン */
.v-current-time {
  height: 2px;
  background-color: #ea4335;
  position: absolute;
  left: -1px;
  right: 0;
  pointer-events: none;
  // ↓丸いポイントが出る
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
// Drag and Drop
.v-event-draggable {
  padding-left: 6px;
}

// .v-event-timed {
//   user-select: none;
//   -webkit-user-select: none;
// }
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

.v-stepper {
  box-shadow: none;
}
.v-stepper__header {
  box-shadow: none;
}
.v-stepper--alt-labels .v-stepper__header .v-divider {
  margin: 22px -25px 0;
}
.v-divider {
  max-width: 90px;
}
.v-stepper__step {
  padding: 10px;
}
.v-stepper--alt-labels .v-stepper__step {
  flex-basis: 100px;
}
#app
  > div
  > main
  > div
  > div
  > div.v-stepper.v-stepper--vertical.v-stepper--alt-labels.theme--light
  > div
  > div.v-stepper__step.v-stepper__step--active
  > span {
  margin-right: 0px;
}

.col {
  padding: 0px;
}
.footer_conp a{
  text-decoration:none;
}

.footer {
  // background: rgba(255, 0 0, 0.5);
  display: flex;
  // justify-content: center;
  flex-direction: column;
}
.footer_text {
  text-align: center;
}
.footer_conp{
  text-align: center;
}
</style>
