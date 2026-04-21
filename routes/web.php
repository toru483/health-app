<?php

use App\Http\Controllers\HealthLogController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PrescriptionController;
use Illuminate\Support\Facades\Route;

// 一覧画面を表示するルート
Route::get('/dashboard', [HealthLogController::class, 'index'])->name('dashboard');

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