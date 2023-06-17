<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref,watch } from 'vue';
import { useToast } from "vue-toastification";
import {
  Alert, 
  Button,
  Input,
  CheckboxGroup,
  CountryInput,
  FormSection,
  InputGroup,
  Input as VanillaInput,
  Select as VanillaSelect,
  Dialog, RichSelect
} from '@flavorly/vanilla-components';
import { HomeIcon,ChevronRightIcon ,UserIcon, UserCircleIcon} from '@heroicons/vue/24/solid'

export default {
    components: {
        AppLayout,
        reactive,
        Head,
        Link,
        useForm,
        ref,
        watch,
        Alert, 
        Button,
        Input,
        CheckboxGroup,
        CountryInput,
        FormSection,
        InputGroup,
        VanillaInput,
        VanillaSelect,
        Dialog, RichSelect,
        HomeIcon,
        ChevronRightIcon,
        UserIcon,
        UserCircleIcon
    },
    props: {
        errors: Object
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        });
        const toast = useToast()
        const open = ref(true)
        return { form, toast,open }
    },
    data() {
        return {
            valueErrors:'',
            isCameraOpen: false,
            isPhotoTaken: false,
            isShotPhoto: false,
            isLoading: false,
            link: '#'
        }
    },
    created() {
        
    },
    methods: {
        toggleCamera() {
            if(this.isCameraOpen) {
                this.isCameraOpen = false;
                this.isPhotoTaken = false;
                this.isShotPhoto = false;
                this.stopCameraStream();
            } else {
                this.isCameraOpen = true;
                this.createCameraElement();
            }
        },
    
        createCameraElement() {
            this.isLoading = true;
            const constraints = (window.constraints = {
                        audio: false,
                        video: true
                    });
                    navigator.mediaDevices
                        .getUserMedia(constraints)
                        .then(stream => {
                this.isLoading = false;
                            this.$refs.camera.srcObject = stream;
                        })
                        .catch(error => {
                this.isLoading = false;
                        alert("May the browser didn't support or there is some errors.");
                     });
        },
    
    stopCameraStream() {
      let tracks = this.$refs.camera.srcObject.getTracks();

			tracks.forEach(track => {
				track.stop();
			});
    },
    
    takePhoto() {
      if(!this.isPhotoTaken) {
        this.isShotPhoto = true;

        const FLASH_TIMEOUT = 50;

        setTimeout(() => {
          this.isShotPhoto = false;
        }, FLASH_TIMEOUT);
      }
      
      this.isPhotoTaken = !this.isPhotoTaken;
      
      const context = this.$refs.canvas.getContext('2d');
      context.drawImage(this.$refs.camera, 0, 0, 450, 337.5);
    },
    }

}

</script>

<template>
    <AppLayout title="Face Users">
        <div class="w-full p-4">
            <Dialog v-model="open" :closeableOnClickOutside="false">
            <div>
                <div class="mx-auto flex items-center justify-center rounded-full">
                <UserCircleIcon
                    class="h-48 w-48 text-gray-300"
                    aria-hidden="true"
                />
                </div>
                <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                    Face authentication User
                </h3>
                <div class="mt-2">
                    <!-- <p class="text-sm text-gray-500 dark:text-gray-400">
                        Face IO
                    </p> -->
                    <div id="app" class="web-camera-container">
                        <div class="camera-button">
                            <button type="button" class="button is-rounded" :class="{ 'is-primary' : !isCameraOpen, 'is-danger' : isCameraOpen}" @click="toggleCamera">
                                <span v-if="!isCameraOpen">Open Camera</span>
                                <span v-else>Close Camera</span>
                            </button>
                        </div>
                        
                        <div v-show="isCameraOpen && isLoading" class="camera-loading">
                            <ul class="loader-circle">
                            <li></li>
                            <li></li>
                            <li></li>
                            </ul>
                        </div>
                        
                        <div v-if="isCameraOpen" v-show="!isLoading" class="camera-box" :class="{ 'flash' : isShotPhoto }">
                            
                            <div class="camera-shutter" :class="{'flash' : isShotPhoto}"></div>
                            
                            <video v-show="!isPhotoTaken" ref="camera" :width="450" :height="337.5" autoplay></video>
                            
                            <canvas v-show="isPhotoTaken" id="photoTaken" ref="canvas" :width="450" :height="337.5"></canvas>
                        </div>
                        
                        <div v-if="isCameraOpen && !isLoading" class="camera-shoot">
                            <button type="button" class="button" @click="takePhoto">
                            <img src="https://img.icons8.com/material-outlined/50/000000/camera--v2.png">
                            </button>
                        </div>
                        
                        <div v-if="isPhotoTaken && isCameraOpen" class="camera-download">
                            <a id="downloadPhoto" download="my-photo.jpg" class="button" role="button" @click="downloadImage">
                            Download
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <form @submit.prevent="submitUser">
                    <InputGroup
                        label="Name"
                        name="name"
                        variant="inline"
                        class="relative"
                    >
                        <VanillaInput
                            v-model="form.name"
                            name="name"
                            type="text"
                            placeholder="Enter Name"
                            :errors="form.errors.name"
                        />
                    </InputGroup>
                    <InputGroup
                        label="E-mail"
                        name="email"
                        variant="inline"
                        class="relative"
                    >
                        <VanillaInput
                            v-model="form.email"
                            name="email"
                            type="email"
                            placeholder="Email"
                            :errors="form.errors.email"
                        />
                    </InputGroup>
                    <InputGroup
                        label="Password"
                        name="password"
                        variant="inline"
                        class="relative"
                    >
                        <VanillaInput
                            v-model="form.password"
                            name="password"
                            type="password"
                            placeholder="password"
                            :errors="form.errors.password"
                        />
                    </InputGroup>
                    <InputGroup
                        label="Password confirmation"
                        name="password_confirmation"
                        variant="inline"
                        class="relative"
                    >
                        <VanillaInput
                            v-model="form.password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="Password confirmation"
                            :errors="form.errors.password_confirmation"
                        />
                    </InputGroup>
                    <div class="mt-5 sm:mt-6">
                        <div
                        class="w-1/3 bg-blue-600 my-4 text-white p-2 ml-2 rounded-md float-right"
                        >
                        <Link :href="route('users.index')">Save</Link>
                        </div>
                        <div
                        class="w-1/3 my-4 bg-rose-500 text-white p-2 rounded-md float-right"
                        >
                        <Link :href="route('users.index')">close</Link>
                        </div>
                    </div>
            </form>
            </Dialog>
        </div>
    </AppLayout>
</template>