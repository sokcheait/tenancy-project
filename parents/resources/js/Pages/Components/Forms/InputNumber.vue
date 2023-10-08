<template>
    <div class="py-2 px-2 w-1/2">
        <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
            {{ inputLable }}
            <span v-if="requirest" class="text-rose-500">*</span>
        </label>
        <Input
            v-model="model"
            :placeholder="placeholder"
            type="number"
            :errors="errors"
            :disabled="disabled"
        />
    </div>
</template>
<script>
import { Input } from '@flavorly/vanilla-components'
export default {
    name:'InputNumber',
    components: {
        Input
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
            type: Number,
            default: null,
        },
        requirest: {
            type: String,
            default: '',
        },
        errors: {
            type: String,
            default: '',
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    computed:{
        model: {
            get() {return this.modelValue },
            set(newValue) { this.$emit('update:modelValue', newValue) } 
        }
    },
}
</script>
