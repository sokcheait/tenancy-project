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
        suppliers: Object,
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
    created(){
        // console.log(this.$page.props.flash)
    },
    methods: {
        deleteSupplier(id) {
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
                    this.$inertia.delete(route('supplier.destroy',id),{
                        preserveScroll: true,
                        onSuccess: () => {
                            console.log(this.$page.props.jetstream.flash.message)
                            this.toast.success(this.$page.props.jetstream.flash.message, {
                                
                            });
                        },
                    })
                }
            });
        },
    }

}

</script>

<template>
    <AppLayout title="Supplier">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-16"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('supplier.index')" class="text-gray-200 dark:text-white">
                            Supplier
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <Link :href="route('supplier.create')" class="text-gray-200 dark:text-white">
                        <Button
                            label="Create Supplier"
                            variant="primary"
                        />
                    </Link>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium group">  
                <Table :resource="suppliers" class="dark:border-gray-600 font-medium group">
                    <template #cell(status)="{ item: supplier }">
                        <div class="flex ml-6 focus:ring-0 focus:ring-offset-0 focus:border-primary-600">
                            <span class="relative inline-flex">
                                <span v-if="supplier.status" class="flex absolute h-4 w-4 top-0 right-0 -mt-1 -mr-1 z-10">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75" />
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-green-600" />
                                </span>
                                <span v-else class="flex absolute h-4 w-4 top-0 right-0 -mt-1 -mr-1 z-10">
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-gray-500" />
                                </span>
                            </span>
                        </div>
                    </template>
                    <template #cell(actions)="{ item: supplier }">
                        <div class="flex">
                            <span v-if="is_superAdmin('super-admin')">
                                <Link :href="route('supplier.edit',supplier.id)">
                                    <PencilIcon class="text-blue-600 w-5 h-5"/>
                                </Link>
                            </span>
                            <span v-if="is_superAdmin('super-admin')"><TrashIcon class="text-rose-500 mx-2 cursor-pointer w-6 h-5" @click="deleteSupplier(supplier.id)"/></span>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>