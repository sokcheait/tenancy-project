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
            permission_all: false,
        }
    },
    created() {
       
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
        }
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
                    <div class="w-full my-2 shadow-md rounded-md p-2 text-gray-400" v-for="(lable,ind) in list_permissions" :key="ind">
                        <label class="text-gray-500 px-4 border border-gray-300 p-1 rounded hover:bg-gray-400 hover:text-white">{{ ind }}</label>
                        <div class="flex py-4 text-gray-500">
                            <div class="flex ml-8" v-for="(val,key) in lable" :key="key">
                                <Checkbox
                                    v-model="form.permissions"
                                    :value="key"
                                    :checked-value="form.permissions"
                                    :unchecked-value="form.permissions"
                                />
                                <label class="text-sm px-2">{{ val }}</label>
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