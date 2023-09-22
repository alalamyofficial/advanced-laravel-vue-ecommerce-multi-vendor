<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps } from "vue";
import categoryAction from "@/Pages/admin/categories/action.vue";
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

defineProps({
    categories: Array,
});
// defineComponent("categoryShow");
</script>

<script>
export default {
    mounted() {
        console.log("loading");
    },
};
</script>

<template>
    <div>
        <AuthenticatedLayout />
        <categoryAction />
    </div>
</template>
