<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref,watch } from 'vue';
import { useToast } from "vue-toastification";
import {
  Alert, 
  Button,
  Input,
  Avatar,
  CheckboxGroup,
  CountryInput,
  FormSection,
  InputGroup,
  Input as VanillaInput,
  Select as VanillaSelect,
  Toggle,
} from '@flavorly/vanilla-components';
import { HomeIcon,ChevronRightIcon ,UserIcon} from '@heroicons/vue/24/solid'
import { ClockIcon} from '@heroicons/vue/24/outline'
import FileUpload from "@/Components/FileUpload.vue"
import VueDatePicker from '@vuepic/vue-datepicker';

export default {
    components: {
        AppLayout,
        reactive,
        Head,
        Link,
        useForm,
        FileUpload,
        ref,
        watch,
        Alert, 
        Button,
        Input,
        CheckboxGroup,
        CountryInput,
        FormSection,
        InputGroup,
        VanillaInput,
        VanillaSelect,
        Toggle,
        Avatar,
        HomeIcon,
        ChevronRightIcon,
        UserIcon,
        VueDatePicker,
        ClockIcon
    },
    props: {
        errors: Object
    },
    setup() {
        const toast = useToast();
        const time = ref({
            hours: new Date().getHours(),
            minutes: new Date().getMinutes()
        });
        return { toast,time }
    },
    data() {
        return {
            valueErrors:'',
            form :useForm({
                name: '',
                time_from: this.time,
                time_to: this.time,
                weekend_definition:[],
                shift_allowance: false,
            }),
        }
    },
    created() {
       
    },
    watch: {
        // 'form.time_from':function(value){
        //     if(value) {
        //         _.forEach(['c', 'cpp', 'java','python'], function(value) {
        //             console.log(value);
        //         });
        //     }
        // }
    },
    methods: {
        submitShift() {
            this.form.post(route('shift.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create shift successfully", {
                    });
                },
                onError: () => {
                    this.toast.errors("Create shift Errors", {
                    });
                },
            });
        },
        btnCancel() {
            this.$inertia.visit('/shift', {
                method: 'get',
                preserveState: true,
                preserveScroll: true,
                only: ['shift'],
            });
        }
    }

}

</script>

<template>
    <AppLayout title="Shift-create">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-[150px]"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('shift.index')" class="text-gray-200 dark:text-white">
                            Shift
                        </Link>
                    </span>
                    <span class="float-left mt-[4px] ml-2"><ChevronRightIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-2 mt-1">
                        <Link href="" class="text-gray-200 dark:text-white">
                            Create
                        </Link>
                    </span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 text-white font-medium group">    
                <form @submit.prevent="submitShift">
                    <InputGroup
                        label="Name"
                        name="name"
                        variant="inline"
                        class="relative"
                    >
                    <span class="absolute left-20 top-6 z-10 text-rose-500">*</span>
                        <VanillaInput
                            v-model="form.name"
                            name="name"
                            type="text"
                            placeholder="Enter Name"
                            :errors="form.errors.name"
                        />
                    </InputGroup>
                    <InputGroup
                        label="TimeShift"
                        name=""
                        variant="inline"
                        class="relative"
                    >
                        <div class="flex">
                            <div class="w-1/2 mr-4">
                                <VueDatePicker v-model="form.time_from" time-picker>
                                    <template #input-icon>
                                        <ClockIcon class="text-gray-400 w-5 h-5 mx-2" />
                                    </template>
                                </VueDatePicker>
                            </div>
                            <div class="w-1/2">
                                <VueDatePicker v-model="form.time_to" time-picker>
                                    <template #input-icon>
                                        <ClockIcon class="text-gray-400 w-5 h-5 mx-2" />
                                    </template>
                                </VueDatePicker>
                            </div>
                        </div>
                    </InputGroup>
                    <InputGroup
                        label="Weekend"
                        name=""
                        variant="inline"
                        class="relative"
                    >
                        <div class="w-full">
                            <div class="flex flex-warp w-full pb-2">
                                <VueDatePicker v-model="form.weekend_definition" multi-dates 
                                    :min-date="new Date()" :enable-time-picker="false"
                                    >
                                    <template #calendar-header="{ index, day }">
                                        <div :class="index === 5 || index === 6 ? 'text-rose-500' : ''">
                                            {{ day }}
                                        </div>
                                    </template>
                                </VueDatePicker>
                            </div>
                        </div>
                    </InputGroup>
                    <InputGroup
                        label="Allowance"
                        name="shift_allowance"
                        variant="inline"
                        class="relative"
                    >
                    <Toggle
                        v-model="form.shift_allowance"
                    />
                    </InputGroup>
                    
                    <Button
                        class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg mx-4"
                        label="Save"
                        variant="primary"
                        type="submit"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    />
                    <Button
                        class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg"
                        label="Cancel"
                        variant="error"
                        @click="btnCancel"
                    />
                </form>
            </div>
        </div>
    </AppLayout>
</template>