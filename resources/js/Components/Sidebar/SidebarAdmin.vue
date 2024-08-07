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
        <DropdownNavLink title="Master Data" :active="route().current('Departement.index') || route().current('Departement.create') || route().current('Departement.edit') || route().current('Departement.show') || route().current('Staff.index') || route().current('Staff.create') || route().current('Staff.edit') || route().current('Staff.show')">
            <template #icon>📂</template>
            <li class="group">
                <DropdownNavItem :href="route('Departement.index')"
                    :active="route().current('Departement.index') || route().current('Departement.create') || route().current('Departement.edit') || route().current('Departement.show')"
                    :icon="['fas', 'person-breastfeeding']">
                    <span class="capitalize">Data Departement</span>
                </DropdownNavItem>
            </li>
            <li class="group">
                <DropdownNavItem :href="route('Staff.index')"
                    :active="route().current('Staff.index') || route().current('Staff.create') || route().current('Staff.edit') || route().current('Staff.show')"
                    :icon="['fas', 'users-line']">

                    <span class="capitalize">Data Staff</span>
                </DropdownNavItem>
            </li>
        </DropdownNavLink>

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
