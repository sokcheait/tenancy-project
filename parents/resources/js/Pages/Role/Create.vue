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
  CheckboxGroup,
  CountryInput,
  FormSection,
  InputGroup,
  Toggle,
  Input as VanillaInput,
  Select as VanillaSelect,
} from '@flavorly/vanilla-components';
import { HomeIcon,ChevronRightIcon ,UserIcon} from '@heroicons/vue/24/solid'
import { Checkbox } from '@flavorly/vanilla-components'

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
        Toggle,
        VanillaSelect,
        Checkbox,
        HomeIcon,
        ChevronRightIcon,
        UserIcon,
    },
    props: {
        permissions: Object,
        list_permissions: Object,
        errors: Object
    },
    setup() {
        const form = useForm({
            name: '',
            permissions:[]
        });
        const toast = useToast()
        return { form, toast }
    },
    data() {
        return {
            valueErrors:'',
            isCheckAll: [], 
            showLoading:'',
            showCheckBox:'',
        }
    },
    created() {
    //    if(this.form.permissions.length>0){
            
    //    }
    },
    watch:{
        'form.permissions':function(value) {
            if(value.length==0){
                this.isCheckAll=[];
            }
            console.log(value)
        }
    },
    methods: {
        submitRole() {
            this.form.post(route('roles.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create Role successfully", {
                    });
                },
                onError: () => {
                    this.toast.errors("Create Role Errors", {
                    });
                },
            });
        },
        checkAll(data,key) {
            if(this.isCheckAll[key]==undefined || this.isCheckAll[key]==false){
               this.loading(key);
                data.forEach((value, index) => {
                    this.form.permissions.push(value);
                });
                // console.log(this.form.permissions)
            }else{
                // console.log(this.form.permissions.filter(x => !data.includes(x)))
                this.loading(key);
                this.form.permissions = this.form.permissions.filter(x => !data.includes(x));
                
            }
        },
        loading(key) {
            this.showLoading = key;
            if(this.showLoading) {
                this.showCheckBox=key;
                setTimeout(() => {
                   this.showLoading = '';
                   this.showCheckBox = this.showLoading;
                }, 600);
            }
        }
    },
    mounted(){
       
    }

}

</script>

<template>
    <AppLayout title="Roles">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-[150px]"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('users.index')" class="text-gray-200 dark:text-white">
                            Role
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
            <div class="bg-white text-gray-500 dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 text-white font-medium group">    
                <form @submit.prevent="submitRole">
                    <div class="text-gray-500">
                        <!-- {{ list_permissions }} -->
                        <!-- {{  permissions }} -->
                    </div>
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
                        label="Permission"
                        name="permission"
                        variant="inline"
                        class="relative"
                    >
                    <div class="w-full" v-for="(lable,ind) in list_permissions" :key="ind">
                        <div class="w-full my-2 shadow-md rounded-tl-lg rounded-br-lg pr-2 pt-1 text-gray-400 group relative inline-block overflow-hidden border border-gray-100 text-sm font-medium text-slate-800 hover:text-violet-600 focus:outline-none focus:ring active:text-white">
                            <span class="ease absolute left-0 top-0 h-0 w-0 border-t-2 border-blue-600 transition-all duration-200"
                            :class="{'group-hover:w-full':isCheckAll[ind]==true}"
                            >
                            </span>
                            <span class="ease absolute right-0 top-0 h-0 w-0 border-r-2 border-blue-600 transition-all duration-200"
                            :class="{'group-hover:h-full':isCheckAll[ind]==true}"
                            >
                            </span>
                            <span class="ease absolute bottom-0 right-0 h-0 w-0 border-b-2 border-blue-600 transition-all duration-200"
                            :class="{'group-hover:w-full':isCheckAll[ind]==true}"
                            >
                            </span>
                            <span class="ease absolute bottom-0 left-0 h-0 w-0 border-l-2 border-blue-600 transition-all duration-200"
                            :class="{'group-hover:h-full':isCheckAll[ind]==true}"
                            >
                            </span>
                            <label class="text-gray-500 px-2 cursor-pointer border border-gray-300 rounded-tl-lg rounded-br-lg py-1 hover:bg-blue-600 hover:text-white capitalize"
                                :class="{'bg-blue-600':isCheckAll[ind]==true,'text-white':isCheckAll[ind]==true}"
                            >
                                <input type='checkbox' @click="checkAll( Object.keys(lable),ind)" v-model="isCheckAll[ind]" class="hidden">
                                {{ ind }}
                            </label>
                            <div class="flex py-4 text-gray-500">
                                <div class="flex ml-8" v-for="(val,key) in lable" :key="key">
                                    <div class="block flex" v-if="showLoading==ind">
                                        <svg aria-hidden="true" class="w-5 h-5 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                        <span class="text-sm px-1">{{ val }}</span>
                                    </div>
                                    <div v-if="showCheckBox !=ind" class="flex">
                                        <Checkbox
                                            v-model="form.permissions"
                                            :value="key"
                                            :checked-value="form.permissions"
                                            :unchecked-value="form.permissions"
                                            class="rounded-full"
                                        />
                                        <label class="text-sm px-2">{{ val }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </InputGroup>
                   
                    <Button
                        class="w-[125px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg"
                        label="Save"
                        variant="primary"
                        type="submit"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    />
                   
                </form>
            </div>
        </div>
    </AppLayout>
</template>