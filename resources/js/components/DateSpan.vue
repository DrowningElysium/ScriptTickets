<script setup lang="ts">
import { computed } from "vue";
import moment from "moment";

const props = defineProps<{ date: string }>();
const date = computed(() => moment(props.date));
const timeAgo = computed(() => {
    const string = date.value.fromNow();
    return string.charAt(0).toUpperCase() + string.slice(1);
});
const dateFormatted = computed(() => date.value.format("YYYY-MM-DD HH:mm"));
</script>

<template>
    <span :title="dateFormatted">
        {{ timeAgo }}
    </span>
</template>
