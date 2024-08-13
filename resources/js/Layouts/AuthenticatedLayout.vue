<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar/Sidebar.vue';


const user = usePage().props.auth.user;

const showingNavigationDropdown = ref(false);
function getWindows() {
    return window.innerWidth;
}

window.addEventListener('resize', () => {
    const newWindowWidth = window.innerWidth;
    const newWindowHeight = window.innerHeight;
});
</script>

<template>

    <transition-group name="nested">
        <aside v-if="showingNavigationDropdown" key="mobile"
            class="fixed top-0 z-10 ml-0 flex h-screen w-full flex-col justify-between border-r bg-white transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%] overflow-y-auto">
            <button class="-mr-2 mt-5 h-16 w-12 border-r lg:hidden"
                @click="showingNavigationDropdown = !showingNavigationDropdown">
                <svg xmlns="http://www.w3.org/2000/svg" class="my-auto h-6 w-6 transition-all" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="flex flex-col w-full h-full !bg-primary text-white">
                <div class="flex flex-col items-center justify-center bg-secondary">
                    <img class="inline-block w-8 h-8 object-cover rounded-full ring-2 ring-white" :src="user.profile_photo_path"
                        alt="">
                </div>

                <Sidebar />
            </div>
        </aside>
        <aside key="dekstop"
            class="fixed top-0 z-10 ml-[-100%] flex h-screen w-full flex-col justify-between border-r bg-white transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%] overflow-y-auto">

            <div class="flex flex-col w-full h-full !bg-primary text-white">
                <div class="flex flex-col items-center py-6 gap-7 justify-center bg-secondary">
                    <img v-if="user.profile_photo" class="inline-block w-20 h-20 object-cover rounded-full ring-2 ring-white" :src="user.profile_photo_path" alt="">

                        <img v-else class="inline-block w-20 h-20 rounded-full ring-2 ring-white" :src="'/images/vecteezy_profile-icon-design-vector_5544718.jpg'" alt="">

                    <h1 class="text-xl font-bold text-center">{{ user.name }} - {{user.staff?user.staff.nama_departement: 'Admin'}}</h1>
                </div>

                <Sidebar />
            </div>
        </aside>
    </transition-group>
    <div class="ml-auto mb-6 lg:w-[75%] xl:w-[80%] 2xl:w-[85%] ">
        <div class="sticky top-0 h-16 border-b bg-primary lg:py-2.5 z-[100]">
            <div class="flex items-center justify-between space-x-4 px-6 2xl:container">

                <h5 hidden class="text-2xl font-medium !text-white lg:block">
                    <slot name="header" />
                </h5>
                <button class="-mr-2 h-16 w-12 border-r lg:hidden"
                    @click="showingNavigationDropdown = !showingNavigationDropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" class="my-auto h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex space-x-4">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button v-if="user.profile_photo" type="button"
                                        class="inline-flex items-center rounded-full border border-transparent text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <img class="inline-block w-8 h-8 object-cover rounded-full ring-2 ring-white"
                                            :src="user.profile_photo_path" alt="">
                                    </button>
                                    <button v-else type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ $page.props.auth.user.name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')"> Data Diri </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Keluar
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-2 pt-6 2xl:container relative">
            <slot />
        </div>
    </div>
</template>
<style>
/* delay leave of parent element */
.nested-leave-active {
    transition-delay: 0.25s;
}

.nested-enter-from,
.nested-leave-to {
    transform: translateY(30px);
    opacity: 0;
}

/* we can also transition nested elements using nested selectors */
.nested-enter-active .aside-anime,
.nested-leave-active .aside-anime {
    transition: all 0.3s ease-in-out;
}

/* delay enter of nested element */
.nested-enter-active .aside-anime {
    transition-delay: 0.25s;
}

.nested-enter-from .aside-anime,
.nested-leave-to .aside-anime {
    transform: translateX(30px);
    /*
        Hack around a Chrome 96 bug in handling nested opacity transitions.
      This is not needed in other browsers or Chrome 99+ where the bug
      has been fixed.
    */
    opacity: 0.001;
}
</style>
