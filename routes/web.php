<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\VitalController;
use Illuminate\Support\Facades\Route;

// 💡 middleware(['auth']) の囲いを外し、フラットな状態に戻します
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/medicine/take', [DashboardController::class, 'takeMedicine'])->name('medicine.take');

// 体調管理（バイタル）
Route::get('/vitals', [VitalController::class, 'index'])->name('vitals.index');
Route::post('/vitals', [VitalController::class, 'store'])->name('vitals.store');

// 病院管理ルート（すでにある resources に show を含める、または個別定義）
Route::resource('hospitals', HospitalController::class);

// 受診科登録用のルート
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');

// 病院・受診科・処方箋
Route::resource('hospitals', HospitalController::class);
Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
Route::post('prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
Route::get('medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
Route::post('medicines', [MedicineController::class, 'store'])->name('medicines.store');