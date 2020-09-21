<template>
    <p class="moment ma-0">{{ setTime }}歳</p>
</template>
<script>
import moment from "moment";

export default {
    props: {
        time: String
    },
    computed: {
        postTime: function() {
            return moment(this.time)
                .add(9, "hours")
                .format("YYYY/MM/DD(ddd) hh:mm");
        }
    }
};
</script>

<style scoped></style>
