<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import ChartJenisImunisasi from '@/Components/Chart/ChartJenisImunisasi.vue';
import CardTable from '@/Components/Table/CardTable.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

import { ref, watch, defineProps, inject, onMounted } from 'vue';

const swal = inject('$swal')
const page = usePage()

onMounted(() => {
    if (page.props.message !== null) {
        swal({
            icon: "success",
            title: 'Berhasil',
            text: page.props.message,
            showConfirmButton: true,
            timer: 2000
        });
    }
})

const user = page.props.auth.user;
const props = defineProps({
    search: {
        type: String,
        default: '',
    },
    order: {
        type: String,
        default: '',
    },
    data: {
        type: Object,
        default: () => ({}),
    },
    table_colums: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})
const crud = ref({
    tambah: props.can.add,
    edit: props.can.edit,
    show: props.can.show,
    delete: props.can.delete,
    reset_password: props.can.reset,

})
function cekPenilaian(penilaian, kategori_id) {
    if (!Array.isArray(penilaian)) {
        console.error("penilaian harus berupa array");
        return true;
    }
    const penilai = penilaian.filter(item => item.staff_penilai_id === user.staff.id && item.kategori_id === kategori_id);
    console.log(penilai)
    if (penilai.length > 0) {
        return false;
    } else {
        return true;
    }
}

</script>

<template>

    <Head title="Penilaian" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Data Penilaian</h2>
        </template>

        <div class="py-4 relative box-content">
            <!-- component -->
            <div class="container mx-auto bg-white">
                <div class="overflow-x-auto px-7">

                    <table class="table w-full border-collapse space-y-6 text-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="p-3 text-left">
                                    ID Penilaian
                                </th>
                                <th class="p-3 text-left">
                                    Jumlah karyawan
                                </th>
                                <th class="p-3 text-left">
                                    Tanggal Penilaian
                                </th>
                                <th class="p-3 text-left">
                                    Status
                                </th>
                                <th class="p-3 text-left">
                                    <p
                                        class="block antialiased font-sans text-sm text-blue-gray-900 font-normal leading-none opacity-70">
                                    </p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data.data" class="bg-light rounded-sm">
                                <td class="p-4 border-b border-blue-gray-50">
                                    {{ item.nama }}
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                        {{ item.alternatif.length }}</p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                                        {{ item.tanggal }}</p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <div class="w-max">
                                        <div class="relative grid items-center font-sans font-bold uppercase whitespace-nowrap select-none bg-green-500/20 text-green-900 py-1 px-2 text-xs rounded-md"
                                            style="opacity: 1;">
                                            <span class="">{{ item.status }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50" v-if="item.status == 'aktif'">
                                    <Link v-if="cekPenilaian(item.penilaian, item.id)"
                                        :href="route('Penilaian.create', { kategori: item.id })">

                                    <button
                                        class="relative select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-max p-2 rounded-lg text-gray-900 hover:bg-gray-900/10 active:bg-gray-900/20 border border-primary"
                                        type="button">
                                        <span class="text-xs flex items-center">
                                            Buat Penilaian
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" aria-hidden="true" class="h-4 w-4">
                                                <path
                                                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                                </path>
                                            </svg>
                                        </span>

                                    </button>


                                    </Link>

                                    <button v-else
                                        class="relative select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-max p-2 rounded-lg text-gray-900 hover:bg-gray-900/10 active:bg-gray-900/20 border border-primary"
                                        type="button" :disabled="true">
                                        <span class="text-xs flex items-center text-black">
                                            Penilaian Telah Dibuat
                                            <font-awesome-icon :icon="['fas', 'check']" />
                                        </span>

                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
