<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button } from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon, PencilAltIcon,PencilSquareIcon,EyeIcon,EllipsisVerticalIcon,Cog8ToothIcon } from '@heroicons/vue/24/solid'
import Swal from 'vue-sweetalert2';
import { useToast } from "vue-toastification";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

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
        Dropdown
    },
    props: {
        employees: Object,
    },
    setup() {
        const swal = Swal;
        const toast = useToast()

        return { swal,toast }
    },
    data() {
        return {
            
        }
    },
    methods: {
        deleteEmployee(userId) {
            this.$swal.fire(({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon:"warning",
                showCancelButton: true,
                buttonsStyling: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Yes, Delete it!"
            })).then((result) => { 
                if (result.value) { 
                    this.$inertia.delete(route('employee.destroy',userId),{
                        preserveScroll: true,
                        onSuccess: () => {
                            this.toast.success("Your post has been deleted!", {
                                
                            });
                        },
                    })
                }
            });
        },
        showUser(id) {
            this.$inertia.get(route('employee.show',id),{
                preserveScroll: true,
                onSuccess: () => {
                    
                },
            })
        }
    }

}

</script>

<template>
    <AppLayout title="Employee">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-16"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('employee.index')" class="text-gray-200 dark:text-white">
                            Employee
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <Link :href="route('employee.create')" class="text-gray-200 dark:text-white">
                        <Button
                            label="Create Employee"
                            variant="primary"
                        />
                    </Link>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 text-white font-medium group">    
                <Table :resource="employees">
                    <template #cell(positions)="{ item: employee }">
                        <span>{{ employee.positions['0'].name }}</span>
                    </template>
                    <template #cell(actions)="{ item: employee }">
                        <div class="flex">
                            <Dropdown align="right" width="36">
                                <template #trigger>
                                    
                                    <EllipsisVerticalIcon class="w-6 h-6 cursor-pointer" />
                                    <!-- <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                    </button> -->
                                </template>
                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Actions
                                    </div>
                                    <div>
                                        <DropdownLink :href="route('employee.edit',employee.id)">
                                            <PencilSquareIcon class="text-blue-600 w-4 h-4 float-left ml-2"/> Edit
                                        </DropdownLink>
                                    </div>
                                    <div>
                                        <DropdownLink href="">
                                            <TrashIcon class="text-rose-500 float-left ml-2 w-4 h-4" @click="deleteEmployee(employee.id)"/>Delete
                                        </DropdownLink>
                                        
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>