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

import { HomeIcon,ChevronRightIcon ,UserIcon, IconCalendar, CalendarIcon} from '@heroicons/vue/24/solid'

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
        const selectDragAttribute = {
            popover: {
                visibility: 'hover',
                isInteractive: false, 
            },
        }
        return { toast , optionsGender,masks,selectDragAttribute}
    },
    data() {
        return {
            form:useForm({
                first_name: '',
                last_name: '',
                gender: [],
                phone: null,
                address: '',
                is_active: null,
                position_id: [],
                valide_date_form: null,
                valide_date_to: null
            }),
            valueErrors:'',
            valueCountry:'KH',
        }
    },
    created() {
       
    },
    methods: {
        submitEmployee() {
            this.form.post(route('employee.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create employee successfully", {
                    });
                },
                onError: () => {
                    this.toast.errors("Create employee Errors", {
                    });
                },
            });
        }
    }

}

</script>

<template>
    <AppLayout title="Employee-create">
        <div class="py-4">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="p-2 rounded-lg bg-slate-100">
                        <span class="float-left"><HomeIcon class="h-5 w-8 text-blue-500" /></span>
                        <span class="float-left ml-2">
                            <Link :href="route('employee.index')" class="text-primary-600">
                                Employee
                            </Link>
                        </span>
                        <span class="float-left mt-[4px] ml-2"><ChevronRightIcon class="h-4 w-8 text-blue-500" /></span>
                        <Link href="" class="text-primary-600">
                            Create
                        </Link>
                    </div>
                    <div class="">
                        <form @submit.prevent="submit">
                            <InputGroup
                                label="First Name"
                                name="first_name"
                                variant="inline"
                                class="relative"
                            >
                            <span class="absolute left-[120px] top-6 z-10 text-rose-500">*</span>
                                <VanillaInput
                                    v-model="form.first_name"
                                    name="first_name"
                                    type="text"
                                    placeholder="Enter First Name"
                                    :errors="form.errors.first_name"
                                />
                            </InputGroup>
                            <InputGroup
                                label="Last Name"
                                name="last_name"
                                variant="inline"
                                class="relative"
                            >
                            <span class="absolute left-[120px] top-6 z-10 text-rose-500">*</span>
                                <VanillaInput
                                    v-model="form.last_name"
                                    name="last_name"
                                    type="text"
                                    placeholder="Enter Last Name"
                                    :errors="form.errors.last_name"
                                />
                            </InputGroup>
                            <InputGroup
                                label="Gender"
                                name="gender"
                                variant="inline"
                                class="relative"
                            >
                            <span class="absolute left-[120px] top-6 z-10 text-rose-500">*</span>
                            <RichSelect
                                v-model="form.gender"
                                :options="optionsGender"
                                :tags="true"
                                :clearable="true"
                                value-attribute="value"
                                text-attribute="text"
                                placeholder="Please select a gender"
                                :errors="form.errors.gender"
                            >
                            </RichSelect>
                            </InputGroup>
                            <InputGroup
                                label="Phone Number"
                                name="phone"
                                variant="inline"
                                class="relative"
                            >
                            <PhoneInput
                                v-model="form.phone"
                                :country-code="valueCountry"
                                :favorite-countries="['KH','US']"
                                country-placeholder="Pick your phone country"
                                phone-placeholder="Please input phone Number"
                            />
                            </InputGroup>
                            <InputGroup
                                label="Address"
                                name="address"
                                variant="inline"
                                class="relative"
                            >
                            <span class="absolute left-[120px] top-6 z-10 text-rose-500">*</span>
                                <VanillaTextArea
                                    v-model="form.address"
                                    name="address"
                                    placeholder="Please input Address"
                                    :errors="form.errors.address"
                                />
                            </InputGroup>
                            <InputGroup
                                label="Position"
                                name="position"
                                variant="inline"
                                class="relative"
                            >
                            <span class="absolute left-[120px] top-6 z-10 text-rose-500">*</span>
                            <RichSelect
                                v-model="form.position_id"
                                :options="positions"
                                :tags="true"
                                :clearable="true"
                                value-attribute="id"
                                text-attribute="name"
                                placeholder="Please select a Position"
                                :errors="form.errors.position_id"
                            >
                            </RichSelect>
                            </InputGroup>
                            <InputGroup
                                label="Valide date staff form-to"
                                name="start_date"
                                variant="inline"
                                class="relative"
                            >
                            <span class="absolute left-[190px] top-6 z-10 text-rose-500">*</span>
                            <div class="float-left">
                                <div class="float-left w-1/3">
                                    <DateTimeInput
                                        v-model="form.valide_date_form"
                                        :is-required="false"
                                        :inline="false"
                                        :masks="masks"
                                        mode="date"
                                        :errors="form.errors.valide_date_form"
                                        :select-attribute="selectDragAttribute"
                                        :drag-attribute="selectDragAttribute"
                                        placeholder="Please select your valide date form"
                                    />
                                </div>

                                <div class="float-left w-1/3 ml-5">   
                                    <DateTimeInput
                                        v-model="form.valide_date_to"
                                        :is-required="false"
                                        :inline="false"
                                        :masks="masks"
                                        mode="date"
                                        :errors="form.errors.valide_date_to"
                                        :select-attribute="selectDragAttribute"
                                        :drag-attribute="selectDragAttribute"
                                        placeholder="Please select your valide date to"
                                    />
                                </div>
                            </div>
                            </InputGroup>
                            
                            <InputGroup
                                label="Status"
                                name="is_active"
                                variant="inline"
                                class="relative"
                            >
                            <Toggle
                                v-model="form.is_active"
                            />
                            </InputGroup>
                            <InputGroup
                                label="Face Scan"
                                name="face_sacn"
                                variant="inline"
                                class="relative"
                            >
                            <div class="w-full bg-gray-200 px-2 h-[250px] flex">
                                <div class="camera-box w-1/2 h-full">
                                    camera-box
                                </div>
                                <div class="btn-box w-1/2 h-full">
                                    btn
                                </div>
                            </div>
                            </InputGroup>
                            <Button
                                class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg float-right"
                                label="Save"
                                variant="primary"
                                type="submit"
                                @click="submitEmployee"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>