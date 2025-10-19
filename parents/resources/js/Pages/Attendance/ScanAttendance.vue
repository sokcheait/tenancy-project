<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button,RichSelect } from '@flavorly/vanilla-components';
import { Head, Link,useForm } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon,PencilSquareIcon,EyeIcon,
    EllipsisVerticalIcon,Cog8ToothIcon,ArrowDownTrayIcon,CheckIcon,
        QrCodeIcon,
        ViewfinderCircleIcon,ClipboardDocumentCheckIcon,ShieldExclamationIcon,ShieldCheckIcon } from '@heroicons/vue/24/solid'
import Swal from 'vue-sweetalert2';
import { useToast } from "vue-toastification";
import moment from 'moment';
import SelectText from '@/Pages/Components/Forms/SelectText.vue'
import { CameraIcon } from '@heroicons/vue/24/outline'
export default {
    components: {
        AppLayout,
        Head,
        Link,
        Alert, 
        Button,
        HomeIcon,
        ChevronRightIcon,
        EllipsisVerticalIcon,
        Cog8ToothIcon,
        UserIcon,
        TrashIcon,
        PencilSquareIcon,
        EyeIcon,
        ArrowDownTrayIcon,
        RichSelect,
        SelectText,
        CheckIcon,
        QrCodeIcon,
        ViewfinderCircleIcon,
        ClipboardDocumentCheckIcon,ShieldExclamationIcon,ShieldCheckIcon,CameraIcon
    },
    props: {
        employees: Object,
    },
    setup() {
        const swal = Swal;
        const toast = useToast()

        return { swal,toast }
    },
    data() {
        return {
            form:useForm({
                employee_id:null,
                type:''
            }),
            btn_scan:"",
            data_QR:null,
            disableAttendanceType:false,
            checkedAttendance:'',
            faceAttendance:'',
            qrAttendance:'',
            booleanValue:false,
            is_loading:false,
            is_success:false,
            is_error:false,
            today:moment(new Date()).format("YYYY-MM-DD"),

            isCameraOpen: false,
            isPhotoTaken: false,
            isShotPhoto: false,
        }
    },
    watch: {
        'form.employee_id':function(val) {
            if(val){
                this.disableAttendanceType=true;
            }else{
                this.disableAttendanceType=false;
                this.resetAttendanceType();
            }
        },
        'form.type':function(val){
            this.is_loading=false;
            this.is_success=false;
            this.is_error=false;
            if(val=="checkedAttendance"){
                this.btn_scan = "checkedAttendance";
            }else if(val=="qrAttendance"){
                this.btn_scan = "qrAttendance";
                this.callEmployee(this.form.employee_id)
            }else if(val=="faceAttendance"){
                this.btn_scan = "faceAttendance";
                this.isCameraOpen = true;
                this.createCameraElement();
            }else{
                this.btn_scan = "";
            };
        }
    },
    methods: {
        resetAttendanceType() {
            this.checkedAttendance='';
            this.faceAttendance='';
            this.qrAttendance='';
            this.btn_scan=null;
            this.is_loading=false;
            this.is_success=false;
            this.is_error=false;
            this.form.reset();
        },
        scanAttendance(){
            this.is_loading = true;
            this.form.post(route('attendance.store'), {
                preserveScroll: true,
                onSuccess: (res) => {
                    this.is_loading = false;
                    this.is_success = true;
                    this.toast.success("Create attendance successfully");
                },
                onError: (res) => {
                    this.is_loading = false;
                    this.is_error =true;
                    this.toast.error(res.error);
                },
            });
        },
        onChangeProcessed(e){
            if(e.target.checked==true){
                this.form.type = e.target.value;
            }
        },
        callEmployee(employee_id) {
            if(employee_id !=null){
                axios.get('/call-employee-qr/'+employee_id)
                    .then(res => {
                        this.data_QR = JSON.stringify(res.data.employee);
                        this.scanAttendance();
                    })
            }else{
                this.toast.error("Please select a employee");
                this.btn_scan=null
            }
        },
        createCameraElement() {
            this.is_loading = true;
            const constraints = (window.constraints = {
                        audio: false,
                        video: true
                    });  
                navigator.mediaDevices
                    .getUserMedia(constraints)
                    .then(stream => {
                        this.is_loading = false;
                        this.$refs.camera.srcObject = stream;
                    })
                    .catch(error => {
                        this.is_loading = false;
                        alert("May the browser didn't support or there is some errors.");
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
            context.drawImage(this.$refs.camera, 0, 0, 350, 250);
            this.$refs.canvas.toBlob( (blob) => {
                const file = new File( [ blob ], "face.png" );
                this.$inertia.post(route('scan-attendance-face'),{
                    'file':file
                },{
                preserveScroll: true,
                onSuccess: (res) => {
                   console.log(res)
                },
                onError: (res) => {
                    
                },
            });
                // const dT = new DataTransfer();
                // dT.items.add( file );
                // document.querySelector( "input" ).files = dT.files;
            });
            // console.log(this.$refs.canvas.toDataURL("image/png"))
        },
    }

}

</script>

<template>
    <AppLayout title="Scan Attendance">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center transition-all duration-300 transform px-4 py-1">
                    <span class="-ml-5"><HomeIcon class="h-5 w-5 text-gray-200 dark:text-white" /></span>
                    <span class="mx-2 mt-1">Home</span>
                    <span class="mt-1"><ChevronRightIcon class="h-5 w-5 text-gray-200 dark:text-white" /></span>
                    <span class="mx-2 mt-1">
                        Scan Attendance
                    </span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 text-white font-medium group">
                <form @submit.prevent="submit">
                    <div class="flex flex-wrap text-black">
                        <div class="w-full">
                            <h3 class="text-gray-600 font-bold block p-2 mt-4 bg-gray-200 dark:bg-gray-800 dark:text-white border rounded">Scan Attendance Information</h3>
                        </div>
                        <div class="w-1/2 p-2">
                            <label class="font-semibold block text-gray-500 text-sm py-1 pl-1 dark:text-white">
                                Employee
                                <span class="text-rose-500">*</span>
                            </label>
                            <RichSelect
                                v-model="form.employee_id"
                                :options="employees"
                                :tags="true"
                                :clearable="true"
                                value-attribute="id"
                                text-attribute="last_name"
                                placeholder="Please select a Employee"
                                :errors="form.errors.employee_id"
                                class="text-gray-800"
                            />
                            <div v-if="btn_scan=='checkedAttendance'" class="flex text-gray-500 my-4 px-2">
                                <div class="p-2 text-center w-[150px] border rounded-md cursor-pointer hover:bg-gray-200 hover:text-white" @click="scanAttendance()">
                                    <span>Scan Attendance</span>
                                </div>   
                            </div>
                        </div>
                        <div v-if="disableAttendanceType==true" class="w-1/2">
                            <div class="flex flex-wrap justify-center mt-8">
                                <div class="px-2">
                                    <input class="peer sr-only" type="radio" 
                                            v-model="checkedAttendance" 
                                            value="checkedAttendance" 
                                            name="answer" 
                                            id="checkedAttendance" 
                                            :checked="booleanValue"
                                            @change="onChangeProcessed($event,e)"
                                        />
                                    <label class="flex justify-center items-center cursor-pointer rounded-full border border-gray-300 bg-white h-12 w-12 
                                        hover:bg-gray-50 focus:outline-none peer-checked:border-transparent peer-checked:ring-2 
                                        peer-checked:bg-green-200 transition-all duration-500 ease-in-out" for="checkedAttendance">
                                        <CheckIcon
                                                class="h-6 w-6 text-green-600"
                                                aria-hidden="true"
                                            />
                                    </label>
                                </div>
                                <div class="px-2">
                                    <input class="peer sr-only" type="radio" 
                                            v-model="faceAttendance" 
                                            value="faceAttendance" 
                                            name="answer" 
                                            id="faceAttendance"
                                            :checked="booleanValue"
                                            @change="onChangeProcessed($event,e)"
                                        />
                                        <label class="flex justify-center items-center cursor-pointer rounded-full border border-gray-300 
                                        bg-white h-12 w-12 hover:bg-gray-50 focus:outline-none peer-checked:border-transparent 
                                        peer-checked:ring-2 peer-checked:bg-teal-200 transition-all duration-500 ease-in-out" for="faceAttendance">
                                            <ViewfinderCircleIcon
                                                class="h-6 w-6 text-teal-700"
                                                aria-hidden="true"
                                            />
                                        </label>
                                </div>
                                <div class="px-2">
                                    <input class="peer sr-only" type="radio" 
                                            v-model="qrAttendance" 
                                            value="qrAttendance" 
                                            name="answer" 
                                            id="qrAttendance"
                                            :checked="booleanValue"
                                            @change="onChangeProcessed($event,e)"
                                        />
                                        <label class="flex justify-center cursor-pointer rounded-full border border-gray-300 
                                            bg-white h-12 w-12 items-center hover:bg-gray-50 focus:outline-none peer-checked:border-transparent 
                                            peer-checked:ring-2 peer-checked:bg-emerald-200 transition-all duration-500 ease-in-out " for="qrAttendance">
                                            <QrCodeIcon
                                                class="h-6 w-6 text-emerald-700"
                                                aria-hidden="true"
                                            />
                                        </label>
                                </div>
                            </div>
                            <div class="flex justify-center py-4 text-center">
                                <div class="w-[350px] border border-gray-300 rounded-md relative">
                                    <div class="w-full h-[250px] absolute z-10 flex justify-center">
                                        <div v-if="is_loading" class="w-16 h-16 bg-gray-300 bg-opacity-50 flex justify-center rounded-md mt-16">
                                            <svg aria-hidden="true" class="w-8 h-8 mt-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                            </svg>
                                        </div>
                                        <div v-if="is_success" class="w-16 h-16 bg-green-400 bg-opacity-50 flex justify-center rounded-md mt-16">
                                            <ShieldCheckIcon
                                                class="h-8 w-8 text-green-500 mt-4"
                                                aria-hidden="true"
                                            />
                                        </div>
                                        <div v-if="is_error" class="w-16 h-16 bg-red-400 bg-opacity-50 flex justify-center rounded-md mt-16">
                                            <ShieldExclamationIcon
                                                class="h-8 w-8 text-red-600 mt-4"
                                                aria-hidden="true"
                                            />
                                        </div>
                                    </div>
                                    <div v-if="btn_scan=='checkedAttendance'" class="w-full h-[250px] flex justify-center">
                                        <ClipboardDocumentCheckIcon class="w-24 h-24 text-green-500 mt-16" />
                                    </div>
                                    <div v-else-if="btn_scan=='qrAttendance'" class="w-full h-[250px] flex justify-center">
                                        <vue-qrcode :value="data_QR" :options="{ width: 220 }"></vue-qrcode>
                                    </div>
                                    <div v-else-if="btn_scan=='faceAttendance'" class="w-full h-[300px]">
                                        <div class="w-full h-full">
                                            <div v-if="isCameraOpen" v-show="!is_loading" class="camera-box" :class="{ 'flash' : isShotPhoto }">
                                                <video v-show="!isPhotoTaken" ref="camera" :width="350" :height="250" autoplay></video>
                                                <canvas v-show="isPhotoTaken" id="photoTaken" ref="canvas" :width="350" :height="250"></canvas>
                                                <input type="file" ref="file_face" class="hidden">
                                            </div>
                                            <div v-if="isCameraOpen && !is_loading" class="w-full justify-center">
                                                <button type="button" class="button" @click="takePhoto">
                                                    <CameraIcon class="w-8 h-8 text-gray-700" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else-if="btn_scan==''" class="w-full h-[250px] flex justify-center">
                                        <div class="absolute top-1/2">
                                            Please check type scan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>