<template>
    <p class="moment ma-0">{{ setTime }}</p>
</template>
<script>
import moment from "moment";

export default {
    props: {
        time: String
    },
    computed: {
        setTime: function() {
            return moment(this.time)
                .add(9, "hours")
                .format("YYYY/MM/DD(ddd) hh:mm");
        }
    }
};
</script>

<style scoped></style>
