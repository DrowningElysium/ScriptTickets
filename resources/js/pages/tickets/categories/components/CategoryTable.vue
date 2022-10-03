<script setup lang="ts">
import type Category from "@/stores/category";
import { computed } from "vue";
import CategoryTableTitle from "./CategoryTableTitle.vue";

const props = defineProps<{ categories: Category[] }>();
const categories = computed(() => {
    return Object.values(props.categories).sort((a: Category, b: Category) =>
        // Titles are unique. So don't need to return 0.
        a.title.toLowerCase() > b.title.toLowerCase() ? 1 : -1
    );
});
</script>

<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Actions/Title</th>
                <th>Used</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            <tr v-for="category in categories" :key="category.id">
                <td>{{ category.id }}</td>
                <CategoryTableTitle :category="category" />
                <td>{{ category.tickets_count }}</td>
            </tr>
        </tbody>
    </table>
</template>

<style scoped lang="scss">
tr {
    & td:first-child,
    & td:last-child {
        width: 1%;
        white-space: nowrap;
    }
}
</style>
