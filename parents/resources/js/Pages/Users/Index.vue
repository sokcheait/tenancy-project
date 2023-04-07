<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button } from '@flavorly/vanilla-components';
import { Head, Link, useForm } from '@inertiajs/vue3';

</script>

<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                   <div class="mb-4">
                    <Link :href="route('users.create')">
                        <Button
                            label="Create User"
                            variant="primary"
                        />
                    </Link>
                   </div>
                   <div>
                        Table
                   </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>