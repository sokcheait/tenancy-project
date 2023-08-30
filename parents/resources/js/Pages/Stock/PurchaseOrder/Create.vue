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

import { HomeIcon,ChevronRightIcon ,UserIcon, ArchiveBoxXMarkIcon, CalendarIcon} from '@heroicons/vue/24/solid'
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
        ArchiveBoxXMarkIcon
        
    },
    props: {
        errors: Object,
        suppliers: Object,
    },
    setup() {
        const toast = useToast()
        return { toast }
    },
    data() {
        return {
            form:useForm({
                supplier_id:'',
                po_code:'',     
                amount:null,       
                discount_perc: '',
                discount: null,    
                tax_perc: '',     
                tax:null,          
                remarks:'',      
                status:false,      

                item_id:'',    
                quantity:'' ,   
                price:'',       
                unit:'',        
                total:''       
            }),
            valueErrors:'',
            item_key:[],
            item_value:'',
            data_item:[],
            data_cost:[],
            cost_key:'',
            total_item: null,
            sub_total: null,
            sub_price:null,
            rel_total: null,
            disabled_supplier:false,
            discount_price:null,
            tax_price:null,
            tax_total:null,
        }
    },
    watch: {
        'form.supplier_id':function(value){
            this.listItem(value);
        },
        'form.item_id':function(value){
            this.listCost(value)
        },
        'form.discount':function(value){
            this.discountItem(value)
        },
        'form.tax':function(value){
            this.taxItem(value)
        }
    },
    created() {
        // this.operatorsItem()
        // this.listItem()
        // console.log(this.suppliers)
    },
    mounted() {
        // this.operatorsItem()
    },
    methods: {
        back() {
            this.$inertia.replace('/purchase-order')
        },
        submitPurchase() {
            // this.form.supplier_id='',
            // this.form.po_code='',     
            // this.form.amount=null,       
            // this.form.discount_perc= '',
            // this.form.discount= null,    
            // this.form.tax_perc= '',     
            // this.form.tax=null,          
            // this.form.remarks='',            
            // this.form.item_id=this.data_item['item'],    
            // this.form.quantity='',   
            // this.form.price='',       
            this.form.unit='',        
            this.form.total= this.tax_price,
            this.form.post(route('purchase-order.store',{
                data:this.data_item
                }), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create item successfully");
                },
                onError: () => {
                    this.toast.error("Create item Errors");
                },
            });
        },
        listItem(key) {
            if(key !=null){
                axios.get('/get-item/'+key)
                    .then(res => {
                        this.item_key = res.data.data
                        this.data_cost = res.data.data_all
                    })
            }
            this.form.item_id=null;
            this.item_key=null;
    
        },
        listCost(key){
            if(key !=null){
                this.item_value = this.item_key[key]
                this.cost_key = this.data_cost[key]
            }
        },
        addItem() {
            if(this.form.quantity!='' & this.form.item_id!='' & this.form.unit!=''){
                this.total_item = (this.form.quantity * this.cost_key).toFixed(2);
                this.sub_price += parseFloat(this.total_item);
                this.sub_total = this.sub_price.toFixed(2);
                this.discount_price = this.sub_total;
                this.tax_price = this.discount_price;
                const items ={
                    'quantity':this.form.quantity,
                    'unit':this.form.unit,
                    'item':this.form.item_id,
                    'item_value':this.item_value,
                    'cost':this.cost_key,
                    'total_item':this.total_item,
                };
                this.data_item.push(items)
                this.reset()
                this.disabled_supplier=true;
            }
        },
        removeItem(index) {
            this.data_item.splice(index, 1);
            if(this.data_item.length==0){
                this.disabled_supplier=false;
                this.sub_total= 0;
            }
            if(this.data_item.length>0){
                if(this.data_item.length==1){
                    this.data_item.forEach(element => 
                        this.rel_total = Math.ceil(element.total_item),
                    );
                }else{
                    this.data_item.forEach(element => 
                        this.rel_total += Math.ceil(element.total_item),
                    );
                }
                this.sub_total = this.rel_total.toFixed(2);
                this.discount_price = this.sub_total;
            }
            
        },
        discountItem(key) {
            if(key==''){
                this.discount_price=this.sub_price.toFixed(2);
            }else{
                const discount_total = (parseFloat(key)/100);
                const disc = this.sub_total-(this.sub_total * discount_total);
                this.discount_price=disc.toFixed(2);
                if(this.tax_total!=null){
                    let purchaseTax = (parseFloat(this.discount_price) + parseFloat(this.tax_total));
                    this.tax_price = purchaseTax.toFixed(2);
                }else{
                    this.tax_price=this.discount_price;
                }
                
            }
           
        },
        taxItem(key){
            if(key==''){
                this.tax_price=this.discount_price;
            }else{
                const tax = (parseFloat(key)/100);
                this.tax_total  = this.discount_price * tax;
                let purchaseTax = (parseFloat(this.discount_price) + parseFloat(this.tax_total));
                this.tax_price = purchaseTax.toFixed(2);
            }
        },
        reset() {
            this.form.quantity='',
            this.form.unit=''
        }
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
                                :disabled="true"
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
                                    :disabled="disabled_supplier"
                        
                        />
                        <div class="w-full">
                            <h3 class="text-gray-500 font-bold block p-2 ml-2 text-lg ml-1 border-b-4">Item Form</h3>
                        </div>
                        <select-text v-model="form.item_id"
                                    inputLable="Item"
                                    :options="item_key"
                                    :tags="true"
                                    :clearable="true"
                                    requirest="requirest"
                                    value-attribute="value"
                                    text-attribute="text"
                                    placeholder="Please select a item"
                                    :errors="form.errors.item_id"
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
                                @click="addItem"
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
                                            <tr v-for="(data ,index) in data_item" :key="index" class="bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-400">
                                                <td class="px-4 py-3 text-xs">
                                                    <span class="font-semibold leading-tight text-rose-600 bg-rose-100 rounded-full dark:bg-rose-700 dark:text-rose-100">
                                                        <ArchiveBoxXMarkIcon class="w-6 h-7 cursor-pointer" @click="removeItem(index)"/> 
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-xs">
                                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"> 
                                                        {{ data.quantity }} 
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-sm">{{ data.unit }} </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center text-sm">
                                                        <p class="font-semibold">{{ data.item_value }}</p>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-sm">{{ data.cost }}</td>
                                                <td class="px-4 py-3 text-sm">${{ data.total_item }}</td>
                                            </tr>
                                        </tbody>

                                        <tbody class="border border-t-1">
                                            <tr class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                                <td class="px-4 py-3 text-sm" colspan="5">
                                                    <span class="float-right mr-[180px]">Sub Total</span>
                                                </td>
                                                <td class="px-4 py-3 text-sm">${{ sub_total }}</td>
                                            </tr>
                                            <tr class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                                <td class="px-4 py-3 text-sm" colspan="5">
                                                    <ul class="list-none m-0 p-0">
                                                        <li class="float-right"><span class="mr-[80px]">%</span></li>
                                                        <li class="float-right">
                                                            <input v-model="form.discount" type="text" class="w-[60px] h-[22px] mr-[30px]" />
                                                        </li>
                                                        <li class="float-right"><span class="mr-[20px]">Discount</span></li>
                                                    </ul>
                                                </td>
                                                <td class="px-4 py-3 text-sm">${{ discount_price }}</td>
                                            </tr>
                                            <tr class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                                <td class="px-4 py-3 text-sm" colspan="5">
                                                    <ul class="list-none m-0 p-0">
                                                        <li class="float-right"><span class="mr-[80px]">%</span></li>
                                                        <li class="float-right">
                                                            <input v-model="form.tax" type="text" class="w-[60px] h-[22px] mr-[30px]" />
                                                        </li>
                                                        <li class="float-right"><span class="mr-[20px]">Tax</span></li>
                                                    </ul>
                                                </td>
                                                <td class="px-4 py-3 text-sm">${{ tax_price }}</td>
                                            </tr>
                                            <tr class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400 border-t-2">
                                                <td class="px-4 py-3 text-sm" colspan="5">
                                                    <span class="float-right mr-[180px]">Total</span>
                                                </td>
                                                <td class="px-4 py-3 text-sm">${{ tax_price }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <input-text-area v-model="form.remarks" 
                                    inputLable="Remarks"
                                    placeholder="Please input remarks"
                                    :errors="form.errors.remarks"          
                                />
                                <div class="w-full text-center px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                                    <div class="w-full">
                                            <Button
                                                class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg mx-2"
                                                label="Save"
                                                variant="primary"
                                                type="submit"
                                                @click="submitPurchase"
                                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                            />
                                            <Button
                                                class="w-[80px] bg-red-500 text-slate-50 text-center p-2 rounded-lg mx-2"
                                                label="Back"
                                                variant="error"
                                                @click="back"
                                            />
                                            
                                    </div>
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