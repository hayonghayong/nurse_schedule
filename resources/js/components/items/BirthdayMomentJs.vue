<template>
    <p class="moment ma-0">{{ setAge }}歳</p>
</template>
<script>
import moment from "moment";

export default {
    props: {
        time: String
    },
    computed: {
        setAge: function() {
            const dateOfBirth = moment(new Date(this.time));
            const today = moment(new Date());
            let baseAge = today.year() - dateOfBirth.year();

            let birthday = moment(
                new Date(
                    today.year() +
                        "-" +
                        (dateOfBirth.month() + 1) +
                        "-" +
                        dateOfBirth.date()
                )
            );

            if (today.isBefore(birthday)) {
                return baseAge - 1;
            }

            return baseAge;
        }
    }
};
</script>

<style scoped></style>
