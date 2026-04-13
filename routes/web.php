<?php

use App\Http\Controllers\HealthLogController;
use Illuminate\Support\Facades\Route;

// 一覧画面を表示するルート
Route::get('/dashboard', [HealthLogController::class, 'index'])->name('dashboard');

// 登録フォームを表示する画面
Route::get('/measurements/create', [HealthLogController::class, 'createMeasurement'])->name('measurements.create');

// データを保存する処理
Route::post('/measurements', [HealthLogController::class, 'storeMeasurement'])->name('measurements.store');