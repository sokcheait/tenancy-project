<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button } from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon, 
    PencilAltIcon,PencilIcon,EyeIcon,
    ArrowsRightLeftIcon,EllipsisVerticalIcon,
    PencilSquareIcon 
} from '@heroicons/vue/24/solid'
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
        ArrowsRightLeftIcon,
        UserIcon,
        TrashIcon,
        PencilAltIcon,
        PencilIcon,
        EyeIcon,
        Table,
        Dropdown,DropdownLink,EllipsisVerticalIcon,PencilSquareIcon
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
            promotions:[
                {
                    id:1,
                    name:"Dfd23DS",
                    discount: 10,
                },
                {
                    id:2,
                    name:"Organization A get discount",
                    discount: 20,
                },
                {
                    id:3,
                    name:"Organization B get discount",
                    discount: 15,
                },
                {
                    id:4,
                    name:"Go2ssa",
                    discount: 25,
                }
            ],
            additional_grouped: [],
            promotion_value:null,
            promotion_key:null,
        }
    },
    created() {
        // console.log(this.promotion_id)
    },
    methods: {
        uniqueCheck(e){
            this.additional_grouped = [];
            this.promotion_key=null;
            if (e.target.checked) {
                this.additional_grouped.push(e.target.value);
                this.promotion_key = e.target.value;
            }
            this.promotion_value = this.promotions.filter((e) => e.id == this.additional_grouped[0]);
            console.log(this.promotion_value[0])
        },
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
    <AppLayout title="BackOrder">
        <div class="w-full p-4 relative">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center h-4 transition-all duration-300 transform px-4">
                    <span class="-ml-4"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('back-order.index')" class="text-gray-200 dark:text-white">
                            Back Order
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <Link :href="route('back-order.create')" class="text-gray-200 dark:text-white">
                        <Button
                            label="Create Back Order"
                            variant="primary"
                        />
                    </Link>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium group"> 
                <!-- Back Order  -->

                <div class="">
                    <div class="w-full px-4" v-for="promotion in promotions" :key="promotion">
                        <label class="checkbox-label justify-evely flex w-1/3 items-center my-2 
                                py-4 px-2 rounded-lg bg-white shadow-indigo-50 shadow-md border"
                                :class="{'border-cyan-500': promotion.id == promotion_key}"
                        >
                            <input type="checkbox" :value="promotion.id" v-model="additional_grouped" @click="uniqueCheck"
                                class="w-6 h-6 text-cyan-500 bg-gray-100 border-gray-300 rounded 
                                    focus:ring-cyan-500 dark:focus:ring-cyan-600 dark:ring-offset-gray-800 
                                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600" 
                            />
                            <div class="w-full flex justify-between">
                                <div class="px-3">
                                    <h2 class="text-gray-900 text-lg font-bold flex">Please select a discount</h2>
                                    <div class="mt-1 text-left">
                                        <span class="text-base font-semibold text-gray-500"><del>$70.00</del></span>
                                        <span class="text-xl font-bold px-2 text-black"
                                        :class="{'text-cyan-500': promotion.id == promotion_key }">$65.00</span>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-sm font-semibold text-gray-400 float-left mt-2">{{ promotion.name }}</p>
                                    </div>
                                </div>
                                <div
                                    class="bg-gradient-to-tr from-gray-300 to-gray-200 w-24 h-24 rounded-full 
                                                shadow-2xl shadow-gray-300 border-white border-dashed border-2 flex justify-center items-center"
                                    :class="{'from-cyan-600 to-cyan-500 shadow-2xl shadow-cyan-400': promotion.id == promotion_key }"            
                                    >
                                    <div>
                                        <h1 class="text-white text-3xl font-bold">{{ promotion.discount }}%</h1>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
               


                <!-- component -->
                <!-- <section class="text-gray-600 body-font bg-gray-50 flex justify-center items-center">
                    <div class="container px-5 py-4 mx-auto">
                        <div class="flex flex-wrap -m-4 text-center">
                            <div class="p-4 sm:w-1/2 lg:w-1/3 w-full hover:scale-105 duration-500" v-for="promotion in promotions" :key="promotion">

                                <div class="flex items-center justify-between p-4  rounded-lg bg-white shadow-indigo-50 shadow-md">
                                    <div>
                                        <h2 class="text-gray-900 text-lg font-bold flex">Please select a discount</h2>
                                        <div class="mt-1 text-left">
                                            <span class="text-base font-semibold text-gray-500"><del>$70.00</del></span>
                                            <span class="text-xl font-bold text-cyan-500 px-2">$65.00</span>
                                        </div>
                                        <div class="w-full">
                                            <div class="w-full">
                                                <p class="text-sm font-semibold text-gray-400 float-left">{{ promotion.name }}</p>
                                            </div>
                                            <div class="w-full">
                                                <input type="checkbox" ref="checkbox" :value="promotion.id" v-model="additional_grouped" @change="uniqueCheck"
                                                    class="w-6 h-6 text-cyan-500 bg-gray-100 border-gray-300 rounded focus:ring-cyan-500 dark:focus:ring-cyan-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-gradient-to-tr from-cyan-500 to-cyan-400 w-32 h-32  rounded-full shadow-2xl shadow-cyan-400 border-white  border-dashed border-2  flex justify-center items-center ">
                                        <div>
                                            <h1 class="text-white text-4xl font-bold">{{ promotion.discount }}%</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->

                <!-- <Table :resource="purchase_order" class="dark:border-gray-600 font-medium">
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
                    <template #cell(actions)="{ item: po }">
                        <div class="flex">
                            <Dropdown align="center" width="36">
                                <template #trigger>
                                    <EllipsisVerticalIcon class="w-6 h-6 cursor-pointer" />
                                </template>
                                <template #content>
                                    <div class="w-[180px]">
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Actions
                                        </div>
                                        <div v-if="is_superAdmin('super-admin')" class="flex w-full">
                                            <DropdownLink class="w-full" :href="route('receive.manage_receiving',po.id)">
                                                <span class="w-[23px] float-left mt-[2px]"><ArrowsRightLeftIcon class="text-yellow-500 w-4 h-4"/></span>
                                                <span class="text-yellow-500">Receiving</span>
                                            </DropdownLink>
                                        </div>
                                        <div v-if="is_superAdmin('super-admin')" class="flex w-full">
                                            <DropdownLink :href="route('purchase-order.show',po.id)" class="w-full">
                                                <span class="w-[23px] float-left mt-[2px]"><EyeIcon class="text-pink-400 w-4 h-4"/></span>
                                                <span class="text-pink-400">View</span>
                                            </DropdownLink>
                                        </div>
                                        <div v-if="is_superAdmin('super-admin')" class="flex w-full">
                                            <DropdownLink :href="route('purchase-order.edit',po.id)" class="w-full">
                                                <span class="w-[23px] float-left mt-[2px]"><PencilSquareIcon class="text-blue-600 w-4 h-4"/></span>
                                                <span class="text-blue-600">Edit</span>
                                            </DropdownLink>
                                        </div>
                                        <div v-if="is_superAdmin('super-admin')" class="flex w-full">
                                            <DropdownLink class="w-full" @click="deletePo(po.id)">
                                                <span class="w-[23px] float-left mt-[2px]"><TrashIcon class="text-rose-500 w-4 h-4"/></span>
                                                <span class="text-rose-500">Delete</span>
                                            </DropdownLink>
                                        </div>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </template>
                </Table> -->
            </div>
        </div>
    </AppLayout>
</template>