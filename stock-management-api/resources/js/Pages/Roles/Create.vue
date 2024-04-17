<script>
import { ref } from 'vue';
import { Head, Link, router,useForm } from '@inertiajs/vue3';
import {Cog8ToothIcon } from '@heroicons/vue/24/solid'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import { Input,RichSelect } from '@flavorly/vanilla-components'
import { useToast } from "vue-toastification";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        router,
        ref,
        Table,
        Input,
        RichSelect,
        useForm,
    },
    props: {
        title: String,
        errors: Object,
        list_permissions: Object,
        permissions: Object
    },
    setup() {
        const toast = useToast();

        return { toast}
    },
    data() {
        return {
            form:useForm({
                name:'',
                data_permissions:[]
            }),
            isCheckAll:[],
            isValue:[],
        }
    }, 
    created() {
    //   console.log(this.selected)
    },
    mounted() {
          
    },
    computed: {
        
    },
    methods: {
        checkAll: function(data,key){
            if(this.isCheckAll[key]==true){
                data.forEach((value, index) => {
                    this.form.data_permissions.push(value);
                });
            }else{
                this.form.data_permissions = this.form.data_permissions.filter(x => !data.includes(x));
            }
        },
        updateCheckall: function(e,key){
            if(e.target.checked==true) {
                this.isValue.push(e.target.value)
            }else if(e.target.checked==false){
                this.isValue = this.removeArrValue(this.isValue,e.target.value)
            }
            var removeIndex = Object.keys(this.list_permissions[key]).filter(x => !this.isValue.includes(x));
            if(removeIndex.length==0){
                this.isCheckAll[key]=true;
            }else{
                this.isCheckAll[key]=false;
            }
        },
        removeArrValue(arr,value) {
            var index = arr.indexOf(value);
            if (index > -1) {
                arr.splice(index, 1);
            }
            return arr;
        },
        btnCancel() {
            this.$inertia.replace(this.route('users.index'))
        },
        saveRole() {
            this.form.post(this.route('roles.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create roles successfully", {
                    });
                },
                onError: () => {
                    this.toast.errors("Create roles Errors", {
                    });
                },
            });
        }
    }

}
</script>

<template>
    <AppLayout title="Role">
        <div class="px-4 pt-6">
            <nav class = "flex px-5 py-3 text-gray-600 rounded-lg bg-gray-100 dark:bg-[#1E293B] " aria-label="Breadcrumb">
                <ol class = "inline-flex items-center space-x-1 md:space-x-3">
                    <li class = "inline-flex items-center">
                        <a href="#" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            <svg class = "w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class = "flex items-center">
                            <svg class = "w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd"></path></svg>
                            <Link :href="route('roles.index')" class = "ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Role</Link>
                        </div>
                    </li>
                    <li>
                        <div class = "flex items-center">
                            <svg class = "w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd"></path></svg>
                            <a href="#" class = "ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Create</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Form -->
            <div class="flex flex-col mt-1">
                <div class="min-w-full py-4">
                    <form @submit.prevent="submit" class="">
                        <div class="w-full shadow-md rounded-lg flex flex-wrap bg-gray-100">
                            <div class="py-2 px-2 w-full border-b-2">
                                <h3 class="font-bold text-gray-500 ml-2 py-2">Create Role</h3>
                            </div>
                            <div class="py-2 px-2 w-full text-gray-400">
                                <div class="py-2 px-2 w-1/2 text-gray-400">
                                    <label class="font-semibold block text-gray-500 text-md py-1 pl-1 dark:text-white">
                                        <span class="">Name</span>
                                        <span class="text-rose-500">*</span>
                                    </label>
                                    <Input
                                        v-model="form.name"
                                        placeholder="Please input name"
                                        :errors="form.errors.name"
                                      />
                                </div>
                            </div>
                            <div class="py-2 px-2 w-full text-gray-400">
                                <div v-for="(permissions,ind) in list_permissions" :key="ind" class="px-4">
                                    <input type='checkbox' @change="checkAll(Object.keys(permissions),ind)" v-model="isCheckAll[ind]" v-bind:value="ind"> {{ ind }}
                                    <!-- Checkboxes list -->
                                    <ul>
                                        <li v-for="(permission,index ) in permissions" :key="index" class="ml-6">
                                            <input type='checkbox' v-bind:value="index" v-model='form.data_permissions' @change="updateCheckall($event,ind)" class="">{{ permission }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="w-full flex flex-wrap grid justify-items-end mt-4">
                                <div class="p-3">
                                    <Button @click="saveRole"
                                        class="py-2 px-3 rounded-lg bg-sky-500 text-sm text-white mr-2"
                                    >Save</Button>
                                    <Button class="py-2 px-3 rounded-lg bg-rose-500 text-sm text-white mr-2" @click="btnCancel"
                                    >Cancel</Button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </AppLayout>
</template>
