<script setup lang="ts">
import type Category from "@/stores/category";
import CategoryTableTitle from "./CategoryTableTitle.vue";

const props = defineProps<{ categories: Category[] }>();
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
            <tr v-for="category in props.categories" :key="category.id">
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
