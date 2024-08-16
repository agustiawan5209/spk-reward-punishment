<script setup>
import CardStats from "@/Components/Card/CardStats.vue";
import { defineProps } from "vue";
import { usePage } from "@inertiajs/vue3";
const Page = usePage().props.auth;
const Roles = Page.role;
function roleToCheck(role) {
    if (Array.isArray(Roles)) {
        return Roles.includes(role)
    } else {
        return false;
    }
}
const props = defineProps({
    data: {
        type: Object,
        default: ()=>({}),
    },
});
</script>

<template>
    <!-- Header -->
    <div class="relative pb-3">
        <div class=" mx-auto w-full">
            <div>
                <!-- Card stats -->
                <div class="grid grid-cols-1 gap-4"
                    :class="roleToCheck('Admin') ? 'md:grid-cols-3' : 'md:grid-cols-2'">
                    <div class="w-full h-full  px-4">
                        <card-stats statSubtitle="Jumlah Karyawan" :statTitle="data.staff" statArrow="up" statPercent="3.48"
                            statPercentColor="text-emerald-500" statDescripiron="Since last month"
                            :statIconName="['fas', 'user-group']" statIconColor="bg-yellow-500" />
                    </div>
                    <div class="w-full h-full  px-4"  v-if="roleToCheck('Admin')">
                        <card-stats statSubtitle="Jumlah Evalusasi" :statTitle="data.evaluasi" statArrow="up" statPercent="3.48"
                            statPercentColor="text-emerald-500" statDescripiron="Since last month"
                            :statIconName="['fas', 'bars-progress']" statIconColor="bg-blue-500" />
                    </div>
                    <div class="w-full h-full  px-4">
                        <card-stats statSubtitle="Jumlah Departement" :statTitle="data.departement" statArrow="up" statPercent="3.48"
                            statPercentColor="text-emerald-500" statDescripiron="Since last month"
                            :statIconName="['fas', 'building']" statIconColor="bg-green-500" />
                    </div>
                    <div class="w-full h-full  px-4" v-if="roleToCheck('Staff') || roleToCheck('Kepala Bagian')">
                        <card-stats statSubtitle="Jumlah Punishment" :statTitle="data.punishment" statArrow="up" statPercent="3.48"
                            statPercentColor="text-emerald-500" statDescripiron="Since last month"
                            :statIconName="['fas', 'sack-xmark']" statIconColor="bg-red-500" />
                    </div>
                    <div class="w-full h-full  px-4" v-if="roleToCheck('Staff') || roleToCheck('Kepala Bagian')">
                        <card-stats statSubtitle="Jumlah reward" :statTitle="data.reward" statArrow="up" statPercent="3.48"
                            statPercentColor="text-emerald-500" statDescripiron="Since last month"
                            :statIconName="['fas', 'gift']" statIconColor="bg-blue-500" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
