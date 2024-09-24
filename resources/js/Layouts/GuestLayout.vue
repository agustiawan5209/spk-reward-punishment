<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="bg-primary min-h-screen flex box-border justify-center items-center">
        <div class="bg-white rounded-2xl flex max-w-3xl p-5 items-center">
            <div class="md:w-1/2 px-8">
                <div class="text-sm font-semibold text-center pb-6">
                    <span class="text-green-800 md:text-xl">BAWASLU PROVINSI SULAWESI SELATAN</span>
                </div>
                <slot />
            </div>
            <div class="md:block hidden w-1/2">
                <img class="rounded-2xl max-h-[1600px]"
                    :src="'images/322737421_603143271820523_4051296088736822937_n.jpg'"
                    alt="login form image">
            </div>
        </div>
    </section>
</template>
