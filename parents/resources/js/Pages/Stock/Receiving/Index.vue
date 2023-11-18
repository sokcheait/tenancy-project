<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button ,Dropdown, DropdownMenu, DropdownOption} from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon, PencilAltIcon,PencilIcon,EyeIcon,ArrowsRightLeftIcon,PencilSquareIcon } from '@heroicons/vue/24/solid'
import Swal from 'vue-sweetalert2';
import { useToast } from "vue-toastification";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        Alert, 
        Button,
        HomeIcon,
        ChevronRightIcon,
        ArrowsRightLeftIcon,
        UserIcon,
        PencilSquareIcon,
        TrashIcon,
        PencilAltIcon,
        PencilIcon,
        EyeIcon,
        Table,
        Dropdown, DropdownMenu, DropdownOption
    },
    props: {
        receiving_order: Object,
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
        deletePo(id) {
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
                    this.$inertia.delete(route('purchase-order.destroy',id),{
                        preserveScroll: true,
                        onSuccess: () => {
                            this.toast.success("Your post has been deleted!");
                        },
                    })
                }
            });
        },
    }

}

</script>

<template>
    <AppLayout title="Receiving">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center h-4 transition-all duration-300 transform px-4 py-4">
                    <span class="-ml-4"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('purchase-order.index')" class="text-gray-200 dark:text-white">
                            Receiving
                        </Link>
                    </span>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium group">  
                <Table :resource="receiving_order" class="dark:border-gray-600 font-medium group">
                    <template #cell(id)="{ item: receive }">
                        {{ receive.id }}
                    </template>
                    <template #cell(from_code)="{ item: receive }">
                        {{ receive.from_code }}
                    </template>
                    <template #cell(actions)="{ item: receive }">
                        <div class="flex mx-auto space-y-3 ">
                            <DropdownMenu
                            text=""
                            >
                                <div class="block px-4 py-2 text-xs text-gray-400 flex flex-col items-center justify-center border-b-2">
                                    Manage Actions
                                </div>

                                <DropdownOption>
                                    <div v-if="is_superAdmin('super-admin')" class="flex w-full">
                                        <Link :href="route('receive.show',receive.id)" class="w-full">
                                            <span class="w-[23px] float-left mt-[2px]"><EyeIcon class="text-pink-400 w-4 h-4"/></span>
                                            <span class="text-pink-400">View</span>
                                        </Link>
                                    </div>
                                </DropdownOption>
                                <DropdownOption>
                                    <Link :href="route('receive.edit',receive.id)" class="w-full">
                                            <span class="w-[23px] float-left mt-[2px]"><PencilSquareIcon class="text-blue-600 w-4 h-4"/></span>
                                            <span class="text-blue-600">Edit</span>
                                    </Link>
                                </DropdownOption>

                                <DropdownOption>
                                    <Link class="w-full" @click="deleteReceive(receive.id)">
                                        <span class="w-[23px] float-left mt-[2px]"><TrashIcon class="text-rose-500 w-4 h-4"/></span>
                                         <span class="text-rose-500">Delete</span>
                                    </Link>
                                </DropdownOption>
                            </DropdownMenu>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>