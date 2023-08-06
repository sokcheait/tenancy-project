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
  Toggle,
} from '@flavorly/vanilla-components';
import { HomeIcon,ChevronRightIcon ,UserIcon} from '@heroicons/vue/24/solid'
import Swal from 'vue-sweetalert2';

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
        HomeIcon,
        ChevronRightIcon,
        UserIcon,
    },
    props: {
        categories: Object,
        errors: Object
    },
    setup() {
        const swal = Swal;
        const toast = useToast()
        return { toast, swal }
    },
    data() {
        return {
            valueErrors:'',
            form: useForm({
                category_name:this.categories.category_name,
                is_active: this.categories.is_active,
            })
        }
    },
    created() {
       
    },
    methods: {
        updateCategory() {
            this.$swal.fire(({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon:"warning",
                showCancelButton: true,
                buttonsStyling: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Yes, Update it!"
            })).then((result) => { 
                if (result.value) {
                    this.form.put(route('categories.update',this.categories.id), {
                        preserveScroll: true,
                            onSuccess: () => {
                                this.toast.success("Your post has been Updated!", {
                                    
                                });
                            },
                    }); 
                }
            });
        }
    }

}

</script>

<template>
    <AppLayout title="Category-create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category Edit
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="p-2 rounded-lg bg-slate-100">
                        <span class="float-left"><HomeIcon class="h-5 w-8 text-blue-500" /></span>
                        <span class="float-left ml-2">
                            <Link :href="route('categories.index')" class="text-primary-600">
                                Category
                            </Link>
                        </span>
                        <span class="float-left mt-[4px] ml-2"><ChevronRightIcon class="h-4 w-8 text-blue-500" /></span>
                        <Link href="" class="text-primary-600">
                            Edit
                        </Link>
                    </div>
                    <div class="">
                        <form @submit.prevent="updateCategory">
                            <InputGroup
                                label="Name"
                                name="category_name"
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