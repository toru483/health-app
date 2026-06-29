<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HealthLogController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\VitalController;
use Illuminate\Support\Facades\Route;

// 一覧画面を表示するルート
    // 修正前
    // Route::get('/dashboard', [HealthLogController::class, 'index'])->name('dashboard');
    // 修正後
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 登録フォームを表示する画面
Route::get('/measurements/create', [HealthLogController::class, 'createMeasurement'])->name('measurements.create');

// データを保存する処理
Route::post('/measurements', [HealthLogController::class, 'storeMeasurement'])->name('measurements.store');

// 病院管理用のルートを追加
Route::resource('hospitals', HospitalController::class);

// 受診科保存用のルーティング
Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');

// 受診科リストにボタンを追加
Route::get('prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
Route::post('prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');

// 薬（Medicine）登録機能の構築
Route::get('medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
Route::post('medicines', [MedicineController::class, 'store'])->name('medicines.store');

Route::post('/medicine/take', [DashboardController::class, 'takeMedicine'])->name('medicine.take');

// 体調管理（バイタル）一括登録画面のルート
Route::get('/vitals', [VitalController::class, 'index'])->name('vitals.index');
// ↓ これを追加
Route::post('/vitals', [VitalController::class, 'store'])->name('vitals.store');