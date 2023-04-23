<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref,watch } from 'vue';
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
} from '@flavorly/vanilla-components';
import { HomeIcon,ChevronRightIcon ,UserIcon, BadgeCheckIcon} from '@heroicons/vue/24/solid';
import Swal from 'vue-sweetalert2';
import { useToast } from "vue-toastification";

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
        HomeIcon,
        ChevronRightIcon,
        UserIcon,
        BadgeCheckIcon
    },
    props: {
        user: Object,
        errors: Object,
    },
    setup() {
        const swal = Swal;
        const toast = useToast()
        return { swal,toast }
    },
    data() {
        return {
            valueErrors:'',
            mumber: [
                {
                    'id':'001',
                    'img':'profile-picture-4.jpg',
                },
                {
                    'id':'002',
                    'img':'profile-picture-4.jpg',
                },
                {
                    'id':'003',
                    'img':'profile-picture-4.jpg',
                }
            ],
            form: useForm({
                name:this.user.name,
                email: this.user.email,
            })
        }
    },
    created() {
        
    },
    methods: {
       
    }

}
</script>

<template>
    <AppLayout title="Users-show">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Show
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="p-2 rounded-lg bg-slate-100">
                        <span class="float-left"><HomeIcon class="h-5 w-8 text-blue-500" /></span>
                        <span class="float-left ml-2">
                            <Link :href="route('users.index')" class="text-primary-600">
                             Users
                            </Link>
                        </span>
                        <span class="float-left mt-[4px] ml-2"><ChevronRightIcon class="h-4 w-8 text-blue-500" /></span>
                        <Link href="" class="text-primary-600">
                            Show
                        </Link>
                    </div>
                    <div class="grid grid-cols-6 gap-2 shadow-lg">
                        <div class="">
                            <div class="w-[120px] h-[120px] my-4 ml-4" v-if="Object.keys(user)">
                                <img class="w-full h-full object-cover" :src="'/storage/profile-photos/profile-picture-4.jpg'" alt="image">
                            </div>
                        </div>
                        <div class="mt-4 px-2">
                            <ChevronRightIcon class="h-[120px] w-[120px] text-blue-500" />
                        </div>
                        <div class="col-span-4">
                            <div class="text-gray-500 text-2xl mx-2 mt-3">Name:<span class="ml-2">{{ user.name }}</span></div>
                            <div class="text-gray-500 text-2xl mx-2 mt-3">E-mail:<span class="ml-2">{{ user.email }}</span></div>
                            <div class="text-gray-500 text-2xl mx-2 mt-3">Mumber:<span class="ml-2">10K</span></div>
                        </div>
                    </div>
                    <div class="w-full h-[350px] mt-4 shadow-lg">
                        <ul class="list-none px-2">
                            <li class="float-left" v-for="(item,index) in mumber" :key="index">
                                <div class="">
                                    <img class="w-10 h-10 rounded-full cursor-pointer" :src="'/storage/profile-photos/'+item.img" alt="image">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>