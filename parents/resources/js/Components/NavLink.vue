<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'bg-gray-300 w-full float-left rounded-lg p-2'
        : 'w-full float-left rounded-lg p-2';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
