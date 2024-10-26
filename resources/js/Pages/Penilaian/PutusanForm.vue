<script setup>
import { ref, defineProps, defineEmits, inject } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import { FwbSpinner } from 'flowbite-vue';
const swal = inject('$swal')
const page = usePage()
/**
 * Properti untuk mengatur data staff
 * @type {Array|Object}
 * @default []
 */
const props = defineProps({
    staff: {
        type: [Array, Object], // Mendukung Array atau Object, tergantung pengiriman data
        default: () => ([]), // Default adalah array kosong
    },
    kategori: {
        type: Object,
        default: () => ({})
    },
});

/**
 * Fungsi untuk mengambil tanggal sekarang
 * @returns {string} Tanggal sekarang dalam format YYYY-MM-DD
 */
const dateNow = new Date().toISOString().slice(0, 10);

/**
 * Fungsi untuk mengambil 3 staff teratas untuk reward
 * @returns {Array} 3 staff teratas untuk reward
 */
const staff_reward = props.staff.slice(0, 1)
let batas = staff_reward[1]['hasil'] + 0.2;

/**
 * Fungsi untuk mengambil 3 staff terbawah untuk punishment
 * @returns {Array} 3 staff terbawah untuk punishment
 */
const staff_punishment = props.staff.filter(function(staff){
    return staff.hasil >= batas;
})

/**
 * Fungsi untuk menginisialisasi data putusan reward
 * @returns {Array} Data putusan reward
 */
const putusan_reward = ref([]);
for (let i = 0; i < staff_reward.length; i++) {
    putusan_reward.value.push({
        staff: staff_reward[i].staff,
        point: staff_reward[i].hasil,
        putusan: "reward",
        alasan: 'Keterangan Reward'
    })
}

/**
 * Fungsi untuk menginisialisasi data putusan punishment
 * @returns {Array} Data putusan punishment
 */
const putusan_punishment = ref([]);
for (let i = 0; i < staff_punishment.length; i++) {
    putusan_punishment.value.push({
        staff: staff_punishment[i].staff,
        point: staff_punishment[i].hasil,
        putusan: "punishment",
        alasan: 'Keterangan Punishment',
    })
}

/**
 * Fungsi untuk menggabungkan data putusan reward dan punishment
 * @returns {Array} Data putusan gabungan
 */
const staff_pr = ref(putusan_reward.value.concat(putusan_punishment.value));

/**
 * Fungsi untuk membuat form keputusan
 * @returns {Object} Form keputusan
 */
const Form = useForm({
    kategori_id: props.kategori.id,
    kategori: props.kategori,
    staff: staff_pr,
    tgl_putusan: dateNow,
})

/**
 * Fungsi untuk menampilkan modal
 * @param {boolean} show - Apakah modal harus ditampilkan
 */
const modalShow = ref(false);
function closeModal() {
    modalShow.value = false;
}
function showModal() {
    modalShow.value = true;
}

const emit = defineEmits(['close']);

const handleClose = () => {
  emit('close'); // Emit event untuk memberitahu parent agar modal ditutup
};

/**
 * Fungsi untuk mengirim form keputusan
 * @param {Object} err - Error yang terjadi saat mengirim form
 */
function submit() {
    Form.staff = putusan_reward.value.concat(putusan_punishment.value);
    Form.post(route('Keputusan.store'), {
        onFinish: () => {
            handleClose();

            if (page.props.message !== null) {
                swal({
                    icon: "success",
                    title: 'Berhasil',
                    text: page.props.message,
                    showConfirmButton: true,
                    timer: 2000
                });
            }
        },
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
    })
}
</script>

<template>
    <div class="w-full mx-auto px-4 py-6">
        <div class="w-full overflow-x-auto mt-3 px-1" >
            <PrimaryButton type="button" class="!bg-red-500 mt-2" @click="handleClose">Batalkan</PrimaryButton>
            <div class="">
                <div class="col-span-1 md:col-span-full grid grid-cols-1 sm:grid-cols-2 gap-6 py-2">
                    <div>
                        <InputLabel for="tgl_putusan" value="Tanggal Pemberian Punishment Dan Reward" />
                        <TextInput type="date" id="tgl_putusan" class="w-full my-2" required v-model="Form.tgl_putusan" />
                        <InputError :messsage="Form.errors.tgl_putusan" />
                    </div>

                </div>
                <table class="w-full text-xs text-center text-gray-500 border">
                    <thead class="text-xs text-white uppercase bg-primary ">
                        <tr>
                            <th scope="col" class="px-1 py-3">
                                Departement
                            </th>
                            <th scope="col" class="px-1 py-3">
                                Nama Karyawan
                            </th>
                            <th scope="col" class="px-1 py-3">
                                Jabatan
                            </th>
                            <th scope="col" class="px-1 py-3">
                                Jenis Putusan
                            </th>
                            <th scope="col" class="px-1 py-3">
                                Alasan Putusan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b" v-for="(item, index) in staff_pr" :key="index">
                            <th scope="row" class="px-1 py-1 font-medium text-sm capitalize text-gray-900 whitespace-nowrap">
                                {{ item.staff.nama_departement }}
                            </th>
                            <td class="px-1 py-1">
                                {{ item.staff.nama }}
                            </td>
                            <td class="px-1 py-1">
                                {{ item.staff.jabatan }}
                            </td>
                            <td class="px-1 py-1">
                                <span class="font-bold tracking-wide text-base capitalize">{{ item.putusan }}</span>
                            </td>
                            <td class="px-1 py-1">
                                <div class="bg-white">
                                    <quill-editor id="keterangan" contentType="html" v-model:content="staff_pr[index].alasan"
                                        theme="snow" placeholder="@keterangan" required class="w-full text-gray-900" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-full ">
                    <PrimaryButton type="button" @click="showModal()"
                        class="w-full flex flex-row items-center justify-center gap-2">
                        <span class="text-center">Simpan Data</span>
                        <font-awesome-icon :icon="['fas', 'floppy-disk']" class="text-white" />
                    </PrimaryButton>
                </div>

                <Modal :show="modalShow">
                    <div class="border rounded-lg shadow relative max-w-full">
                        <div class="flex justify-end p-2">
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="flex justify-center items-center" v-if="Form.processing">
                            <fwb-spinner color="white" size="12" />

                        </div>
                        <div class="p-6 pt-0 text-center" v-else>
                            <svg class="w-20 h-20 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-xl font-normal text-gray-500 mt-5 mb-6">Apakah anda yakin ingin menyimpan data hasil
                                putusan {{ kategori.nama }}?</h3>
                            <a href="#" @click="submit()"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                                Ya, Saya Yakin


                            </a>
                            <a href="#" @click="closeModal()"
                                class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-cyan-200 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center">
                                Batalkan
                            </a>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </div>

</template>
