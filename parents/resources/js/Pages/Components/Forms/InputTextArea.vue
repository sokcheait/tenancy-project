<template>
    <div class="py-3 px-2 w-1/2">
        <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
            {{ inputLable }}
            <span v-if="requirest" class="text-rose-500">*</span>
        </label>
        <VanillaTextArea
            v-model="model"
            :placeholder="placeholder"
            type="text"
            :errors="errors"
        />
    </div>
</template>
<script>
import { Textarea as VanillaTextArea } from '@flavorly/vanilla-components'
export default {
    name:'InputText',
    components: {
        VanillaTextArea
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
        value: {
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
        }
    },
    computed:{
        model: {
            get() { return this.value },
            set(newValue) { this.$emit('update:modelValue', newValue) } 
        }
    }
}
</script>
