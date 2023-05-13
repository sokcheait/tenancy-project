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
  Input as VanillaInput,
  Select as VanillaSelect,
} from '@flavorly/vanilla-components';
import { HomeIcon,ChevronRightIcon ,UserIcon} from '@heroicons/vue/24/solid'

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
    },
    props: {
        errors: Object
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        });
        const toast = useToast()
        return { form, toast }
    },
    data() {
        return {
            valueErrors:''
        }
    },
    created() {
        // this.toast.success("My toast content", {
            
        // });
    },
    methods: {
        submitUser() {
            this.form.post(route('users.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create user successfully", {
                    });
                },
                onError: () => {
                    this.toast.errors("Create user Errors", {
                    });
                },
            });
        }
    }

}

</script>

<template>
    <AppLayout title="Users">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-[150px]"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('users.index')" class="text-gray-200 dark:text-white">
                            Users
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
                <form @submit.prevent="submitUser">
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
                        label="E-mail"
                        name="email"
                        variant="inline"
                        class="relative"
                    >
                    <span class="absolute left-20 top-6 z-10 text-rose-500">*</span>
                        <VanillaInput
                            v-model="form.email"
                            name="email"
                            type="email"
                            placeholder="Enter Email"
                            :errors="form.errors.email"
                        />
                    </InputGroup>
                    <InputGroup
                        label="Password"
                        name="password"
                        variant="inline"
                        class="relative"
                    >
                    <span class="absolute left-[90px] top-6 z-10 text-rose-500">*</span>
                        <VanillaInput
                            v-model="form.password"
                            name="password"
                            type="password"
                            placeholder="Enter password"
                            :errors="form.errors.password"
                        />
                    </InputGroup>
                    <InputGroup
                        label="Password confirmation"
                        name="password_confirmation"
                        variant="inline"
                        class="relative"
                    >
                    <span class="absolute left-[180px] top-6 z-10 text-rose-500">*</span>
                        <VanillaInput
                            v-model="form.password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="Enter Password confirmation"
                            :errors="form.errors.password_confirmation"
                        />
                    </InputGroup>
                    <Button
                        class="w-[125px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg"
                        label="Save"
                        variant="primary"
                        type="submit"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    />
                    <Button
                        class="w-[125px] bg-rose-500 text-slate-50 text-center p-2 rounded-lg ml-4"
                        label="Close"
                        type="button"
                    />
                </form>
            </div>
        </div>
    </AppLayout>
</template>