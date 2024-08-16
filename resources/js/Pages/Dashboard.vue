<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,usePage } from '@inertiajs/vue3';
import HeaderStats from '@/Components/Header/HeaderStats.vue';
import { defineProps } from "vue";

const Page = usePage().props.auth;
const Roles = Page.role;
function roleToCheck(role) {
    if (Array.isArray(Roles)) {
        return Roles.includes(role)
    } else {
        return false;
    }
}
const props = defineProps({
    pengguna: {
        type: Number,
        default: 0,
    },
    siswa: {
        type: Number,
        default: 0,
    },
    kelas: {
        type: Number,
        default: 0,
    },
    orangtua: {
        type: Number,
        default: 0,
    },
    staff: {
        type: Number,
        default: 0,
    },

});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl  leading-tight">Dashboard</h2>
        </template>

        <div class="py-4 relative box-content">
            <div class="max-w-7xl mx-auto sm:px-6" v-if="roleToCheck('Admin') || roleToCheck('Staff')">
                <HeaderStats :pengguna="pengguna" :siswa="siswa" :staff="staff" :kelas="kelas" :orangtua="orangtua" />

            </div>
            <div class="py-4 relative box-content bg-white border rounded-lg" >
                <div class="bg-priamry overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-1 2xl:grid-cols-2 gap-7 p-2 place-content-end">
                        <div class=" p-3 flex justify-center items-center relative">
                            <div class="text-lg font-semibold text-center">
                                <span class="text-green-700 md:text-4xl">SISTEM PENDUKUNG KEPUTUSAN</span> <br>
                                <span class="md:text-xl">PUNISMENT/REWARD MENGGUNAKAN METODE</span>
                                PROFILE MATCHING<span class="text-red-600 text-2xl"> <br> DI BAWASLU KOTA
                                   MAKASSAR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
