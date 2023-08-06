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
        positions: Object,
        errors: Object
    },
    setup() {
        const optionsGender = [
            {
                value: 'M',
                text: 'Male',
               
            },
            {
                value: 'F',
                text: 'Female',
            },
        ]
        const toast = useToast()
        const masks = ref({
            input: 'DD/MM/YYYY',
        });
        const timezone = ref('UTC');
        const selectDragAttribute = {
            popover: {
                visibility: 'hover',
                isInteractive: false, 
            },
        }
        return { toast , optionsGender,masks,selectDragAttribute, timezone}
    },
    data() {
        return {
            form:useForm({
                first_name: '',
                last_name: '',
                gender: [],
                phone: null,
                dob:"",

                address: '',
                is_active: false,
                position_id: [],
                valide_date_form: null,
                valide_date_to: null,

                valide_date_card_form: null,
                valide_date_card_to: null,
                id_card: null,
                

            }),
            valueErrors:'',
            valueCountry:'KH',
        }
    },
    created() {

    },
    watch: {
       
    },
    methods: {
        backEmployee() {
            this.$inertia.replace('/employee')
        },
        submitEmployee() {
            this.form.post(route('employee.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create employee successfully", {
                    });
                },
                onError: () => {
                    this.toast.error("Create employee Errors", {
                    });
                },
            });
        },
        invalidDate(e){
            if(e){
                this.form.age=null;
                this.toast.error("Invalid Date of Birth "+e);
                this.$inertia.get("/employee/create");
            }
        },
    }

}

</script>

<template>
    <AppLayout title="Employee-create">
        <div class="p-4 w-full">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-[150px]"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('employee.index')" class="text-gray-200 dark:text-white">
                                Employee
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
                <form @submit.prevent="submit">
                    <div class="flex flex-wrap">
                        <div class="w-full">
                            <h3 class="text-gray-600 font-bold block p-2 mt-4 bg-gray-200 dark:bg-gray-800 dark:text-white border rounded">Employee Information</h3>
                        </div>
                        <div class="w-full flex px-2 py-3">
                            <div class="w-1/2 flex">
                                <Avatar
                                    v-model="profile"
                                    placeholder="Elon Musk"
                                    uploadButtonLabel="Uplode profile"
                                    resetButtonLabel="Clear profile"
                                    avatarInitials="Profile"
                                />
                            </div>
                            <div class="w-1/2">
                                <toggle-switche v-model="form.is_active" 
                                                inputLable="Active"
                                />
                            </div>
                        </div>
                        <input-text v-model="form.first_name" 
                                inputLable="First Name"
                                placeholder="Please input first name"
                                requirest="requirest"
                                :errors="form.errors.first_name"
                        />
                        <input-text v-model="form.last_name" 
                                    inputLable="Last Name"
                                    placeholder="Please input last name"
                                    requirest="requirest"
                                    :errors="form.errors.last_name"
                                    
                        />
                        <select-text v-model="form.gender"
                                    inputLable="Gender"
                                    :options="optionsGender"
                                    :tags="true"
                                    :clearable="true"
                                    requirest="requirest"
                                    value-attribute="value"
                                    text-attribute="text"
                                    placeholder="Please select a gender"
                                    :errors="form.errors.gender"
                        
                        />
                        <input-text v-model="form.phone" 
                                    inputLable="Phone Number"
                                    placeholder="Please input phone number"
                                    requirest="requirest"
                                    :errors="form.errors.phone"
                                    
                        />
                        <date-select v-model="form.dob"  
                                    inputLable="Date of birth"
                                    placeholder="Please select date of birth"
                                    requirest="requirest"
                                    :masks="masks"
                                    :errors="form.errors.dob"
                        />
                        <input-text v-model="form.age" 
                                    inputLable="Age"
                                    placeholder="Please input age"
                                    :errors="form.errors.age"
                                    
                        />
                        
                        <select-text v-model="form.position_id"
                                    inputLable="Position"
                                    :options="positions"
                                    :tags="true"
                                    :clearable="true"
                                    requirest="requirest"
                                    value-attribute="id"
                                    text-attribute="name"
                                    placeholder="Please select a position"
                                    :errors="form.errors.position_id"
                            
                        />
                        <input-text v-model="form.staff_id" 
                                    inputLable="Staff ID"
                                    placeholder="Please input staff ID"
                                    :errors="form.errors.staff_id"
                                    
                        />
                        <date-select v-model="form.valide_date_form"  
                                    inputLable="Valide date staff form"
                                    placeholder="Please select valide staff date form"
                                    requirest="requirest"
                                    :masks="masks"
                                    :errors="form.errors.valide_date_form"
                        />
                        <date-select v-model="form.valide_date_to"  
                                    inputLable="Valide date staff to"
                                    placeholder="Please select valide date staff to"
                                    requirest="requirest"
                                    :masks="masks"
                                    :errors="form.errors.valide_date_to"
                        />

                        <div class="w-full">
                            <h3 class="text-gray-600 font-bold block p-2 mt-4 bg-gray-200 dark:bg-gray-800 dark:text-white border rounded">Personnel information</h3>
                        </div>
                        <div class="">
                            
                        </div>
                        <date-select v-model="form.valide_date_card_form"  
                                    inputLable="Valide date card form"
                                    placeholder="Please select valide date card form"
                                    requirest="requirest"
                                    :masks="masks"
                                    :errors="form.errors.valide_date_card_form"
                        />
                        <date-select v-model="form.valide_date_card_to"  
                                    inputLable="Valide date card to"
                                    placeholder="Please select valide date card to"
                                    requirest="requirest"
                                    :masks="masks"
                                    :errors="form.errors.valide_date_card_to"
                        />
                        <input-text v-model="form.id_card" 
                                    inputLable="ID Card"
                                    placeholder="Please input ID Card"
                                    requirest="requirest"
                                    :errors="form.errors.id_card"
                                    
                        />
                        <input-text-area v-model="form.address" 
                                    inputLable="address"
                                    placeholder="Please input address"
                                    :errors="form.errors.address"
                                    
                        />
                        <div class="w-full">
                            <Button
                                class="w-[80px] bg-red-500 text-slate-50 text-center p-2 rounded-lg float-right  mx-2"
                                label="Back"
                                variant="error"
                                @click="backEmployee"
                            />
                            <Button
                                class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg float-right  mx-2"
                                label="Save"
                                variant="primary"
                                type="submit"
                                @click="submitEmployee"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            />
                            
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>