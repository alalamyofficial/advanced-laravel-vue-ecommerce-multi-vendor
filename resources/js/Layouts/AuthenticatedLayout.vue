<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import LanguageSwitcher from './Shared/LanguageSwitcher.vue'
import Navbar from '../Components/Navbar.vue'
import Sidebar from '../Components/Sidebar.vue'




const showingNavigationDropdown = ref(false);

// //

// defineProps({
//   message: String,
// });

</script>

<script>
export default {
  name: 'AuthenticatedLayout',
  props: {
    translations: {
      type: Object,
      required: true,
    },
  },

};
</script>


<template>
    <div class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">
        <div>

            <Navbar />
            <Sidebar />


        </div>
    </div>
</template>
