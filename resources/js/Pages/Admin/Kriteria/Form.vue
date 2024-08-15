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
const page = usePage()

const props = defineProps({
    aspek: {
        type:Object,
        default: ()=>({}),
    }
})
const Form = useForm({
    aspek_id: '',
    nama: '',
    persentase: '',
    bobot: '',
    factory: '',
    nilai_target: '',
    sub_nama_kriteria: [],
    sub_bobot_kriteria: [],
})

function submit() {
    Form.post(route('Kriteria.store'), {
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

const showSub = ref(false);

const sumSub = ref(0);

watch(showSub, (value) => {
    if (value) {
        sumSub.value = 1;
    } else {
        sumSub.value = 0;
        Form.sub_nama_kriteria = [];
        Form.sub_bobot_kriteria = [];
    }
})

</script>

<template>

    <Head title="Kriteria Form" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Tambah Kriteria</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <PrimaryButton type="button" class="mb-3" @click="showSub = !showSub">Buat Sub Kriteria
                </PrimaryButton>
                <form @submit.prevent="submit()" novalidate="" action="" class="container mx-auto space-y-12">
                    <div class="flex">
                        <fieldset :class="showSub ? 'w-[60%]' : 'w-full'"
                            class=" grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                            <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                                <div class="col-span-full md:col-span-3">
                                    <InputLabel for="aspek_id" value="Aspek" />
                                    <select id="countries" v-model="Form.aspek_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">---------</option>
                                        <option v-for="col in aspek" :value="col.id"> {{ col.nama }} </option>
                                      </select>
                                    <InputError :message="Form.errors.aspek_id" />
                                </div>
                                <div class="col-span-full md:col-span-3">
                                    <InputLabel for="nama" value="Nama Kriteria" />
                                    <TextInput id="nama" type="text" placeholder="Nama Kriteria" v-model="Form.nama"
                                        class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.nama" />
                                </div>
                                <!-- <div class="col-span-full md:col-span-3">
                                    <InputLabel for="bobot" value="Bobot Kriteria" />

                                    <TextInput id="bobot" type="number" placeholder="Bobot Kriteria" v-model="Form.bobot"
                                        class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.bobot" />
                                </div> -->
                                <div class="col-span-full md:col-span-3">
                                    <InputLabel for="factory" value="Jenis Factory" />

                                    <select id="countries" v-model="Form.factory" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">---------</option>
                                        <option value="core">Core</option>
                                        <option value="secondary">Secondary</option>
                                      </select>
                                    <InputError :message="Form.errors.factory" />
                                </div>
                                <div class="col-span-full md:col-span-3">
                                    <InputLabel for="nilai_target" value="Nilai Target" />

                                    <TextInput id="nilai_target" type="number" placeholder="Nilai Target" v-model="Form.nilai_target"
                                        class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.nilai_target" />
                                </div>

                                <div class="col-span-full" v-if="showSub">
                                    <h2 class="border-y border-primary py-2">Sub Kriteria</h2>
                                    <ul class="list-item mt-2 space-y-3">
                                        <li v-for="(item, index) in sumSub" :key="item"
                                            class="border-b border-secondary pb-1">
                                            <div class="flex flex-row gap-2">
                                                <div class="w-1/2">
                                                    <InputLabel :for="'sub_kriteria' + item"
                                                        :value="'Nama Sub Kriteria :' + item" />

                                                    <TextInput :id="'sub_kriteria' + item" type="text" placeholder="...."
                                                        v-model="Form.sub_nama_kriteria[index]"
                                                        class="w-full text-gray-900" />
                                                </div>
                                                <div class="w-1/2">
                                                    <InputLabel :for="'bobot_sub_kriteria' + item"
                                                        :value="'Bobot Sub Kriteria :' + item" />

                                                    <TextInput :id="'bobot_sub_kriteria' + item" type="number"
                                                        placeholder="Masukkan Angka"
                                                        v-model="Form.sub_bobot_kriteria[index]"
                                                        class="w-full text-gray-900" />
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <InputError :message="Form.errors.sub_nama_kriteria" />
                                            <InputError :message="Form.errors.sub_bobot_kriteria" />

                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </fieldset>

                        <div class=" w-full md:w-[30%] flex flex-col px-4" v-if="showSub">
                            <a href="#"
                                class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">

                                <h5 class="mb-2 text-base font-bold tracking-tight text-gray-900">Keterangan Sub
                                    Kriteria</h5>
                                <p class="font-normal text-gray-700">Riwayat Pendidikan</p>
                                <ul class="list-decimal px-6">
                                    <li>SD = 1</li>
                                    <li>SMP = 2</li>
                                    <li>SMA = 3</li>
                                    <li>SARJANA = 4</li>


                                </ul>
                                <div>
                                    <PrimaryButton type="button" @click="sumSub++">Tambah Sub Kriteria</PrimaryButton>
                                </div>
                            </a>
                        </div>
                    </div>
                    <PrimaryButton type="submit" class="w-full text-center">
                        <span v-if="Form.processing" class="flex justify-center">
                            <fwb-spinner color="white" size="6" />
                        </span>
                        <span v-else class="w-full flex justify-center text-center">
                            Tambah Data
                        </span>
                    </PrimaryButton>

                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
