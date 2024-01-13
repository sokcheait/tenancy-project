<script>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {Cog8ToothIcon } from '@heroicons/vue/24/solid'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import { Input,RichSelect } from '@flavorly/vanilla-components'

export default {
    components: {
        AppLayout,
        Head,
        Link,
        router,
        ref,
        Table,
        Input,
        RichSelect
    },
    props: {
        title: String,
        errors: Object,
        users: Object
    },
    setup() {
      
    },
    data() {
        return {
            
        }
    }, 
    created() {
      
    },
    mounted() {
          
    },
    computed: {
      
    },
    methods: {
        btnCancel() {
            this.$inertia.replace(this.route('users.index'))
        }
    }

}
</script>

<template>
    <AppLayout title="User">
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
                            <Link :href="route('users.index')" class = "ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">User</Link>
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
                                <h3 class="font-bold text-gray-500 ml-2 py-2">Create User</h3>
                            </div>
                            <div class="py-2 px-2 w-1/2 text-gray-400">
                                <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
                                    Name
                                    <span class="text-rose-500">*</span>
                                </label>
                                <Input
                                    v-model="value"
                                    placeholder="Please input name"
                                  />
                            </div>
                            <div class="py-2 px-2 w-1/2 text-gray-400">
                                <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
                                    Email
                                    <span class="text-rose-500">*</span>
                                </label>
                                <Input
                                    v-model="value"
                                    placeholder="Please input email"
                                  />
                            </div>
                            <div class="py-2 px-2 w-1/2 text-gray-400">
                                <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
                                    Password
                                    <span class="text-rose-500">*</span>
                                </label>
                                <Input
                                    v-model="value"
                                    placeholder="Please input password"
                                  />
                            </div>
                            <div class="py-2 px-2 w-1/2 text-gray-400">
                                <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
                                    Password
                                    <span class="text-rose-500">*</span>
                                </label>
                                <Input
                                    v-model="value"
                                    placeholder="Please input password"
                                  />
                            </div>
                            <div class="py-2 px-2 w-1/2 text-gray-400">
                                <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
                                    Roles
                                </label>
                                <RichSelect
                                    v-model="value"
                                    name="test"
                                    :options="options"
                                    :clearable="true"
                                    placeholder="Please select an option"
                                />
                            </div>
                            <div class="w-full flex flex-wrap grid justify-items-end">
                                <div class="p-3">
                                    <Button class="py-2 px-3 rounded-lg bg-rose-500 text-sm text-white mr-2" @click="btnCancel"
                                    >Cancel</Button>
                                    <Button
                                        class="py-2 px-3 rounded-lg bg-sky-500 text-sm text-white mr-2"
                                    >Save</Button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </AppLayout>
</template>
