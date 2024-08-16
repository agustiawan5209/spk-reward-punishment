<script setup>
import { defineProps } from 'vue';
const props = defineProps(['perhitungan', 'aspek'])


function hitungNilaiTotal(core, secondary, cf, sf) {
    return `((${core} / 100) * ${cf}) + ((${secondary} / 100) * ${sf})`;
}
</script>

<template>
    <div class="col-span-full overflow-x-auto mt-3">
        <table class="w-full text-xs text-left rtl:text-right text-gray-500">
            <caption class="text-lg text-black">Aspek Dan Kriteria Penilaian</caption>
            <thead class="text-xs text-white uppercase bg-primary ">
                <tr>
                    <th class="px-6 py-3">
                        Nama Kriteria
                    </th>
                    <th class="px-6 py-3">
                        Jenis Factory
                    </th>
                    <th class="px-6 py-3">
                        Profile Ideal (Nilai Target)
                    </th>


                </tr>

            </thead>
            <tbody>
                <tr v-for="item in aspek.kriteriapenilaian">
                    <th scope="col" class="px-6 py-3" >
                        {{ item.nama }}
                    </th>
                    <th scope="col" class="px-6 py-4 font-medium text-sm capitalize whitespace-nowrap">
                        {{ item.factory }}
                    </th>
                    <th scope="col" class="px-6 py-4 font-medium text-sm capitalize whitespace-nowrap">
                        {{ item.nilai_target }}
                    </th>
                </tr>
            </tbody>
        </table>
        <table class="w-full text-xs text-left rtl:text-right text-gray-500 mt-10">
            <caption class="text-lg text-black">Hasil Penilaian</caption>
            <thead class="text-xs text-white uppercase bg-primary ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Karyawan/Staff
                    </th>
                    <th scope="col" class="px-6 py-3" v-for="item in aspek.kriteriapenilaian">
                        {{ item.nama }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b" v-for="(item, index) in perhitungan.matrix_penilaian" :key="index">
                    <th scope="row" class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                        {{ index }}
                    </th>
                    <td class="px-6 py-4" v-for="col in item">
                        {{ col }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="w-full text-xs text-left rtl:text-right text-gray-500 mt-10">
            <caption class="text-lg text-black">Nilai Selisih Gap (Gap=Nilai Ideal−Nilai Aktual)</caption>
            <thead class="text-xs text-white uppercase bg-primary ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Karyawan/Staff
                    </th>
                    <th scope="col" class="px-6 py-3" v-for="item in aspek.kriteriapenilaian">
                        {{ item.nama }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b" v-for="(item, index) in perhitungan.hitung_selisih" :key="index">
                    <th scope="row" class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                        {{ index }}
                    </th>
                    <td class="px-6 py-4" v-for="col in item">
                        {{ col }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="w-full text-xs text-left rtl:text-right text-gray-500 mt-10">
            <caption class="text-lg text-black">
                <span>Nilai Pada Factory</span>
                <!-- <p>Nilai Pada Factory Dihitung dari jumlah factory yang sama lalu dilakukan dengan</p> -->
            </caption>
            <thead class="text-xs text-white uppercase bg-primary ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Karyawan/Staff
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Core Factory (CF)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Secondary Factory (SF)
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="col" class="px-6 py-3">
                        -
                    </th>
                    <th scope="col" class="px-6 py-3 bg-primary text-white">
                        Nilai = {{ aspek.core_factory }}
                    </th>
                    <th scope="col" class="px-6 py-3 bg-primary text-white">
                        Nilai = {{ aspek.secondary_factory }}

                    </th>
                </tr>
                <tr class="bg-white border-b" v-for="(item, index) in perhitungan.matrix_factory" :key="index">
                    <th scope="row" class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                        {{ index }}
                    </th>
                    <td class="px-6 py-4" v-for="col in item">
                        {{ col }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="w-full text-xs text-left rtl:text-right text-gray-500 mt-10">
            <caption class="text-lg text-black">Nilai Total</caption>
            <thead class="text-xs text-white uppercase bg-primary ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Karyawan/Staff
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nilai Total
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b" v-for="(item, index) in perhitungan.matrix_total" :key="index">
                    <th scope="row" class="px-6 py-4 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                        {{ index }}
                    </th>
                    <td class="px-6 py-4">
                        {{ hitungNilaiTotal(aspek.core_factory, aspek.secondary_factory, perhitungan.matrix_factory[index][0], perhitungan.matrix_factory[index][1]) }}=
                        <span class="font-semibold">{{ item }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
