<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { ref, defineProps, watch, onMounted } from 'vue';

const page = usePage();
const props = defineProps({
    kategori: {
        type: Object,
        default: () => ({})
    },
})

</script>

<template>

    <Head title="Evaluasi" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Detail Evaluasi</h2>
        </template>

        <div class="md:py-4 relative box-content">
            <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3 ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail Evaluasi</span>
                                    </li>
                                </ul>

                                <table class="w-full table">
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Nama</td>
                                        <td class="text-sm border-b text-gray-900">: {{ kategori.nama }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Jadwal Penilaian</td>
                                        <td class="text-sm border-b text-gray-900">: {{ kategori.tanggal }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Keterangan :</td>
                                        <td class="text-sm border-b text-gray-900" v-html="kategori.keterangan">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-span-full overflow-x-auto mt-3">
                                <table class="w-full text-xs text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-white uppercase bg-primary ">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Departement
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Karyawan
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Jabatan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b" v-for="(item, index) in kategori.alternatif"
                                            :key="index">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                                                {{ item.staff.nama_departement }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ item.staff.nama }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ item.staff.jabatan }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
