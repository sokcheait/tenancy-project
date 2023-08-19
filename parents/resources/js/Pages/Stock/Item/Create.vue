<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref,watch } from 'vue';
import { useToast } from "vue-toastification";
import { Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/style.css';
import {
  Alert, 
  Button,
  Input,
  CheckboxGroup,
  CountryInput,
  FormSection,
  InputGroup,
  Input as VanillaInput,
  Select as VanillaSelect,
  Textarea as VanillaTextArea,
  Toggle,
  DateTimeInput,
  RichSelect, RichSelectOptionImage, RichSelectOptionIndicator, VanillaInputGroup,FormLabel,PhoneInput
} from '@flavorly/vanilla-components';
import { Avatar } from '@flavorly/vanilla-components'

import { HomeIcon,ChevronRightIcon ,UserIcon, IconCalendar, CalendarIcon} from '@heroicons/vue/24/solid'
import { trim } from 'lodash';
import InputText from '@/Pages/Components/Forms/InputText.vue'
import SelectText from '@/Pages/Components/Forms/SelectText.vue'
import DateSelect from '@/Pages/Components/Forms/DateSelect.vue'
import InputTextArea from '@/Pages/Components/Forms/InputTextArea.vue'
import ToggleSwitche from '@/Pages/Components/Forms/ToggleSwitche.vue'

export default {
    components: {
        AppLayout,
        reactive,
        Head,
        Link,
        useForm,
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
        RichSelect,
        RichSelectOptionImage,
        RichSelectOptionIndicator,
        VanillaInputGroup,
        VanillaTextArea,
        FormLabel,
        PhoneInput,
        Calendar,
        DatePicker,
        DateTimeInput,
        HomeIcon,
        ChevronRightIcon,
        UserIcon,
        CalendarIcon,
        InputText,
        SelectText,
        DateSelect,
        InputTextArea,
        ToggleSwitche,
        Avatar,
        
    },
    props: {
        errors: Object,
        suppliers: Object
    },
    setup() {
        const toast = useToast()
        return { toast }
    },
    data() {
        return {
            form:useForm({
                name: '',
                supplier_id: '',
                cost: '',
                description: null,
                status: false,
            }),
            valueErrors:'',
        }
    },
    created() {
        // console.log(this.suppliers)
    },
    methods: {
        back() {
            this.$inertia.replace('/item')
        },
        submitItem() {
            this.form.post(route('item.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create item successfully");
                },
                onError: () => {
                    this.toast.error("Create item Errors");
                },
            });
        },
    }

}

</script>

<template>
    <AppLayout title="Item-create">
        <div class="p-4 w-full">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-[150px]"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('item.index')" class="text-gray-200 dark:text-white">
                            Item
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
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 dark:text-white font-medium group">
                <form @submit.prevent="submit">
                    <div class="flex flex-wrap">
                        <div class="w-full">
                            <h3 class="text-gray-600 font-bold block p-2 mt-4 bg-gray-200 dark:bg-gray-800 dark:text-white border rounded">Item Information</h3>
                        </div>
                        <select-text v-model="form.supplier_id"
                                    inputLable="Supplier"
                                    :options="suppliers"
                                    :tags="true"
                                    :clearable="true"
                                    requirest="requirest"
                                    value-attribute="value"
                                    text-attribute="text"
                                    placeholder="Please select a supplier"
                                    :errors="form.errors.supplier_id"
                        
                        />
                        <input-text v-model="form.name" 
                                inputLable="Name"
                                placeholder="Please input name"
                                requirest="requirest"
                                :errors="form.errors.name"
                        />
                        <input-text v-model="form.cost" 
                                    inputLable="Cost"
                                    placeholder="Please input cost"
                                    :errors="form.errors.cost"
                                    
                        />
                        <div class="w-1/2">
                            <toggle-switche v-model="form.status" 
                                            inputLable="Status"
                            />
                        </div>
                        <input-text-area v-model="form.description" 
                                    inputLable="Description"
                                    placeholder="Please input description"
                                    :errors="form.errors.contact"          
                        />
                        <div class="w-full">
                            <Button
                                class="w-[80px] bg-red-500 text-slate-50 text-center p-2 rounded-lg float-right  mx-2"
                                label="Back"
                                variant="error"
                                @click="back"
                            />
                            <Button
                                class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg float-right  mx-2"
                                label="Save"
                                variant="primary"
                                type="submit"
                                @click="submitItem"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            />
                            
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>