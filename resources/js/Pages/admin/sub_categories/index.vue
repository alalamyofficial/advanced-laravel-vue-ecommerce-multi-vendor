<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps } from "vue";
import SubCategoryAction from "@/Pages/admin/sub_categories/action.vue";
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
        <SubCategoryAction />
    </div>
</template>
