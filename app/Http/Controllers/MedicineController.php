<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription; // ← 追加
use App\Models\Medicine;     // ← 追加

class MedicineController extends Controller
{
    public function create(Request $request)
    {
        $prescription_id = $request->query('prescription_id');

        // 1. IDが渡されていない場合のガード
        if (!$prescription_id) {
            return redirect()->route('hospitals.index')->with('error', '処方箋IDが指定されていません。');
        }

        // 2. データ取得（リレーションを一度に読み込む 'eager loading' で高速化）
        $prescription = \App\Models\Prescription::with(['department.hospital', 'medicines'])
            ->find($prescription_id); // ここでは find を使い、自前でチェック

        // 3. データが存在しない場合のハンドリング
        if (!$prescription) {
            return redirect()->route('hospitals.index')->with('error', '指定された処方箋データが見つかりませんでした。');
        }

        return view('medicines.create', compact('prescription'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'name' => 'required|string|max:255',
            'dosage_amount' => 'required|integer|min:1',
            'dosage_unit' => 'required|string',
            'frequency' => 'required|string|max:255',
        ]);

        \App\Models\Medicine::create($validated);

        // 同じ画面にリダイレクトし、IDを引き継ぐ
        return redirect()->route('medicines.create', ['prescription_id' => $request->prescription_id])
                        ->with('success', 'お薬を追加しました。');
    }
}
