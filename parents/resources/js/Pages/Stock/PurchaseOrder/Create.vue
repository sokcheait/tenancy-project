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
    <AppLayout title="purchaseOrder-create">
        <div class="p-4 w-full">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center h-4 transition-all duration-300 transform px-4">
                    <span class="-ml-4"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('item.index')" class="text-gray-200 dark:text-white">
                            Purchase Order
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
                            <h3 class="text-gray-600 font-bold block p-2 mt-4 bg-gray-200 dark:bg-gray-800 dark:text-white border rounded">Purchase Order</h3>
                        </div>
                        <input-text v-model="form.po_code" 
                                inputLable="Purchase Order Code"
                        />
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
                        <div class="w-full">
                            <h3 class="text-gray-500 font-bold block p-2 ml-2 text-lg ml-1 border-b-4">Item Form</h3>
                        </div>
                        <select-text v-model="form.supplier_id"
                                    inputLable="Item"
                                    :options="suppliers"
                                    :tags="true"
                                    :clearable="true"
                                    requirest="requirest"
                                    value-attribute="value"
                                    text-attribute="text"
                                    placeholder="Please select a item"
                                    :errors="form.errors.supplier_id"
                                    class="w-[25%]"
                        
                        />
                        <input-text v-model="form.unit" 
                                    inputLable="Unit"
                                    placeholder="Please input unit"
                                    :errors="form.errors.unit"
                                    class="w-[25%]"
                                    
                        />
                        <input-text v-model="form.quantity" 
                                    inputLable="Quantity"
                                    placeholder="Please input quantity"
                                    :errors="form.errors.quantity"
                                    class="w-[25%]"
                                    
                        />
                        <div class="w-[25%] mt-9">
                            <Button
                                class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg ml-8"
                                label="Add item"
                                variant="primary"
                                type="submit"
                                @click="submitItem"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            />
                        </div>
                        
                        <!-- Item Table -->
                        <div class="w-full mt-4 mx-4">
                            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                                <div class="w-full overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                                <th class="px-4 py-3"></th>
                                                <th class="px-4 py-3">Quantity</th>
                                                <th class="px-4 py-3">Unit</th>
                                                <th class="px-4 py-3">Item</th>
                                                <th class="px-4 py-3">Cost</th>
                                                <th class="px-4 py-3">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                            <tr class="bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-400">
                                                <td class="px-4 py-3 text-xs">
                                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"> Approved </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center text-sm">
                                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                        <img class="object-cover w-full h-full rounded-full" src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjE3Nzg0fQ" alt="" loading="lazy" />
                                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold">Hans Burger</p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400">10x Developer</p>
                                                    </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-sm">$855.85</td>
                                                <td class="px-4 py-3 text-xs">
                                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"> Approved </span>
                                                </td>
                                                <td class="px-4 py-3 text-sm">10</td>
                                                <td class="px-4 py-3 text-sm">$369.75</td>
                                            </tr>

                                            <tr class="bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-400">
                                                <td class="px-4 py-3 text-xs">
                                                    <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full"> Pending </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center text-sm">
                                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                        <img class="object-cover w-full h-full rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;facepad=3&amp;fit=facearea&amp;s=707b9c33066bf8808c934c8ab394dff6" alt="" loading="lazy" />
                                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold">Jolina Angelie</p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400">Unemployed</p>
                                                    </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-sm">$369.75</td>
                                                <td class="px-4 py-3 text-xs">
                                                    <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full"> Pending </span>
                                                </td>
                                                <td class="px-4 py-3 text-sm">23</td>
                                                <td class="px-4 py-3 text-sm">$369.75</td>
                                            </tr>
                                        </tbody>
                                        <tbody class="border border-t-1">
                                            <tr class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                                <td class="px-4 py-3 text-sm" colspan="5">
                                                    <span class="float-right mr-[130px]">Sub Title</span>
                                                </td>
                                                <td class="px-4 py-3 text-sm">$369.75</td>
                                            </tr>
                                            <tr class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                                <td class="px-4 py-3 text-sm" colspan="5">
                                                    <ul class="list-none m-0 p-0">
                                                        <li class="float-right"><span class="mr-[50px]">%</span></li>
                                                        <li class="float-right">
                                                            <input type="text" class="w-[50px] h-[25px] mr-[30px]" />
                                                        </li>
                                                        <li class="float-right"><span class="mr-[20px]">Discount</span></li>
                                                    </ul>
                                                </td>
                                                <td class="px-4 py-3 text-sm">$369.75</td>
                                            </tr>
                                            <tr class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                                <td class="px-4 py-3 text-sm" colspan="5">
                                                    <span class="float-right mr-[130px]">Tax</span>
                                                </td>
                                                <td class="px-4 py-3 text-sm">$369.75</td>
                                            </tr>
                                            <tr class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                                <td class="px-4 py-3 text-sm" colspan="5">
                                                    <span class="float-right mr-[130px]">Total</span>
                                                </td>
                                                <td class="px-4 py-3 text-sm">$369.75</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="w-full px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                                    Hello
                                </div>
                            </div>
                        </div>
                        <!-- ./Client Table -->
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>