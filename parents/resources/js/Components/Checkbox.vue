<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
    },
    label: {
        type: String,
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>


<template>
    <div>
        <input
            v-model="proxyChecked"
            type="checkbox"
            :value="value"
            class="bg-gray-100 hover:bg-gray-300 cursor-pointer w-6 h-6 border-3 border-amber-500 focus:outline-none rounded-md"
        >
        <label for="checkbox" class="ml-3 text-gray-500">{{ label }}</label>
    </div>
</template>
