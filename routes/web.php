<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\VitalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. メインダッシュボード & 服用アクション
// ==========================================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/medicine/take', [DashboardController::class, 'takeMedicine'])->name('medicine.take');

// ==========================================
// 2. 体調管理（バイタルログ）
// ==========================================
Route::prefix('vitals')->name('vitals.')->group(function () {
    Route::get('/', [VitalController::class, 'index'])->name('index');
    Route::post('/', [VitalController::class, 'store'])->name('store');
});

// ==========================================
// 3. 医療機関・受診科・処方箋・お薬（ドリルダウン構造）
// ==========================================

// 第1階層: 病院管理（CRUD全般をカバー）
Route::resource('hospitals', HospitalController::class);

// 第2階層: 受診科（ストアと詳細表示に限定）
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

// 第3階層: 処方箋（登録画面表示と保存に限定）
Route::resource('prescriptions', PrescriptionController::class)->only(['create', 'store']);

// 第4階層: お薬（登録画面表示と保存に限定）
Route::resource('medicines', MedicineController::class)->only(['create', 'store']);