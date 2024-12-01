<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, defineProps } from 'vue';
import {
    FwbSpinner,
} from 'flowbite-vue'
const props = defineProps({
    jabatan: {
        type: Object,
        default: () => ({})
    },
    departement: {
        type: Object,
        default: () => ({})
    },
})
const Form = useForm({
    kode_pegawai: '',
    name: '',
    alamat: '',
    username: '',
    jabatan: '',
    departement_id: '',
    email: '',
    password: '',
    no_telpon: '',
})

function submit() {
    Form.post(route('Staff.store'), {
        onError: (err) => {
            console.log(err)
        }
    });
}


</script>

<template>

    <Head title="Tambah Karyawan" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Tambah Karyawan</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3">
                                <label for="kode_pegawai" class="text-sm">Kode Pegawai</label>
                                <TextInput id="kode_pegawai" type="text" placeholder="kode_pegawai lengkap" v-model="Form.kode_pegawai"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.kode_pegawai" />
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="firstname" class="text-sm">Nama Lengkap</label>
                                <TextInput id="firstname" type="text" placeholder="nama lengkap" v-model="Form.name"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.name" />
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="no_telpon" class="text-sm">No. Telepon</label>
                                <TextInput id="no_telpon" type="text" v-model="Form.no_telpon" placeholder="No. telpon"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.no_telpon" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="departement" class="text-sm">Departement</label>
                                <select id="departement" v-model="Form.departement_id"
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option value="">---Pilih---</option>
                                    <option v-for="col in departement" :value="col.id">{{ col.nama }}</option>
                                </select>
                                <InputError :message="Form.errors.departement_id" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="jabatan" class="text-sm">Jabatan</label>
                                <select id="jabatan" v-model="Form.jabatan"
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option value="">---Pilih---</option>
                                    <option v-for="col in jabatan" :value="col.name">{{ col.name }}</option>
                                </select>
                                <InputError :message="Form.errors.jabatan" />

                            </div>


                            <div class="col-span-full">
                                <label for="alamat" class="text-sm">Alamat</label>
                                <TextInput id="alamat" type="text" v-model="Form.alamat" placeholder=""
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.alamat" />

                            </div>
                            <div class="col-span-full sm:col-span-2">
                                <label for="username" class="text-sm">username</label>
                                <TextInput id="username" type="text" v-model="Form.username" placeholder="@username"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.username" />

                            </div>
                            <div class="col-span-full sm:col-span-2">
                                <label for="state" class="text-sm">Password</label>
                                <TextInput id="state" type="text" placeholder="" v-model="Form.password"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.password" />

                            </div>
                            <div class="col-span-full sm:col-span-2">
                                <label for="email" class="text-sm">Email</label>
                                <TextInput id="email" type="email" placeholder="" v-model="Form.email"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.email" />

                            </div>
                        </div>
                        <PrimaryButton type="submit" class="col-span-full text-center">
                            <span v-if="Form.processing" class="flex justify-center">
                                <fwb-spinner color="blue" size="6" />
                            </span>
                            <span v-else class="flex justify-center">
                                Tambah Data
                            </span>
                        </PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
