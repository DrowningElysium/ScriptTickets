<script setup lang="ts">
import type Category from "@/stores/category";

const props = defineProps<{ categories: Category[] }>();
</script>

<template>
    <span
        class="badge bg-primary"
        style="margin-left: 0.1rem; margin-right: 0.1rem"
        v-for="category in props.categories"
        :key="category.id"
    >
        {{ category.title }}
    </span>
</template>
