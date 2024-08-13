<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch, defineProps, inject } from 'vue';
const swal = inject('$swal')
const props = defineProps({
    kategori: {
        type: Object,
        default: () => ({}),
    },
    aspek: {
        type: Object,
        default: () => ({}),
    },
    kriteria: {
        type: Object,
        default: () => ({}),
    },
    aspek_kriteria: {
        type: Object,
        default: () => ({}),
    },
})
const dateNow = new Date().toISOString().slice(0, 10);
const aspekID = ref('')
const aspekForm = useForm({
    aspek_id: '',
})

watch(aspekID, (value) => {
    aspekForm.aspek_id = value;
    aspekForm.get(route('Penilaian.create', { kategori: props.kategori.id }), {
        preserveState: true,
        // preserveScroll: true,
        onFinish: () => {
            console.log(props.kriteria)
        }
    })
})

const Penilaian_karyawan = ref([]);

if (props.kategori.alternatif.length > 0 && props.kriteria.length > 0) {

    const dataKaryawan = [...props.kategori.alternatif]; // Use spread operator to create a new array
    // Jadikan Kriteria ke dalam bentuk array
    const Datakriteria = [...props.kriteria];
    const kriteriaObject = Datakriteria.reduce((acc, curr, i) => ({
        ...acc, [i]: {
            kriteria_id: curr.id,
            kriteria: curr,
            bobot: [],
        }
    }), {}); // Create an object with kriteria as keys and empty
    // buat array dari value karyawan
    dataKaryawan.forEach((element, index) => {
        Penilaian_karyawan.value[index] = {
            staffId: element.staff,
            staff_id: element.staff.id,
            kriteria: { ...kriteriaObject } // Use spread operator to create a new object
        }
    });
};
const Form = useForm({
    kategori: props.kategori.id,
    aspek_id: aspekID.value,
    tgl_penilaian: dateNow,
    kriteria: [],
})

function BobotPenilaian(index, idx, value) {
    const bobot = value.target.value;

    // Masukkan Bobot Value dari matrix karyawan
    Penilaian_karyawan.value[index].kriteria[idx].bobot = bobot;
}


function submit() {
    Form.kriteria = Penilaian_karyawan.value;
    Form.aspek_id = aspekForm.aspek_id;
    Form.post(route('Penilaian.store'), {
        onError: (err) => {
            var txt = "<ul>"
            Object.keys(err).forEach((item, val) => {
                txt += `<li>${err[item]}</li>`
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
    })
}
</script>

<template>

    <Head title="Form Penilaian" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Penilaian {{ kategori.nama }} </h2>
        </template>

        <div class="py-4 relative box-content">
            <!-- component -->
            <div class="container mx-auto bg-white">
                <div class="flex flex-col">
                    <form @submit.prevent="submit()" class="md:px-4 rounded-md border py-2">
                        <div class="relative w-full inline-block align-middle overflow-hidden">
                            <div class="grid grid-cols-2 gap-7 items-center">

                                <div class="relative  text-gray-500 focus-within:text-gray-900 mb-4">
                                    <InputLabel for="tgl_penilaian" value="Aspek yang Dinilai" />
                                    <select v-model="aspekID" name="aspek_id" id="aspek_id"
                                        class="px-2 py-1 md:px-3 md:py-2 placeholder-gray-400 border focus:outline-none sm:w-40 sm:text-sm border-gray-200 shadow-sm rounded-lg focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none ">
                                        <option value="">-----</option>
                                        <option v-for="col in aspek" :value="col.id">{{ col.nama }}</option>
                                    </select>
                                </div>
                                <div class="relative  text-gray-500 focus-within:text-gray-900 mb-4">
                                    <InputLabel for="tgl_penilaian" value="Tanggal Penilaian" />
                                    <TextInput type="date" v-model="Form.tgl_penilaian" :readonly="true" />
                                </div>
                            </div>
                            <div class="w-full overflow-x-auto">
                                <table class=" min-w-full rounded-xl">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th scope="col"
                                                class="p-5 text-left text-xs leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">
                                                Nama Karyawan </th>
                                            <th scope="col"
                                                class="p-5 text-left text-xs leading-6 font-semibold text-gray-900 capitalize">
                                                Departement - Jabatan </th>
                                            <th scope="col" v-for="kr in kriteria"
                                                class="p-5 text-left text-xs leading-6 font-semibold text-gray-900 capitalize">
                                                {{ kr.nama }} </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300 ">
                                        <tr class="bg-white transition-all duration-500 hover:bg-gray-50"
                                            v-for="(item, index) in kategori.alternatif">
                                            <td
                                                class="p-5 whitespace-nowrap text-xs leading-6 font-medium text-gray-900 ">
                                                {{ item.staff.nama }}

                                            </td>
                                            <td
                                                class="p-5 whitespace-nowrap text-xs leading-6 font-medium text-gray-900">
                                                {{ item.staff.departement.nama }} - {{ item.staff.jabatan }} </td>
                                            <td v-for="(col, idx) in kriteria"
                                                class="p-5 whitespace-nowrap text-xs leading-6 font-medium text-gray-900">
                                                <select :name="col.nama" :id="col.nama" required
                                                    @change="BobotPenilaian(index, idx, $event)"
                                                    class="px-2 py-1 md:px-3 md:py-2 placeholder-gray-400 border focus:outline-none sm:w-40 sm:text-sm border-gray-200 shadow-sm rounded-lg focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none ">
                                                    <option value="">-----</option>
                                                    <option v-for="sub in col.subkriteria" :value="sub.bobot">{{
                                                        sub.nama }}
                                                    </option>
                                                </select>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <PrimaryButton type="submit" class="w-full mt-5">
                            <span class="w-full text-center">Simpan</span>
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
