<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button ,Dropdown, DropdownMenu, DropdownOption} from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon,PencilIcon,EyeIcon,
    ArrowsRightLeftIcon,EllipsisVerticalIcon,
    PencilSquareIcon 
} from '@heroicons/vue/24/solid'
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
        TrashIcon,
        PencilIcon,
        EyeIcon,
        Table,
        Dropdown, DropdownMenu, DropdownOption,
        EllipsisVerticalIcon,PencilSquareIcon
    },
    props: {
        stock_list: Object,
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
                            Stock
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <!-- <Link :href="route('purchase-order.create')" class="text-gray-200 dark:text-white">
                        <Button
                            label="Create Purchase Order"
                            variant="primary"
                        />
                    </Link> -->
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium relative">  
                <Table :resource="stock_list" class="dark:border-gray-600 font-medium">
                    <template #cell(id)="{ item: stock }">
                        {{ stock.id }}
                    </template>
                    <template #cell(items)="{ item: stock }">
                        {{ stock?.item_name }}
                    </template>
                    <template #cell(suppliers)="{ item: stock }">
                        {{ stock?.supplier_name }}
                    </template>
                    <template #cell(actions)="{ item: stock }">
                        <div class="flex mx-auto space-y-3 ">
                            <DropdownMenu
                            text=""
                            >
                                <div class="block px-4 py-2 text-xs text-gray-400 flex flex-col items-center justify-center border-b-2">
                                    Manage Actions
                                </div>

                                <DropdownOption>
                                    <div v-if="is_superAdmin('super-admin')" class="flex w-full">
                                        <Link :href="route('purchase-order.show',stock.id)" class="w-full">
                                            <span class="w-[23px] float-left mt-[2px]"><EyeIcon class="text-pink-400 w-4 h-4"/></span>
                                            <span class="text-pink-400">View</span>
                                        </Link>
                                    </div>
                                </DropdownOption>

                                <DropdownOption>
                                    <Link class="w-full" @click="deletePo(stock.id)">
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