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

})
const Form = useForm({
    nama: '',
    persentase: '',
    bobot: '',
    core_factory: '',
    secondary_factory: '',
})

function submit() {
    Form.post(route('Aspek.store'), {
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
    });
}



</script>

<template>

    <Head title="Aspek Form" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Tambah Aspek Penilaian</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action="" class="container mx-auto space-y-12">
                    <div class="flex">
                        <fieldset :class="showSub ? 'w-[60%]' : 'w-full'"
                            class=" grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                            <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                                <div class="col-span-full">
                                    <InputLabel for="nama" value="Nama Aspek" />
                                    <TextInput id="nama" type="text" placeholder="Nama Aspek" v-model="Form.nama"
                                        class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.nama" />
                                </div>
                                <div class="col-span-full">
                                    <InputLabel for="persentase" value="Persentase Aspek" />

                                    <TextInput id="persentase" type="number" placeholder="Persentase Aspek"
                                        v-model="Form.persentase" class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.persentase" />
                                </div>
                                <div class="col-span-full">
                                    <InputLabel for="bobot" value="Bobot Aspek Penilaian" />

                                    <TextInput id="bobot" type="number" placeholder="Bobot Aspek" v-model="Form.bobot"
                                        class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.bobot" />
                                </div>
                                <div class="col-span-full">
                                    <InputLabel for="core_factory" value="Core Factory(%)" />

                                    <TextInput id="core_factory" type="number" placeholder="Bobot Aspek" v-model="Form.core_factory"
                                        class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.core_factory" />
                                </div>
                                <div class="col-span-full">
                                    <InputLabel for="secondary_factory" value="Secondary Factory(%)" />

                                    <TextInput id="secondary_factory" type="number" placeholder="Bobot Aspek" v-model="Form.secondary_factory"
                                        class="w-full text-gray-900" />
                                    <InputError :message="Form.errors.secondary_factory" />
                                </div>
                            </div>

                        </fieldset>
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
