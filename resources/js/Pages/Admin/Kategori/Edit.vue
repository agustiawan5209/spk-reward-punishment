<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, defineProps, watch, inject } from 'vue';
const swal = inject('$swal')
import {
    FwbSpinner,
} from 'flowbite-vue'
import axios from 'axios';
const page = usePage()

const props = defineProps({
    departement: {
        type: Object,
        default: () => ({})
    },
    kategori: {
        type: Object,
        default: () => ({})
    },
})

const Form = useForm({
    slug: props.kategori.id,
    nama: props.kategori.nama,
    tanggal: props.kategori.tanggal,
    keterangan: props.kategori.keterangan,
    status: props.kategori.status,
    data_karyawan: '',
})
const tableKaryawan = ref(true)
const DepartementId = ref('');
const DataKaryawan = ref([]);
const CheckBoxKaryawan = ref([])
watch(DepartementId, (value) => {
    axios.get(route('api.staff.list', { departement_id: value }))
        .then((res) => {
            if (res.status == 200) {
                const elem = res.data;
                if (elem.length > 0) {
                    for (let i = 0; i < elem.length; i++) {
                        DataKaryawan.value[i] = {
                            staff_id: elem[i].id,
                            nama: elem[i].nama,
                            jabatan: elem[i].jabatan,
                            status: false,
                        }
                    }
                } else {
                    DataKaryawan.value = [];
                    // CheckBoxKaryawan.value = [];
                }
            }
            console.log(DataKaryawan.value)
        }).catch(err => console.log(err))
})

if (props.kategori.alternatif.length > 0) {
    const karyawan = Object.create(props.kategori.alternatif);
    karyawan.forEach((item) => {
        CheckBoxKaryawan.value.push({
            staff_id: item.staff.id,
            nama: item.staff.nama,
            jabatan: item.staff.jabatan,
            status: item.status,
        })
    })

}

function submit() {
    Form.data_karyawan = CheckBoxKaryawan.value;
    Form.put(route('Kategori.update'), {
        onError: (err) => {
            var txt = "<ul>"
            Object.keys(err).forEach((item, val) => {
                txt += `<li class="text-xs leading-7">${err[item]}</li>`
            });
            txt += "</ul>";
            console.log(txt)
            swal({
                title: "Peringatan",
                icon: "error",
                html: txt,
                showCloseButton: true,
                showCancelButton: true,
            });
        }
    });
}

function addSliceArray(index, item) {
    item.status = true;
    DataKaryawan.value.splice(index, 1)
    CheckBoxKaryawan.value.push(item)
}

function deleteKaryawan(index, item) {
    CheckBoxKaryawan.value.splice(index, 1)

}
</script>

<template>

    <Head title="Edit Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Edit Kategori</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action="" class="container mx-auto space-y-12">
                    <div class="block">
                        <p class="p-2 text-sm text-gray-600">Keterangan: Halaman Ini Ditujukan untuk Memilih karyawan
                            yang akan
                            dievaluasi kinerjanya</p>
                        <fieldset class="text-xs grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                            <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                                <div class="col-span-full md:col-span-3">
                                    <InputLabel for="nama" value="Nama kategori" />
                                    <TextInput id="nama" type="text" placeholder="Nama kategori" v-model="Form.nama"
                                        class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.nama" />
                                </div>
                                <div class="col-span-full md:col-span-3">
                                    <InputLabel for="tanggal" value="Tanggal kategori" />

                                    <TextInput id="tanggal" type="date" placeholder="Tanggal kategori"
                                        v-model="Form.tanggal" class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.tanggal" />
                                </div>
                                <div class="col-span-full md:col-span-3  relative">
                                    <InputLabel for="Keterangan" value="Keterangan kategori" />

                                    <div class="bg-white">
                                        <quill-editor id="keterangan" contentType="html" theme="snow"
                                            v-model:content="Form.keterangan" placeholder="@keterangan"
                                            class="w-full text-gray-900" />
                                    </div>
                                    <InputError :message="Form.errors.keterangan" />
                                </div>
                                <div class="col-span-full md:col-span-3  relative">
                                    <InputLabel for="Status" value="Status Penilaian" />

                                    <div class="bg-white">
                                        <select id="departement" v-model="Form.status"
                                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                            <option value="">---Pilih---</option>
                                            <option value="aktif">aktif</option>
                                            <option value="tidak aktif">tidak aktif</option>
                                        </select>
                                    </div>
                                    <InputError :message="Form.errors.status" />
                                </div>

                                <div class="col-span-full sm:col-span-3">
                                    <label for="departement" class="text-sm">Departement</label>
                                    <select id="departement" v-model="DepartementId"
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                        <option value="">---Pilih---</option>
                                        <option v-for="col in departement" :value="col.id">{{ col.nama }}</option>
                                    </select>
                                    <InputError :message="Form.errors.departement_id" />

                                </div>

                            </div>

                        </fieldset>

                        <div class="flex flex-col md:flex-row gap-3 ">
                            <div class="relative overflow-x-auto mt-3">
                                <table class="w-full text-xs text-left rtl:text-right text-gray-500">
                                    <caption class="py-1 text-sm bg-primary text-white border-b border-white">Pilih
                                        Karyawan
                                    </caption>

                                    <thead class="text-xs text-white uppercase bg-primary ">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Karyawan
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Jabatan
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                CheckBox
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b" v-for="(item, index) in DataKaryawan"
                                            :key="index">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                                                {{ item.nama }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ item.jabatan }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <input id="default-checkbox" type="checkbox"
                                                    @change="addSliceArray(index, item)"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                                <label for="default-checkbox"
                                                    class="ms-2 text-sm font-medium text-gray-900 ">Pilih
                                                    Karyawan</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="relative overflow-x-auto mt-3">
                                <table class="w-full text-xs text-left rtl:text-right text-gray-500">
                                    <caption class="py-1 text-sm bg-primary text-white border-b border-white">Karyawan
                                        Terpilih
                                    </caption>
                                    <thead class="text-xs text-white uppercase bg-primary ">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Karyawan
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Jabatan
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                CheckBox
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b" v-for="(item, index) in CheckBoxKaryawan"
                                            :key="index">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                                                {{ item.nama }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ item.jabatan }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <button type="button" @click="deleteKaryawan(index, item)"
                                                    class="w-max text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>
                    <PrimaryButton type="submit" class="w-full text-center">
                        <span v-if="Form.processing" class="flex justify-center">
                            <fwb-spinner color="white" size="6" />
                        </span>
                        <span v-else class="w-full flex justify-center text-center">
                            Edit Data
                        </span>
                    </PrimaryButton>

                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
