<?php

namespace App\Http\Controllers;

use App\Models\MeasurementLog; // 上部に追加
use Illuminate\Http\Request;

class HealthLogController extends Controller
{
    public function index()
    {
        // dashboard.blade.php を表示する
        return view('dashboard');
    }

        // classの中に以下を追記
    public function createMeasurement()
    {
        return view('measurements.create');
    }

    public function storeMeasurement(Request $request)
    {
        // バリデーション（入力チェック）
        $validated = $request->validate([
            'type' => 'required|string',
            'value_1' => 'required|numeric',
            'value_2' => 'nullable|numeric',
            'measured_at' => 'required|date',
        ]);

        // データベースに保存
        MeasurementLog::create($validated);

        // 一覧画面に戻る
        return redirect()->route('dashboard')->with('success', '記録を保存しました！');
    }
}