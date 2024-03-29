<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button } from '@flavorly/vanilla-components';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon, PencilAltIcon,PencilIcon,EyeIcon, DotsVerticalIcon
} from '@heroicons/vue/24/solid'
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
        PencilAltIcon,
        PencilIcon,
        EyeIcon,
        DotsVerticalIcon,
    },
    props: {
        users: Object,
    },
    setup() {
        const swal = Swal;
        const toast = useToast();
    
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
                    this.$inertia.delete(route('users.destroy',userId),{
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
            this.$inertia.get(route('users.show',id),{
                preserveScroll: true,
                onSuccess: () => {
                    
                },
            })
        }
    }

}

</script>

<template>
    <AppLayout title="Users">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-start items-center w-full h-4 transition-all duration-300 transform px-4">
                    <span class=""><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="mt-1 ml-2"><ChevronRightIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('users.index')" class="text-gray-200 dark:text-white">
                            {{ $t('users') }}
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <Link v-if="can('users.create') || is_superAdmin('super-admin')" :href="route('users.create')" class="text-gray-200 dark:text-white">
                        <Button
                            :label="$t('create_user')"
                            variant="primary"
                        />
                    </Link>
                </div>
            </div>
            
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium group">    
                <Table :resource="users">
                    <template #cell(actions)="{ item: user }">
                        <div class="flex">
                            <span v-if="can('users.edit') || is_superAdmin('super-admin')">
                                <Link :href="route('users.edit',user.id)">
                                    <PencilIcon class="text-blue-600 w-5 h-5"/>
                                </Link>
                            </span>
                            <span v-if="can('users.destroy') || is_superAdmin('super-admin')"><TrashIcon class="text-rose-500 mx-2 cursor-pointer w-6 h-5" @click="deleteUser(user.id)"/></span>
                            <span v-if="can('users.index') || is_superAdmin('super-admin')"><EyeIcon class="text-blue-500 mx-1 cursor-pointer w-6 h-5" @click="showUser(user.id)" /></span>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>