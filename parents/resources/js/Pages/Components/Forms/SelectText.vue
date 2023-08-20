<template>
    <div class="py-2 px-2 w-1/2">
        <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
            {{ inputLable }}
            <span v-if="requirest" class="text-rose-500">*</span>
        </label>
        <RichSelect
            v-model="model"
            :placeholder="placeholder"
            :options="options"
            :errors="errors"
            :tags="tags"
            :clearable="clearable"
            :value-attribute="valueAttribute"
            :text-attribute="textAttribute"
        />
    </div>
</template>
<script>
import { RichSelect } from '@flavorly/vanilla-components'
export default {
    name:'SelectText',
    components: {
        RichSelect
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
            default: null,
        },
        options: {
            type: Object,
            default:[],
        },
        requirest: {
            type: String,
            default: '',
        },
        errors: {
            type: String,
            default: '',
        },
        tags: {
            type: Boolean,
            default: false,
        },
        clearable: {
            type: Boolean,
            default: false,
        },
        valueAttribute: {
            type: String,
            default: '',
        },
        textAttribute: {
            type: String,
            default: '',
        }

    },
    computed:{
        model: {
            get() { return this.modelValue },
            set(newValue) { this.$emit('update:modelValue', newValue) } 
        }
    }
}
</script>
