<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Medicine;

class MedicineController extends Controller
{
    public function create(Request $request)
    {
        $prescription_id = $request->query('prescription_id');

        // 1. ガード節：ID未指定時は一覧へ
        if (!$prescription_id) {
            return redirect()->route('hospitals.index')->with('error', '処方箋IDが指定されていません。');
        }

        // 2. Eager Loadingによる高効率なデータ取得
        $prescription = Prescription::with(['department.hospital', 'medicines'])->find($prescription_id);

        // 3. データ不在時のハンドリング
        if (!$prescription) {
            return redirect()->route('hospitals.index')->with('error', '指定された処方箋データが見つかりませんでした。');
        }

        return view('medicines.create', compact('prescription'));
    }

    public function store(Request $request)
    {
        // 💡 time_slots を配列またはカンマ区切りで受ける想定へ拡張可能に
        $validated = $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'name' => 'required|string|max:255',
            'dosage_amount' => 'required|integer|min:1',
            'dosage_unit' => 'required|string|max:50',
            'time_slots' => 'required|string', // '1,2,3' (朝昼晩) のような形
        ]);

        Medicine::create($validated);

        return redirect()->route('medicines.create', ['prescription_id' => $request->prescription_id])
                        ->with('success', 'お薬を追加しました！✨');
    }
}