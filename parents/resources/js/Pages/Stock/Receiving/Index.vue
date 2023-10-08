<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button } from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon, PencilAltIcon,PencilIcon,EyeIcon,ArrowsRightLeftIcon } from '@heroicons/vue/24/solid'
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
        PencilAltIcon,
        PencilIcon,
        EyeIcon,
        Table
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
                    <!-- <template #cell(purchase_orders)="{ item: po }">
                        {{ po?.po_code }}
                    </template>
                    <template #cell(supplier_id)="{ item: po }">
                        {{ po.supplier_name }}
                    </template>
                    <template #cell(items)="{ item: po }">
                        {{ po?.items_count }}
                    </template> -->
                    <template #cell(actions)="{ item: receive }">
                        <div class="flex">
                            <span v-if="is_superAdmin('super-admin')">
                                <Link :href="route('purchase-order.edit',receive.id)">
                                    <PencilIcon class="text-blue-600 w-5 h-5"/>
                                </Link>
                            </span>
                            <span v-if="is_superAdmin('super-admin')">
                                <TrashIcon class="text-rose-500 mx-2 cursor-pointer w-6 h-5" @click="deletePo(receive.id)"/>
                            </span>
                            <span v-if="is_superAdmin('super-admin')">
                                <Link :href="route('purchase-order.show',receive.id)">
                                    <EyeIcon class="text-pink-400 mx-2 w-5 h-5"/>
                                </Link>
                            </span>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>