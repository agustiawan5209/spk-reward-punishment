<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ChartJenisImunisasi from '@/Components/Chart/ChartJenisImunisasi.vue';
import CardTable from '@/Components/Table/CardTable.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

import { ref, watch, defineProps } from 'vue';
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
    tambah: false,
    edit: false,
    show: props.can.show,
    delete: false,
    reset_password:false,

})

</script>

<template>

    <Head title="Riwayat Penilaian" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Data Kategori</h2>
        </template>

        <div class="py-4 relative box-content">
            <CardTable @update:search="search = $event" @update:order="order" :slug="null" path="Sekretariat.penilaian" :TableData="data" :tableColums="table_colums" :crud="crud" >

            </CardTable>
        </div>
    </AuthenticatedLayout>
</template>
