<script setup lang="ts">
import { computed } from "vue";
import moment from "moment";
import { Tooltip } from "bootstrap";

const props = defineProps<{ date: string }>();
const date = computed(() => moment(props.date));

const addTooltip = (element: HTMLElement) => {
    return new Tooltip(element);
};
</script>

<template>
    <span
        data-bs-toggle="tooltip"
        :title="date.format('YYYY-MM-DD h:m')"
        :ref="addTooltip"
    >
        {{ date.fromNow() }}
    </span>
</template>
