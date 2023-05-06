<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'relative flex flex-row items-center h-11 focus:outline-none bg-blue-800 dark:bg-gray-600 text-white-600 text-white-800 border-l-4 border-transparent border-blue-500 dark:border-gray-800 pr-6'
        : 'relative flex flex-row items-center h-11';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
