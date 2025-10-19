<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button,DropdownMenu, DropdownOption } from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon,PencilSquareIcon,PencilIcon,EyeIcon } from '@heroicons/vue/24/solid'
import Swal from 'vue-sweetalert2';
import { useToast } from "vue-toastification";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";

export default {
    components: {
        AppLayout,
        Table,
        Head,
        Link,
        Alert, 
        Button,
        HomeIcon,
        ChevronRightIcon,
        UserIcon,
        TrashIcon,
        PencilIcon,
        EyeIcon,
        DropdownMenu, DropdownOption,
        PencilSquareIcon
    },
    props: {
        roles: Object,
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
        deleteUser(userId) {
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
                    this.$inertia.delete(route('roles.destroy',userId),{
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
            this.$inertia.get(route('roles.show',id),{
                preserveScroll: true,
                onSuccess: () => {
                    
                },
            })
        }
    }

}

</script>

<template>
    <AppLayout title="Roles">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-12"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('roles.index')" class="text-gray-200 dark:text-white">
                            Roles
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <Link v-if="can('roles.create') || is_superAdmin('super-admin')" :href="route('roles.create')" class="text-gray-200 dark:text-white">
                        <Button
                            label="Create Role"
                            variant="primary"
                        />
                    </Link>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium group">    
                <Table :resource="roles">
                    <!-- <template #cell(actions)="{ item: role }">
                        <div class="flex">
                            <span v-if="can('roles.edit') || is_superAdmin('super-admin')">
                                <Link :href="route('roles.edit',role.id)">
                                    <PencilIcon class="text-blue-600 w-5 h-5"/>
                                </Link>
                            </span>
                            <span v-if="can('roles.destroy') || is_superAdmin('super-admin')"><TrashIcon class="text-rose-500 mx-2 cursor-pointer w-6 h-5" @click="deleteUser(role.id)"/></span>
                            <span v-if="can('roles.index') || is_superAdmin('super-admin')"><EyeIcon class="text-blue-500 mx-1 cursor-pointer w-6 h-5" @click="showUser(role.id)" /></span>
                        </div>
                    </template> -->
                    <template #cell(actions)="{ item: role }">
                        <div class="flex mx-auto space-y-3 ">
                            <DropdownMenu
                            text=""
                            >
                                <div class="block px-4 py-2 text-xs text-gray-400 flex flex-col items-center justify-center border-b-2">
                                    Manage Actions
                                </div>
                                <DropdownOption>
                                    <div v-if="can('roles.edit') || is_superAdmin('super-admin')" class="flex w-full">
                                        <Link class="w-full" :href="route('roles.edit',role.id)">
                                            <span class="w-[23px] float-left mt-[2px]"><PencilSquareIcon class="text-blue-500 w-4 h-4"/></span>
                                            <span class="text-blue-500">Edit</span>
                                        </Link>
                                    </div>
                                </DropdownOption>
                                <DropdownOption>
                                    <div v-if="can('roles.destroy') || is_superAdmin('super-admin')" class="flex w-full" @click="deleteUser(role.id)">
                                        <Link class="w-full" href="">
                                            <span class="w-[23px] float-left mt-[2px]"><TrashIcon class="text-rose-500 w-4 h-4"/></span>
                                            <span class="text-rose-500">Delete</span>
                                        </Link>
                                    </div>
                                </DropdownOption>
                                <DropdownOption>
                                    <div v-if="can('roles.index') || is_superAdmin('super-admin')" class="flex w-full" @click="showUser(role.id)">
                                        <Link class="w-full" href="">
                                            <span class="w-[23px] float-left mt-[2px]"><EyeIcon class="text-green-500 w-4 h-4"/></span>
                                            <span class="text-green-500">Show</span>
                                        </Link>
                                    </div>
                                </DropdownOption>
                            </DropdownMenu>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
