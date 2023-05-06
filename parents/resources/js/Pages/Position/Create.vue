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
  Avatar,
  CheckboxGroup,
  CountryInput,
  FormSection,
  InputGroup,
  Input as VanillaInput,
  Select as VanillaSelect,
  Toggle,
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
        Toggle,
        Avatar,
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
            is_active: null,
            image: null,
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
       
    },
    methods: {
        submitPosition() {
            this.form.post(route('position.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.toast.success("Create position successfully", {
                    });
                },
                onError: () => {
                    this.toast.errors("Create position Errors", {
                    });
                },
            });
        }
    }

}

</script>

<template>
    <AppLayout title="Position-create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Position Create
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="p-2 rounded-lg bg-slate-100">
                        <span class="float-left"><HomeIcon class="h-5 w-8 text-blue-500" /></span>
                        <span class="float-left ml-2">
                            <Link :href="route('users.index')" class="text-primary-600">
                                Position
                            </Link>
                        </span>
                        <span class="float-left mt-[4px] ml-2"><ChevronRightIcon class="h-4 w-8 text-blue-500" /></span>
                        <Link href="" class="text-primary-600">
                            Create
                        </Link>
                    </div>
                    <div class="">
                        <form @submit.prevent="submitPosition">
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
                                label="Photo"
                                name="image"
                                variant="inline"
                                class="relative"
                            >
                            <div class="flex">
                                <Avatar
                                    v-model="form.image"
                                    uploadButtonLabel="uplode photo"
                                />
                            </div>
                            </InputGroup>
                            <Button
                                class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg float-right"
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