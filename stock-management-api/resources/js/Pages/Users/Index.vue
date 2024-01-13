<script>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {Cog8ToothIcon } from '@heroicons/vue/24/solid'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";

export default {
    components: {
        AppLayout,
        Head,
        Link,
        router,
        ref,
        Table
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
                            <a href="#" class = "ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">User</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Table -->
              <div class="flex flex-col mt-4">
                <div class="grid justify-items-end pb-3 mr-4">
                    <div class="bg-gray-100 border px-3 py-2 border-gray-400 rounded-lg text-md cursor-pointer hover:bg-gray-400  hover:text-white">
                        <Link :href="route('users.create')">
                             Create User
                        </Link>
                    </div>
                </div>
                <div class="min-w-full overflow-x-auto bg-gray-100 rounded-lg">
                    <div class="overflow-hidden shadow sm:rounded-lg p-2">
                        <Table :resource="users">
                            <template #cell(actions)="{ item: user }">
                              <a :href="`/users/${user.id}/edit`">
                                Edit
                              </a>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
