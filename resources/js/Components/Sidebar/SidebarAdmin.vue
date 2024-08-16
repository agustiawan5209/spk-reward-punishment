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
        <DropdownNavLink title="Master Data"
            :active="route().current('Departement.index') || route().current('Departement.create') || route().current('Departement.edit') || route().current('Departement.show') || route().current('Staff.index') || route().current('Staff.create') || route().current('Staff.edit') || route().current('Staff.show')">
            <template #icon>📂</template>
            <li class="group">
                <DropdownNavItem :href="route('Departement.index')"
                    :active="route().current('Departement.index') || route().current('Departement.create') || route().current('Departement.edit') || route().current('Departement.show')"
                    :icon="['fas', 'building']">
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
        <DropdownNavLink title="Master Penilaian"
            :active="route().current('Aspek.index') || route().current('Aspek.create') || route().current('Aspek.edit') || route().current('Aspek.show') || route().current('Kriteria.index') || route().current('Kriteria.create') || route().current('Kriteria.edit') || route().current('Kriteria.show')">
            <template #icon>📂</template>
            <li>
                <DropdownNavItem :href="route('Gap.index')"
                    :active="route().current('Gap.index') || route().current('Gap.create') || route().current('Gap.edit') || route().current('Gap.show')" :icon="['fas', 'key']">

                    <span class="-mr-1 font-medium">Gap/Selisih Penilaian</span>
                </DropdownNavItem>
            </li>
            <li>
                <DropdownNavItem :href="route('Aspek.index')"
                    :active="route().current('Aspek.index') || route().current('Aspek.create') || route().current('Aspek.edit') || route().current('Aspek.show')" :icon="['fas', 'folder-open']">

                    <span class="-mr-1 font-medium">Aspek Penilaian</span>
                </DropdownNavItem>
            </li>
            <li>
                <DropdownNavItem :href="route('Kriteria.index')"
                    :active="route().current('Kriteria.index') || route().current('Kriteria.create') || route().current('Kriteria.edit') || route().current('Kriteria.show')" :icon="['fas', 'lock']">

                    <span class="-mr-1 font-medium">Kriteria Penilaian</span>
                </DropdownNavItem>
            </li>
        </DropdownNavLink>


        <li>
            <NavLink :href="route('Kategori.index')"
                :active="route().current('Kategori.index') || route().current('Kategori.create') || route().current('Kategori.edit') || route().current('Kategori.show')"
                :icon="['fas', 'calendar-days']">

                <span class="-mr-1 font-medium">Evaluasi</span>
            </NavLink>
        </li>
        <li>
            <NavLink :href="route('admin.riwayat.penilaian')"
                :active="route().current('admin.riwayat.penilaian')"
                :icon="['fas', 'calendar']">

                <span class="-mr-1 font-medium">Riwayat Evaluasi</span>
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
