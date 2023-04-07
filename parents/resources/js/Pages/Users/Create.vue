<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import {
  Alert, 
  Button,
  CheckboxGroup,
  CountryInput,
  FormSection,
  InputGroup,
  Input as VanillaInput,
  Select as VanillaSelect,
} from '@flavorly/vanilla-components'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submitUser = () => {
    form.post(route('users.store'), {
        preserveScroll: true,
    });
};

</script>

<template>
    <AppLayout title="Users-create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="p-2 rounded-lg bg-slate-100">
                        <Link :href="route('users.index')" class="text-primary-600 underline underline-offset-1">
                            Users
                        </Link>
                        <span>/</span>
                        <Link href="">
                            Create
                        </Link>
                    </div>
                    <div class="">
                        <form @submit.prevent="submitUser">
                            <InputGroup
                                label="Name"
                                name="name"
                                variant="inline"
                            >
                                <VanillaInput
                                    v-model="form.name"
                                    name="name"
                                    type="text"
                                    placeholder="Enter Name"
                                    feedback="Im showing only because you cleared errors"
                                    errors="We have a problem Musk, Abort! Write to clear"
                                />
                            </InputGroup>
                            <InputGroup
                                label="E-mail"
                                name="email"
                                variant="inline"
                            >
                                <VanillaInput
                                    v-model="form.email"
                                    name="email"
                                    type="email"
                                    placeholder="Enter Email"
                                />
                            </InputGroup>
                            <InputGroup
                                label="Password"
                                name="password"
                                variant="inline"
                            >
                                <VanillaInput
                                    v-model="form.password"
                                    name="password"
                                    type="password"
                                    placeholder="Enter password"
                                />
                            </InputGroup>
                            <InputGroup
                                label="Password confirmation"
                                name="password_confirmation"
                                variant="inline"
                            >
                                <VanillaInput
                                    v-model="form.password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    placeholder="Enter Password confirmation"
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