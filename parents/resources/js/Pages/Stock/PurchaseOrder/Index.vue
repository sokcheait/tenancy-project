<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button ,Dropdown, DropdownMenu, DropdownOption} from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon, 
    PencilAltIcon,PencilIcon,EyeIcon,
    ArrowsRightLeftIcon,EllipsisVerticalIcon,
    PencilSquareIcon 
} from '@heroicons/vue/24/solid'
import Swal from 'vue-sweetalert2';
import { useToast } from "vue-toastification";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
// import Dropdown from '@/Components/Dropdown.vue';
// import DropdownLink from '@/Components/DropdownLink.vue';

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
        TrashIcon,
        PencilAltIcon,
        PencilIcon,
        EyeIcon,
        Table,
        // DropdownLink,
        Dropdown, DropdownMenu, DropdownOption,
        EllipsisVerticalIcon,PencilSquareIcon
    },
    props: {
        purchase_order: Object,
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
    <AppLayout title="PurchaseOrder">
        <div class="w-full p-4 relative">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center h-4 transition-all duration-300 transform px-4">
                    <span class="-ml-4"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('purchase-order.index')" class="text-gray-200 dark:text-white">
                            Purchase Order
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <Link :href="route('purchase-order.create')" class="text-gray-200 dark:text-white">
                        <Button
                            label="Create Purchase Order"
                            variant="primary"
                        />
                    </Link>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium relative">  
                <Table :resource="purchase_order" class="dark:border-gray-600 font-medium">
                    <template #cell(id)="{ item: po }">
                        {{ po.id }}
                    </template>
                    <template #cell(purchase_orders)="{ item: po }">
                        {{ po?.po_code }}
                    </template>
                    <template #cell(supplier_id)="{ item: po }">
                        {{ po.supplier_name }}
                    </template>
                    <template #cell(items)="{ item: po }">
                        {{ po?.items_count }}
                    </template>
                    <template #cell(status)="{ item: po }">
                        <span v-if="po.status=='pending'" class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100"> 
                            Pending
                        </span>
                    </template>
                    <template #cell(actions)="{ item: po }">
                        <div class="flex mx-auto space-y-3 ">
                            <DropdownMenu
                            text="Action"
                            >
                                <div class="block px-4 py-2 text-xs text-gray-400 flex flex-col items-center justify-center border-b-2">
                                    Manage Actions
                                </div>
                                <DropdownOption>
                                    <div v-if="is_superAdmin('super-admin')" class="flex w-full">
                                        <Link class="w-full" :href="route('receive.manage_receiving',po.id)">
                                            <span class="w-[23px] float-left mt-[2px]"><ArrowsRightLeftIcon class="text-yellow-500 w-4 h-4"/></span>
                                            <span class="text-yellow-500">Receiving</span>
                                        </Link>
                                    </div>
                                </DropdownOption>

                                <DropdownOption>
                                    <div v-if="is_superAdmin('super-admin')" class="flex w-full">
                                        <Link :href="route('purchase-order.show',po.id)" class="w-full">
                                            <span class="w-[23px] float-left mt-[2px]"><EyeIcon class="text-pink-400 w-4 h-4"/></span>
                                            <span class="text-pink-400">View</span>
                                        </Link>
                                    </div>
                                </DropdownOption>
                                <DropdownOption>
                                    <Link :href="route('purchase-order.edit',po.id)" class="w-full">
                                            <span class="w-[23px] float-left mt-[2px]"><PencilSquareIcon class="text-blue-600 w-4 h-4"/></span>
                                            <span class="text-blue-600">Edit</span>
                                    </Link>
                                </DropdownOption>

                                <DropdownOption>
                                    <Link class="w-full" @click="deletePo(po.id)">
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