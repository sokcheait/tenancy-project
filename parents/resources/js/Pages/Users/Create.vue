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
    <AppLayout title="Users-create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Create
            </h2>
        </template>

        <div class="py-4">
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
                            Create
                        </Link>
                    </div>
                    <div class="">
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
                                class="w-full bg-primary-500 text-slate-50 text-center p-2 rounded-lg"
                                label="Save"
                                variant="primary"
                                type="submit"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>