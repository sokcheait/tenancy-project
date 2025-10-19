<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Alert, Button,Dialog, DropdownMenu, DropdownOption } from '@flavorly/vanilla-components';
import { Head, Link,useForm } from '@inertiajs/vue3';
import { HomeIcon,ChevronRightIcon,UserIcon, TrashIcon,PencilSquareIcon,ClipboardDocumentCheckIcon,
    EyeIcon,EllipsisVerticalIcon,Cog8ToothIcon,CheckIcon,QrCodeIcon ,
    ViewfinderCircleIcon,XMarkIcon,ArrowDownTrayIcon,PhotoIcon,CameraIcon} from '@heroicons/vue/24/solid'
import Swal from 'vue-sweetalert2';
import { useToast } from "vue-toastification";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import moment from 'moment';

export default {
    components: {
        AppLayout,
        Head,
        Link,
        Alert, 
        Button,
        useForm,
        HomeIcon,
        ChevronRightIcon,
        EllipsisVerticalIcon,
        Cog8ToothIcon,
        UserIcon,
        TrashIcon,
        PencilSquareIcon,
        EyeIcon,
        Table,
        DropdownLink,
        Dropdown,
        Dialog,
        CheckIcon,
        QrCodeIcon,
        ViewfinderCircleIcon,
        XMarkIcon,
        PhotoIcon,
        CameraIcon,
        DropdownMenu, DropdownOption,
        ClipboardDocumentCheckIcon,ArrowDownTrayIcon
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
                attendance_date:'',
                employee_id:null,
            }),
            formUpload:useForm({
                face_employee:null,
                emp_id:null
            }),
            open_model_attendance:false,
            open_model_upload_face:false,
            file_employee:null,
            shift:4,
            count_nember_work:null,
            count_check:null,
            selectedFile:null,
            imageUrl: null
        }
    },
    methods: {
        deleteEmployee(userId) {
            this.$swal.fire(({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon:"warning",
                showCancelButton: true,
                buttonsStyling: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Yes, Delete it!"
            })).then((result) => { 
                if (result.value) { 
                    this.$inertia.delete(route('employee.destroy',userId),{
                        preserveScroll: true,
                        onSuccess: () => {
                            this.toast.success("Your post has been deleted!", {
                                
                            });
                        },
                    })
                }
            });
        },
        showUser(id) {
            this.$inertia.get(route('employee.show',id),{
                preserveScroll: true,
                onSuccess: () => {
                    
                },
            })
        },
        // attendance(employee){
        //     this.open_model_attendance=true;
        //     this.file_employee = employee;
        //     const attendance = employee?.attendances;
        //     let count_check =[];
        //     let today = moment(new Date()).format("YYYY-MM-DD");
        //     _.forEach(attendance,function(item) {
        //         if(item.time_check_in !="" && item.attendance_date.valueOf() == today.valueOf()){
        //             count_check.push(item.time_check_in);
        //         }
        //         if(item.time_check_out !="" && item.attendance_date.valueOf() == today.valueOf()){
        //             count_check.push(item.time_check_out);
        //         }
        //     });
        //     this.count_nember_work = count_check;

        //     // this.count_check = this.shift - this.count_nember_work.length;
        // },
        uploadFace(employee) {
            this.open_model_upload_face = true;
            this.formUpload.emp_id=employee.id;
            if(employee.face_employee){
                this.imageUrl = employee.face_employee
            }
        },
        closePopUpload(){
            this.open_model_upload_face = false;
            this.imageUrl=null;
            this.selectedFile =null;
            this.formUpload.emp_id=null;
            this.formUpload.face_employee=null;
        },
        storeFace() {
            this.formUpload.face_employee = this.selectedFile;
            this.formUpload.post(route('upload-face'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.open_model_attendance=false;
                    this.toast.success("Upload face successfully");
                },
                onError: () => {
                    this.toast.error("Upload face Errors", {
                    });
                },
            });
        },
        handleFileUpload(event) {
            this.selectedFile = event.target.files[0];
            console.log(this.selectedFile)
            this.imageUrl = URL.createObjectURL(this.selectedFile);
        },
        // storeAttendance(){
        //     this.form.attendance_date = new Date();
        //     this.form.employee_id = this.file_employee.id;
        //     this.form.post(route('attendance.store'), {
        //         preserveScroll: true,
        //         onSuccess: () => {
        //             this.open_model_attendance=false;
        //             this.toast.success("Create attendance successfully");
        //         },
        //         onError: () => {
        //             this.toast.error("Create attendance Errors", {
        //             });
        //         },
        //     });
        // },
        close(){
            this.open_model_attendance=false;
        },
    }

}

</script>

<template>
    <AppLayout title="Employee">
        <div class="w-full p-4">
            <div class="bg-blue-500 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div class="flex justify-center items-center w-4 h-4 transition-all duration-300 transform px-4">
                    <span class="ml-16"><HomeIcon class="h-6 w-6 text-gray-200 dark:text-white" /></span>
                    <span class="ml-3 mt-1">
                        <Link :href="route('employee.index')" class="text-gray-200 dark:text-white">
                            Employee
                        </Link>
                    </span>
                </div>
                <div class="text-right">
                    <Link  v-if="can('employee.create') || is_superAdmin('super-admin')" :href="route('employee.create')" class="text-gray-200 dark:text-white">
                        <Button
                            label="Create Employee"
                            variant="primary"
                        />
                    </Link>
                </div>
            </div>
            <div class="dark:bg-gray-800 shadow-lg rounded-md p-2 dark:border-gray-600 font-medium">    
                <Table :resource="employees">
                    <template #cell(first_name)="{ item: employee }">
                        <div class="flex flex-warp">
                            <span class="mt-4">{{ employee.first_name }}</span>
                            <span v-if="employee?.face_employee !=''" class="mx-2"><img :src="employee?.face_employee" class="w-12 h-12 rounded-full" /></span>
                            <span v-else class="mx-2">
                                <PhotoIcon
                                        class="w-12 h-12"
                                        aria-hidden="true"
                                    />
                            </span>
                        </div>
                    </template>
                    <template #cell(positions)="{ item: employee }">
                        <span>{{ employee.positions['0'].name }}</span>
                    </template>
                    <template #cell(position_shifts)="{ item: employee }">
                        <span>{{ employee.positions['0']?.shifts[0]?.name }}</span>
                    </template>
                    <template #cell(actions)="{ item: employee }">
                        <div class="flex mx-auto space-y-3 ">
                            <DropdownMenu
                            text=""
                            >
                                <div class="block px-4 py-2 text-xs text-gray-400 flex flex-col items-center justify-center border-b-2">
                                    Manage Actions
                                </div>
                                <DropdownOption>
                                    <div v-if="can('employee.edit') || is_superAdmin('super-admin')" class="flex w-full">
                                        <Link class="w-full" :href="route('employee.edit',employee.id)">
                                            <span class="w-[23px] float-left mt-[2px]"><PencilSquareIcon class="text-blue-500 w-4 h-4"/></span>
                                            <span class="text-blue-500">Edit</span>
                                        </Link>
                                    </div>
                                </DropdownOption>
                                <DropdownOption>
                                    <div v-if="can('employee.edit') || is_superAdmin('super-admin')" class="flex w-full" @click="deleteEmployee(employee.id)">
                                        <Link class="w-full" href="">
                                            <span class="w-[23px] float-left mt-[2px]"><TrashIcon class="text-rose-500 w-4 h-4"/></span>
                                            <span class="text-rose-500">Delete</span>
                                        </Link>
                                    </div>
                                </DropdownOption>
                                <DropdownOption>
                                    <div v-if="can('employee.edit') || is_superAdmin('super-admin')" class="flex w-full" @click="uploadFace(employee)">
                                            <span class="w-[23px] float-left mt-[2px]"><ArrowDownTrayIcon class="text-green-500 w-4 h-4"/></span>
                                            <span class="text-green-500">Upload Face</span>
                                    </div>
                                </DropdownOption>
                            </DropdownMenu>
                        </div>
                    </template>
                </Table>
            </div>
            <Dialog v-model="open_model_attendance"
            :closeable="false"
            >
                <div>
                    <div class="flex flex-wrap justify-center border border-gray-300 p-2 rounded-lg mb-2">
                        <div class="px-2">
                            <input class="peer sr-only" type="radio" value="checkedAttendance" name="answer" id="checkedAttendance" checked />
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
                            <input class="peer sr-only" type="radio" value="faceAttendance" name="answer" id="faceAttendance" />
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
                            <input class="peer sr-only" type="radio" value="qrAttendance" name="answer" id="qrAttendance" />
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
                    <div class='flex justify-center'>
                        <ul class="mx-auto grid max-w-full w-full grid-cols-3 gap-x-5 px-6 border border-gray-300 p-2 rounded-lg">
                            <div class="space-y-6 border-l-2 border-dashed border-cyan-400">
                                <div v-for="item in count_nember_work" :key="item" class="relative w-full">
                                    <div class="flex absolute top-0.5 z-10 -ml-3.5 h-7 w-7 rounded-full bg-green-100 justify-center items-center border border-green-400">
                                        <CheckIcon
                                            class="h-4 w-4 text-green-600"
                                            aria-hidden="true"
                                        />
                                    </div>
                                    <div class="ml-6">
                                        <h4 class="font-bold text-blue-500">Frontend Development.</h4>
                                        <p class="mt-2 max-w-screen-sm text-sm text-gray-500">Maecenas </p>
                                        <span class="mt-1 block text-sm font-semibold text-blue-500">2007</span>
                                    </div>
                                </div>
                                <div>
                                    <div v-for="item in count_check" :key="item" class="relative w-full">
                                        <div class="flex absolute top-0.5 z-10 -ml-3.5 h-7 w-7 rounded-full bg-rose-200 justify-center items-center">
                                            <XMarkIcon
                                                class="h-4 w-4 text-rose-600"
                                                aria-hidden="true"
                                            />
                                        </div>
                                        
                                        <div class="ml-6">
                                            <h4 class="font-bold text-blue-500">Frontend Development.</h4>
                                            <p class="mt-2 max-w-screen-sm text-sm text-gray-500">Maecenas </p>
                                            <span class="mt-1 block text-sm font-semibold text-blue-500">2007</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <Button
                            type="button"
                            class="w-full"
                            variant="success"
                            @click="storeAttendance"
                            >
                            Check
                        </Button>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <Button
                            type="button"
                            class="w-full"
                            variant="error"
                            @click="close"
                            >
                            Close
                        </Button>
                    </div>
                </div>
            </Dialog>

            <Dialog v-model="open_model_upload_face"
            :closeable="false"
            >
                <div>
                    <div class="flex flex-wrap border-b border-gray-500 mb-2">
                        <div class="pb-2">
                            <h1 class="text-xl">Upload Face</h1>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center border border-gray-300 p-2 rounded-lg mb-2">
                        <div class="px-2">
                            <input class="peer sr-only" type="radio" value="checkedAttendance" name="answer" id="checkedAttendance" checked />
                            <label class="flex justify-center items-center cursor-pointer rounded-full border border-gray-300 bg-white h-12 w-12 
                                hover:bg-gray-50 focus:outline-none peer-checked:border-transparent peer-checked:ring-2 
                                peer-checked:bg-green-200 transition-all duration-500 ease-in-out" for="checkedAttendance">
                                <PhotoIcon
                                        class="h-6 w-6 text-green-600"
                                        aria-hidden="true"
                                    />
                            </label>
                        </div>
                        <div class="px-2">
                            <input class="peer sr-only" type="radio" value="faceAttendance" name="answer" id="faceAttendance" />
                                <label class="flex justify-center items-center cursor-pointer rounded-full border border-gray-300 
                                bg-white h-12 w-12 hover:bg-gray-50 focus:outline-none peer-checked:border-transparent 
                                peer-checked:ring-2 peer-checked:bg-teal-200 transition-all duration-500 ease-in-out" for="faceAttendance">
                                    <CameraIcon
                                        class="h-6 w-6 text-teal-700"
                                        aria-hidden="true"
                                    />
                                </label>
                        </div>
                    </div>
                    <div class="w-full h-[180px] flex flex-wrap justify-center block border border-gray-300 p-2 rounded-lg mb-2">
                        <label class="w-full h-full relative">
                            <input class="w-full h-full absolute cursor-pointer block opacity-0" type="file" @change="handleFileUpload" />
                            <div v-if="imageUrl==null" class="w-full h-full absolute bg-gray-100">
                                <ArrowDownTrayIcon class="text-gray-500 w-8 h-8 absolute top-[40%] left-[45%]"/>
                            </div>
                            <div v-else-if="imageUrl !=null" class="w-full h-full absolute">
                                <img :src="imageUrl" class="object-contain w-full h-full" />
                            </div>
                        </label>
                    </div>

                    <div class="flex flex-wrap w-full">
                        <div class="mt-5 px-1 sm:mt-6">
                            <Button
                                type="button"
                                class="w-full"
                                variant="success"
                                @click="storeFace"
                                >
                                Save
                            </Button>
                        </div>
                        <div class="mt-5 px-1 sm:mt-6">
                            <Button
                                type="button"
                                class="w-full"
                                variant="error"
                                @click="closePopUpload"
                                >
                                Close
                            </Button>
                        </div>
                    </div>
                </div>
            </Dialog>
        </div>
    </AppLayout>
</template>