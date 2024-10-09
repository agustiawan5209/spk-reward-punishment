<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, defineProps, watch, onMounted, inject } from 'vue';
import Perhitungan from './Perhitungan.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import PutusanForm from './PutusanForm.vue';
const page = usePage();
const swal = inject('$swal');
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
const props = defineProps({
    kategori: {
        type: Object,
        default: () => ({})
    },
    penilaian: {
        type: Object,
        default: () => ({})
    },
    aspek: {
        type: Object,
        default: () => ({})
    },
    perhitungan: {
        type: Object,
        default: () => ({})
    },
    keputusan: {
        type: Object,
        default: () => ({})
    },
    can: {
        type: Object,
        default: () => ({})
    },
    rank: {
        type: [Array, Object], // Mendukung Array atau Object, tergantung pengiriman data
        default: () => ([]), // Default adalah array kosong
    },
})
const dataPenilai = [...props.kategori.penilaian];

function findSameItem(array) {
    const count = {};

    array.forEach(item => {
        if (count[item.staff_penilai_id]) {
            count[item.staff_penilai_id]++;
        } else {
            count[item.staff_penilai_id] = 1;
        }
    });

    return count;
}
let Rank = [];
if (Array.isArray(props.rank)) {
    Rank = [...props.rank]; // Spread operator digunakan untuk membuat salinan array
} else if (typeof props.rank === 'object') {
    // Jika props.rank adalah objek, kamu bisa mengonversinya menjadi array
    Rank = Object.values(props.rank);
}

const HasilRank = Rank // Urutkan array berdasarkan properti 'hasil'

// Caridata yang memiliki nilai yang sama
function uniqueField(array) {
    const seen = new Set();
    const result = [];

    array.forEach(item => {
        if (!seen.has(item.staff_penilai_id)) {
            seen.add(item.staff_penilai_id);
            result.push(item);
        }
    });

    return result.length;
}

const Penilai = uniqueField(dataPenilai);

const tabAction = ref(2);
const tabActive = 'inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none';
const tabNonActive = 'inline-block w-full p-4 bg-white border-r border-gray-200 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none';


const varPutusan = ref(false);
function showPutusan() {
    varPutusan.value = !varPutusan.value
}

const handleClose = () => {
    varPutusan.value = false; // Emit event untuk memberitahu parent agar modal ditutup
};
</script>

<template>

    <Head title="Riwayat Penilaian" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Detail Riwayat Penilaian</h2>
        </template>

        <div class="md:py-4 relative box-content">
            <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3 ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail Riwayat Penilaian</span>
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
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Jumlah Penilaian Yang Masuk :</td>
                                        <td class="text-sm border-b text-gray-900"> {{ Penilai }}
                                        </td>
                                    </tr>
                                </table>
                            </div>


                            <div class="col-span-full sm:col-span-3">
                                <div class="sm:hidden">
                                    <label for="tabs" class="sr-only">------</label>
                                    <select id="tabs"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="0">Data Karyawan</option>
                                        <option value="1">Perhitungan</option>
                                        <option value="2">Hasil</option>
                                        <option value="3">Putusan</option>
                                    </select>
                                </div>
                                <ul
                                    class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex">
                                    <li class="w-full focus-within:z-10" @click="tabAction = 0">
                                        <a href="#" :class="tabAction == 0 ? tabActive : tabNonActive"
                                            aria-current="page" class="text-xs">Data
                                            Karyawan</a>
                                    </li>
                                    <li class="w-full focus-within:z-10" @click="tabAction = 1">
                                        <a href="#" :class="tabAction == 1 ? tabActive : tabNonActive">Perhitungan</a>
                                    </li>
                                    <li class="w-full focus-within:z-10" @click="tabAction = 2">
                                        <a href="#" :class="tabAction == 2 ? tabActive : tabNonActive">Hasil</a>
                                    </li>
                                    <li class="w-full focus-within:z-10" @click="tabAction = 3">
                                        <a href="#" :class="tabAction == 3 ? tabActive : tabNonActive">Putusan</a>
                                    </li>
                                </ul>

                            </div>
                            <transition-group>
                                <div class="col-span-full overflow-x-auto mt-3" v-if="tabAction == 0">
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
                                <div class="col-span-full overflow-x-auto mt-3" v-if="tabAction == 1">
                                    <Perhitungan :perhitungan="perhitungan" :aspek="aspek" />
                                </div>
                                <div class="col-span-full overflow-x-auto mt-3" v-if="tabAction == 2">
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
                                                <th scope="col" class="px-6 py-3">
                                                    Point
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white border-b" v-for="(item, index) in HasilRank"
                                                :key="index">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                                                    {{ item.staff.nama_departement }}
                                                </th>
                                                <td class="px-6 py-4 text-sm">
                                                    {{ item.staff.nama }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.staff.jabatan }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.hasil }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-span-full overflow-x-auto mt-3" v-if="tabAction == 3">
                                    <div class="inline-block" v-if="keputusan.length == 0 && Penilai > 0  && can.add">
                                        <p class="text-sm text-gray-500">Keterangan : Menyimpan Data Penilaian
                                            {{ kategori.nama }}
                                            <br>
                                            Menyimpan Data Akan menyebabkan penilaian saat ini menjadi non-aktif dan
                                            karyawan tidak
                                            dapat membuat penilaian lagi.
                                        </p>
                                        <PrimaryButton type="button" class="my-5" @click="showPutusan()">Buat Keputusan
                                        </PrimaryButton>
                                    </div>
                                    <table class="w-full text-xs text-left rtl:text-right text-gray-500">
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
                                                    <th scope="col" class="px-6 py-3">
                                                        Point
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Jenis Putusan
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        alasan
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-white border-b" v-for="(item, index) in keputusan"
                                                    :key="index">
                                                    <th scope="row"
                                                        class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                                                        {{ item.karyawan.nama_departement }}
                                                    </th>
                                                    <td class="px-6 py-4 text-sm">
                                                        {{ item.karyawan.nama }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.karyawan.jabatan }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.point }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.jenis_putusan }}
                                                    </td>
                                                    <td class="px-6 py-4" v-html="item.alasan">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </table>
                                </div>
                            </transition-group>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>

        <!-- Modal Form Buat Keputusan -->
        <Modal :show="varPutusan" maxWidth="7xl">

            <PutusanForm :staff="HasilRank" :kategori="kategori" @close="varPutusan = false"></PutusanForm>
        </Modal>
        <!--  -->
    </AuthenticatedLayout>
</template>
