<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage,Link } from '@inertiajs/vue3';
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
    putusan: {
        type: Object,
        default: () => ({})
    },
    can: {
        type: Object,
        default: () => ({})
    }
})

</script>

<template>

    <Head title="Detail Punishment/Reward" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Detail Punishment/Reward</h2>
        </template>

        <div class="md:py-4 relative box-content">
           <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3 ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail Karyawan</span>
                                    </li>
                                </ul>

                                <table class="w-full table">
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Nama</td>
                                        <td class="text-sm border-b text-gray-600">: {{ putusan.jenis_putusan }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Nama Karyawan</td>
                                        <td class="text-sm border-b text-gray-600">: {{ putusan.staff.nama }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Alamat</td>
                                        <td class="text-sm border-b text-gray-600">: {{ putusan.staff.alamat }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Jabatan</td>
                                        <td class="text-sm border-b text-gray-600">: {{ putusan.staff.jabatan }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Departement</td>
                                        <td class="text-sm border-b text-gray-600">: {{ putusan.staff.departement.nama }} </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Jenis Punishment/Reward</span>
                                    </li>
                                </ul>
                                <table>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Jenis Putusan</td>
                                        <td class="text-sm border-b text-gray-600">: {{ putusan.jenis_putusan }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Tanggal Punishment/Reward</td>
                                        <td class="text-sm border-b text-gray-600">: {{ putusan.tgl_putusan }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 " colspan="2">
                                            <h4 class="font-bold mb-2">Alasan Pemberian Punishment/Reward :</h4>

                                            <p v-html="putusan.alasan"></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
