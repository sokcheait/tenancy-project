<template>
    <div class="py-2 px-2 w-1/2">
        <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
            {{ inputLable }}
            <span v-if="requirest" class="text-rose-500">*</span>
        </label>
        <MazPhoneNumberInput
            v-model="phoneNumber"
            show-code-on-list
            :no-example="noExample"
            :placeholder="placeholder"
            :disabled="disabled"
            :fetch-country="['KH']"
            :preferred-countries="['KH', 'TH', 'US', 'VN']"
            :ignored-countries="['AC']"
            @update="results = $event"
            :success="results?.isValid"
        />
    </div>
</template>
<script>
import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'
export default {
    name:'InputPhone',
    components: {
        MazPhoneNumberInput
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
        // phoneNumber: {
        //     type: String,
        //     default: '',
        // },
        requirest: {
            type: String,
            default: '',
        },
        noExample: {
            type: Boolean,
            default: false
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
        // model: {
        //     get() { return this.phoneNumber },
        //     set(newValue) { this.$emit('update:modelValue', newValue) } 
        // }
    },
}
</script>
