<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button } from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon, PencilAltIcon,PencilIcon,EyeIcon } from '@heroicons/vue/24/solid'
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
        UserIcon,
        TrashIcon,
        PencilAltIcon,
        PencilIcon,
        EyeIcon,
        Table
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
        deleteItem(id) {
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
                    this.$inertia.delete(route('item.destroy',id),{
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
        <div class="w-full p-4">
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
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium group">  
                <Table :resource="purchase_order" class="dark:border-gray-600 font-medium group">
                    <template #cell(purchase_orders)="{ item: po }">
                        {{ po.purchase_orders?.po_code }}
                    </template>
                    <template #cell(items)="{ item: po }">
                        {{ po.purchase_orders?.po_code }}
                    </template>
                    <template #cell(items.suppliers)="{ item: po }">
                        {{ po?.items.suppliers.name }}
                    </template>
                    <template #cell(suppliers)="{ item: po }">
                        {{ po?.suppliers }}
                    </template>
                    <template #cell(actions)="{ item: po }">
                        <div class="flex">
                            <span v-if="is_superAdmin('super-admin')">
                                <Link :href="route('purchase-order.edit',po.id)">
                                    <PencilIcon class="text-blue-600 w-5 h-5"/>
                                </Link>
                            </span>
                            <span v-if="is_superAdmin('super-admin')"><TrashIcon class="text-rose-500 mx-2 cursor-pointer w-6 h-5" @click="deleteItem(item.id)"/></span>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>