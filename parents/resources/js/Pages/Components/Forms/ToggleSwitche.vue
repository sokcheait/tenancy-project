<template>
    <div class="py-2 px-2 w-1/2">
        <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
            {{ inputLable }}
            <span v-if="requirest" class="text-rose-500">*</span>
        </label>
        <Toggle
            v-model="model"
            :icon=true
      />
    </div>
</template>
<script>
import { Toggle } from '@flavorly/vanilla-components'
export default {
    name:'ToggleSwitche',
    components: {
        Toggle
    },
    props: {
        inputLable: {
            type: String,
            default: '',
        },
        modelValue: {
            type: Boolean,
            default: false,
        },
        requirest: {
            type: String,
            default: '',
        },
    },
    computed:{
        model: {
            get() { return this.modelValue },
            set(newValueModel) { this.$emit('update:modelValue', newValueModel) } 
        }
    },
}
</script>

