<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import DropdownNavLink from './DropdownNavLink.vue';
import DropdownNavItem from './DropdownNavItem.vue';
import { Link, usePage } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar/Sidebar.vue';

const Page = usePage().props.auth;
const Roles = Page.role;
function roleToCheck(role) {
    if (Array.isArray(Roles)) {
        return Roles.includes(role)
    } else {
        return false;
    }
}


const openDropdown = ref([]);

const toggleDropdown = (menu) => {
    if (openDropdown.value.includes(menu)) {
        openDropdown.value = openDropdown.value.filter(item => item !== menu);
    } else {
        openDropdown.value.push(menu);
    }
};

const isOpenDropdown = (menu) => openDropdown.value.includes(menu);

</script>
<template>
    <ul>
        <li>
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')" :icon="['fas', 'home']">

                <span class="-mr-1 font-medium">Dashboard</span>
            </NavLink>
        </li>
        <li>
            <NavLink :href="route('Sekretariat.staff.index')"
                :active="route().current('Sekretariat.staff.index')"
                :icon="['fas', 'users']">

                <span class="-mr-1 font-medium">Data Karyawan</span>
            </NavLink>
        </li>
        <li>
            <NavLink :href="route('admin.riwayat.penilaian')"
                :active="route().current('admin.riwayat.penilaian')"
                :icon="['fas', 'calendar-days']">

                <span class="-mr-1 font-medium">Riwayat Evaluasi</span>
            </NavLink>
        </li>
        <li>
            <NavLink :href="route('Putusan.index')"
                :active="route().current('Putusan.index')"
                :icon="['fas', 'circle-info']">

                <span class="-mr-1 font-medium">Punishment/Reward</span>
            </NavLink>
        </li>
    </ul>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active in <2.1.8 */
    {
    opacity: 0;
}
</style>
