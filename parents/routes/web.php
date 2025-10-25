<?php

use App\Http\Controllers\PositionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RolesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// use App\Http\Controllers\Api\V1\SupplierController;
// use App\Http\Controllers\Api\V1\ItemController;
// use App\Http\Controllers\Api\V1\PurchaseOrderController;
// use App\Http\Controllers\Api\V1\ReceiveController;
// use App\Http\Controllers\Api\V1\BackOrderController;
// use App\Http\Controllers\Api\V1\ReturnedController;
// use App\Http\Controllers\Api\V1\StockController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ShiftController;
use App\Models\Attendance;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('/users',UsersController::class);
    Route::get('/users/face/user',[UsersController::class,'faceUser'])->name('users.face.user');
    Route::resource('/position',PositionController::class);
    Route::resource('/employee',EmployeeController::class);
    Route::post('/upload-face',[EmployeeController::class,'uploadFace'])->name('upload-face');
    Route::resource('/attendance',AttendanceController::class);
    Route::get('/scan_attendance',[AttendanceController::class,'scanAttendance'])->name('scan_attendance');
    Route::get('/call-employee-qr/{id}',[AttendanceController::class,'callEmployeeQR'])->name('call-employee-qr');
    Route::post('/scan-attendance-face',[AttendanceController::class,'scanAttendanceFace'])->name('scan-attendance-face');
    Route::get('/attendance/export/excel',[AttendanceController::class,'attendanceExcel'])->name('attendance.export.excel');
    Route::resource('/roles', RolesController::class);
    Route::resource('/shift', ShiftController::class);
    Route::post('/shift/connect-shift',[ShiftController::class,'connectShift'])->name('shift.connect-shift');
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
    Route::put('/laravel-language/{key}', function ($key) {
        session()->put('locale', $key);
        return redirect()->back();
    });
});
