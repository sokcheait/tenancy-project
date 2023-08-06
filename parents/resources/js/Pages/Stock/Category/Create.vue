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
import FileUpload from "@/Components/FileUpload.vue"

export default {
    components: {
        AppLayout,
        reactive,
        Head,
        Link,
        useForm,
        FileUpload,
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
            category_name: '',
            is_active: false,
        });
        const toast = useToast()
        return { form, toast }
    },
    data() {
        return {
            valueErrors:'',
        }
    },
    created() {
       
    },
    methods: {
        async submitCategory() {
            await this.form.post(route('categories.store'), {
                preserveScroll: true,
                onSuccess: (res) => {
                    if(this.$page.props.flash.message){
                        this.toast.success("Create categories successfully");
                    }else if(this.$page.props.flash.errror){
                        this.toast.error(this.$page.props.flash.errror.data.category_name[0])
                    }
                },
                onError: () => {
                    this.toast.error("The category name field is required.");
                },
            });
        },
    }

}

</script>

<template>
    <AppLayout title="Category-create">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-[150px]"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('categories.index')" class="text-gray-200 dark:text-white">
                            Category
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
                <form @submit.prevent="submitCategory">
                            <InputGroup
                                label="Name"
                                name="name"
                                variant="inline"
                                class="relative"
                            >
                            <span class="absolute left-20 top-6 z-10 text-rose-500">*</span>
                                <VanillaInput
                                    v-model="form.category_name"
                                    name="category_name"
                                    type="text"
                                    placeholder="Enter category name"
                                    :errors="form.errors.category_name"
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
                            <Button
                                class="w-[80px] bg-primary-500 text-slate-50 text-center p-2 rounded-lg"
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