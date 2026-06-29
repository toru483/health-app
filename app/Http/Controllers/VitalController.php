<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vital; // 💡 モデルをインポート

class VitalController extends Controller
{
    public function index()
    {
        return view('vitals.index');
    }

    /**
     * 【追加】体調データの一括保存処理
     */
    public function store(Request $request)
    {
        // 1. バリデーション（入力チェック）
        $validated = $request->validate([
            'weight' => 'nullable|numeric|between:10,200',
            'blood_pressure_high' => 'nullable|integer|between:40,250',
            'blood_pressure_low' => 'nullable|integer|between:30,200',
            'blood_sugar' => 'nullable|integer|between:10,600',
        ]);

        // 2. データベースへ保存
        Vital::create($validated);

        // 3. 服薬ダッシュボードへ戻り、成功メッセージを表示
        return redirect()->route('dashboard')->with('success', '今日の体調データを記録しました！');
    }
}