<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import SidebarAdmin from './SidebarAdmin.vue';
import SidebarGuru from './SidebarGuru.vue';
import SidebarOrg from './SidebarOrg.vue';
const Page = usePage().props.auth;
const Roles = Page.role;
function roleToCheck(role) {
    if (Array.isArray(Roles)) {
        return Roles.includes(role)
    } else {
        return false;
    }
}


</script>
<template>

    <nav class="flex-1 overflow-y-auto">
        <SidebarAdmin v-if="roleToCheck('Admin')"/>
        <SidebarGuru v-if="roleToCheck('Kepala Bagian')"/>
        <SidebarOrg v-if="roleToCheck('Kepala Sekretariat')"/>
    </nav>
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
