<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button,DropdownMenu, DropdownOption,Dialog,RichSelect } from '@flavorly/vanilla-components';
import { Head, Link,useForm } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon,PencilIcon,EyeIcon,PencilSquareIcon,LinkIcon } from '@heroicons/vue/24/solid'
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
        PencilIcon,
        EyeIcon,
        Table,
        Dialog,
        RichSelect,
        DropdownMenu, DropdownOption,PencilSquareIcon,LinkIcon,
    },
    props: {
        shifts: Object,
        positions: Object
    },
    setup() {
        const swal = Swal;
        const toast = useToast()

        return { swal,toast }
    },
    data() {
        return {
            form :useForm({
                position_id: null,
                shift_id: null,
            }),
            open:false
        }
    },
    created() {
        
    },
    watch: {
        'open':function(value) {
            if(value==false){
                this.form.clearErrors('positions_id');
                this.form.position_id=null;
            }
        }
    },
    methods: {
        deleteShift(userId) {
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
                    this.$inertia.delete(route('shift.destroy',userId),{
                        preserveScroll: true,
                        onSuccess: () => {
                            this.toast.success("Your post has been deleted!");
                        },
                    })
                }
            });
        },
        openModal(id) {
            this.open=true;
            this.form.shift_id = id;
        },
        connectShift() {
            this.form.post(route('shift.connect-shift'),{
                preserveScroll: true,
                onSuccess: () => {
                    this.open=false;
                    this.toast.success("Your post has been connect!");
                },
            })
        }
    }

}

</script>

<template>
    <AppLayout title="Shifts">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-12"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('shift.index')" class="text-gray-200 dark:text-white">
                            Shift
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <Link v-if="can('shift.create') || is_superAdmin('super-admin')" :href="route('shift.create')" class="text-gray-200 dark:text-white">
                        <Button
                            label="Create Shift"
                            variant="primary"
                        />
                    </Link>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium group"> 
                <Table :resource="shifts" class="dark:border-gray-600 font-medium group">
                    <template #cell(positions_name)="{ item: shift }">
                        <span>{{ shift?.positions[0]?.name }}</span>
                    </template>
                    <template #cell(shift_allowance)="{ item: shift }">
                        <div class="flex ml-6 focus:ring-0 focus:ring-offset-0 focus:border-primary-600">
                            <span class="relative inline-flex">
                                <span v-if="shift.shift_allowance" class="flex absolute h-4 w-4 top-0 right-0 -mt-1 -mr-1 z-10">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75" />
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-green-600" />
                                </span>
                                <span v-else class="flex absolute h-4 w-4 top-0 right-0 -mt-1 -mr-1 z-10">
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-gray-500" />
                                </span>
                            </span>
                        </div>
                    </template>
                    <template #cell(actions)="{ item: shift }">
                        <div class="flex mx-auto space-y-3 items-center">
                            <DropdownMenu
                            text=""
                            >
                                <div class="block px-4 py-2 text-xs text-gray-400 flex flex-col items-center justify-center border-b-2">
                                    Manage Actions
                                </div>
                                <DropdownOption>
                                    <div v-if="can('shift.edit') || is_superAdmin('super-admin')" class="flex w-full">
                                        <Link class="w-full" :href="route('shift.edit',shift.id)">
                                            <span class="w-[23px] float-left mt-[2px]"><PencilSquareIcon class="text-blue-500 w-4 h-4"/></span>
                                            <span class="text-blue-500">Edit</span>
                                        </Link>
                                    </div>
                                </DropdownOption>
                                <section v-if="shift.positions_count==0">
                                    <DropdownOption>
                                        <div v-if="can('shift.destroy') || is_superAdmin('super-admin')" class="flex w-full" @click="deleteShift(shift.id)">
                                            <Link class="w-full" href="">
                                                <span class="w-[23px] float-left mt-[2px]"><TrashIcon class="text-rose-500 w-4 h-4"/></span>
                                                <span class="text-rose-500">Delete</span>
                                            </Link>
                                        </div>
                                    </DropdownOption>
                                </section>
                            </DropdownMenu>
                            <div v-if="shift.positions_count==0" class="pb-3" @click="openModal(shift.id)">
                                <div class="border px-2 py-1 ml-4 rounded-md text-center cursor-pointer text-white bg-green-400 flex">
                                    <span><LinkIcon class="w-4 h-4"/></span>
                                    <span>Connect shift</span>
                                </div>
                            </div>
                        </div>
                    </template>
                </Table>
                <Dialog v-model="open">
                    <div>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100 cursor-pointer hover:bg-green-300"
                            @click="connectShift"
                        >
                            <LinkIcon class="w-5 h-5 text-green-400 hover:text-white"/>
                        </div>
                        <div class="mt-3 text-left sm:mt-5">
                            <div class="my-2">
                                <RichSelect
                                v-model="form.position_id"
                                :options="positions"
                                :teleport="true"
                                :clearable="true"
                                :hide-search-box="true"
                                textAttribute="name"
                                valueAttribute="id"
                                feedback="Connect shift with positions"
                                placeholder="Please select a positions"
                                :errors="form.errors.position_id"
                                />
                            </div>
                        </div>
                    </div>
                </Dialog>
            </div>
        </div>
    </AppLayout>
</template>