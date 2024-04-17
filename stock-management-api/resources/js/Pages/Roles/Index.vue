<script>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {Cog8ToothIcon } from '@heroicons/vue/24/solid'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import moment from 'moment'
// import VueDatePicker from '@vuepic/vue-datepicker';
// import '@vuepic/vue-datepicker/dist/main.css'

export default {
    components: {
        AppLayout,
        Head,
        Link,
        router,
        ref,
        Table,
        moment,
    },
    props: {
        errors: Object,
        roles: Object
    },
    setup() {
      
    },
    data() {
        return {
            listDaily:[],
            listDay:[],
            searchDate:null,
        }
    }, 
    created() {
      // this.listsScheduleShift()
    },
    watch: {
        'searchDate':function(val){
            if(val){
                this.listsScheduleShiftHeader(val);
                this.listsScheduleShiftBody(val);
            }else{
                this.listDaily=[];
                this.listDay=[];
            }
            
        }
    },
    mounted() {
          
    },
    computed: {
      
    },
    methods: {
        listsScheduleShiftHeader(date){
            var start_date = new Date(date);   
            const startOfMonth = moment(start_date).startOf('month').format('YYYY-MM-DD');
            const endOfMonth   = moment(start_date).endOf('month').format('YYYY-MM-DD');
            var i = 0;
            this.listDaily=[];
            this.listDay=[];
                while (i <= moment(endOfMonth).diff(startOfMonth, 'days')) {
                    var day = moment(startOfMonth).add(i, 'days').format('ddd');
                    var daily = moment(startOfMonth).add(i, 'days').format('D');
                    this.listDay.push(day);
                    this.listDaily.push(daily)
                    i++;
                }
              return this.listDay,this.listDaily;  
        },
        listsScheduleShiftBody(date){
            
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
                            <a href="#" class = "ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Role</a>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Table -->
              <div class="flex flex-col mt-4">
                <div class="grid justify-items-end pb-4 mr-4">
                    <div class="bg-gray-100 px-4 py-2 border border-gray-400 rounded-lg text-md cursor-pointer hover:bg-gray-400  hover:text-white">
                        <Link :href="route('roles.create')">
                             Create Role
                        </Link>
                    </div>
                </div>
                <div class="min-w-full overflow-x-auto bg-gray-100 rounded-lg">
                    <div class="overflow-hidden shadow sm:rounded-lg p-2">
                        <Table :resource="roles">
                            
                        </Table>
                    </div>


                    <!-- <div class="px-2 py-4 w-[250px] text-gray-900">
                        <date-picker v-model:value="searchDate" type="month" class="text-gray-900"></date-picker>
                    </div>
                    <div class="px-2 pb-4">
                        <table class="" v-if="listDaily.length >0">
                            <thead>
                                <tr class="p-3">
                                    <td class="px-3 py-1 border"></td>
                                    <td v-for="(day,ind) in listDay" :key="ind" class="px-2 py-1 border text-center">{{ day }}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-1 border">Group</td>
                                    <td v-for="(daily,ind) in listDaily" :key="ind" class="px-2 py-1 border text-center">{{ daily }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-3 py-1 border">Group01</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
