<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button } from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon, PencilAltIcon,PencilSquareIcon,EyeIcon,
    EllipsisVerticalIcon,Cog8ToothIcon,ArrowDownTrayIcon } from '@heroicons/vue/24/solid'
import Swal from 'vue-sweetalert2';
import { useToast } from "vue-toastification";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import moment from 'moment';

export default {
    components: {
        AppLayout,
        Head,
        Link,
        Alert, 
        Button,
        HomeIcon,
        ChevronRightIcon,
        EllipsisVerticalIcon,
        Cog8ToothIcon,
        UserIcon,
        TrashIcon,
        PencilAltIcon,
        PencilSquareIcon,
        EyeIcon,
        Table,
        DropdownLink,
        Dropdown,
        ArrowDownTrayIcon
    },
    props: {
        attendances: Object,
    },
    setup() {
        const swal = Swal;
        const toast = useToast()

        return { swal,toast }
    },
    data() {
        return {
            today:moment(new Date()).format("YYYY-MM-DD")
        }
    },
    methods: {
        // deleteEmployee(userId) {
        //     this.$swal.fire(({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         icon:"warning",
        //         showCancelButton: true,
        //         buttonsStyling: true,
        //         confirmButtonColor: "#3085d6",
        //         confirmButtonText: "Yes, Delete it!"
        //     })).then((result) => { 
        //         if (result.value) { 
        //             this.$inertia.delete(route('employee.destroy',userId),{
        //                 preserveScroll: true,
        //                 onSuccess: () => {
        //                     this.toast.success("Your post has been deleted!", {
                                
        //                     });
        //                 },
        //             })
        //         }
        //     });
        // },
        // showUser(id) {
        //     this.$inertia.get(route('employee.show',id),{
        //         preserveScroll: true,
        //         onSuccess: () => {
                    
        //         },
        //     })
        // }
    }

}

</script>

<template>
    <AppLayout title="Attendance">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4 py-3">
                    <span class="ml-16"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-1 mt-1">
                        <Link :href="route('attendance.index')" class="text-gray-200 dark:text-white">
                            Attendance
                        </Link>
                    </span>
                </div>
                <div class="text-right border px-6 py-1.5 rounded-md bg-rose-500 hover:bg-rose-600">
                    <a :href="route('attendance.export.excel')+'?data='+this.today" class="text-white dark:text-white flex">
                        <ArrowDownTrayIcon class="w-5 h-5" /><span class="ml-2">Excel</span>
                    </a>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium group">    
                <Table :resource="attendances">
                    {{  attendances  }}
                    <template #cell(id)="{ item: key }">
                        <span>{{ key.id }}</span>
                    </template>
                    <template #cell(employee_name)="{ item: attendance }">
                        <span>{{ attendance.employee.first_name }}</span>
                    </template>
                    <template #cell(employee_gender)="{ item: attendance }">
                        <span>{{ attendance.employee.gender }}</span>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>