<template>
    <div>
        <div class="flex items-center justify-center w-full">
            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div v-if="is_preview" class="flex flex-col items-center justify-center pt-5 pb-6">
                    <span v-for="(viewImage,index) in preview" :key="index">
                        <img :src="viewImage" alt="" class="w-full h-64 p-2 rounded-lg" />
                    </span>
                </div>
                <div v-else class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                </div>
                <input id="dropzone-file" type="file" class="hidden" @change="onFileChange($event)" />
            </label>

        </div>
    </div>
</template>
<script>
  export default {
    name:"FileUpload",
    props: {
        preview: {
            type: Array,
            default: [],
        },
        is_preview: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {

        }
    },
    methods: {
        onFileChange($event) {
            const file = $event.target.files[0];
            const reader = new FileReader();
            if (file) {
                reader.readAsDataURL(file);
                reader.onload = () => {
                // Set a new property on the captured `file` and set it to the converted base64 image
                file.previewBase64 = reader.result;
                // Emit the file with the new previewBase64 property on it
                this.$emit('file-updated', file);
                };
                reader.onerror = (error) => {
                console.log("Error ", error);
                };
            }
        }
    },
  }
</script>