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
    kriteria: {
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

    <Head title="Kriteria" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Detail Kriteria</h2>
        </template>

        <div class="md:py-4 relative box-content">
           <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3 ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail Kriteria</span>
                                    </li>
                                </ul>

                                <table class="w-full table">
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Aspek</td>
                                        <td class="text-sm border-b text-gray-900">: {{ kriteria.nama_aspek }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Nama</td>
                                        <td class="text-sm border-b text-gray-900">: {{ kriteria.nama }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">nilai Target</td>
                                        <td class="text-sm border-b text-gray-900">: {{ kriteria.nilai_target }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Factory</td>
                                        <td class="text-sm border-b text-gray-900">: {{ kriteria.factory }} </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Sub Kriteria</span>
                                    </li>
                                </ul>
                                <table>
                                    <tr class="" v-for="item in kriteria.subkriteria">
                                        <td class="text-sm border-b py-2 font-bold">Nama</td>
                                        <td class="text-sm border-b px-3 text-gray-900">: {{ item.nama }} </td>
                                        <td class="text-sm border-b py-2 font-bold">Bobot</td>
                                        <td class="text-sm border-b px-3 text-gray-900">: {{ item.bobot }} </td>
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
