<template>
    <div class="py-3 px-2 w-1/2">
        <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
            {{ inputLable }}
            <span v-if="requirest" class="text-rose-500">*</span>
        </label>
        <DateTimeInput
            v-model="model"
            :is-required="false"
            :inline="false"
            :masks="masks"
            mode="date"
            :errors="errors"
            :select-attribute="selectDragAttribute"
            :drag-attribute="selectDragAttribute"
            :placeholder="placeholder"
        />
    </div>
</template>
<script>
import { DateTimeInput } from '@flavorly/vanilla-components'
import { ref,watch } from 'vue';
export default {
    name:'DateSelect',
    components: {
        DateTimeInput,
        ref
    },
    props: {
        inputLable: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: '',
        },
        modelValue: {
            type: String,
            default: '',
        },
        requirest: {
            type: String,
            default: '',
        },
        errors: {
            type: String,
            default: '',
        },
        masks: {
            type: Object,
            default: [], 
        },
        selectDragAttribute: {
            type: Object,
            default: [],
        }
    },
    setup() {
        const masks = ref({
            input: 'DD/MM/YYYY',
        });
        const timezone = ref('UTC');
        const selectDragAttribute = {
            popover: {
                visibility: 'hover',
                isInteractive: false, 
            },
        }
        return { masks,selectDragAttribute, timezone}
    },
    computed:{
        model: {
            get() { if(this.modelValue) return this.modelValue; },
            set(newValue) { this.$emit('update:modelValue', newValue) } 
        }
    }
}
</script>
