<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicineController extends Controller
{
    /**
     * お薬登録画面の表示
     * 💡 どの「処方箋」にお薬を追加するのか、文脈（親ID）を確実に引き継ぐ
     */
    public function create(Request $request): View
    {
        // 1. クエリパラメータから親の prescription_id を取得
        $prescriptionId = $request->query('prescription_id');

        // 2. 親データが存在するか、N+1問題を回避しつつ関連する診療科・病院まで一括ロード（Eager Loading）
        // 💡 ガード節による異常系の早期排除
        if (!$prescriptionId) {
            abort(400, '処方箋IDが指定されていません。');
        }

        $prescription = Prescription::with(['department.hospital'])->findOrFail($prescriptionId);

        return view('medicines.create', compact('prescription'));
    }

    /**
     * お薬データの堅牢なバリデーション＆保存処理
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. 実务レベルの厳格なバリデーション
        // 💡 Boolean型（チェックボックス）の入力値は、存在しない場合に false に丸める前処理（ハッキング・不正値対策）
        $validated = $request->validate([
            'prescription_id'     => ['required', 'exists:prescriptions,id'],
            'name'                => ['required', 'string', 'max:255'],
            'dosage'              => ['required', 'string', 'max:100'],
            'timing_morning'      => ['nullable', 'boolean'],
            'timing_noon'         => ['nullable', 'boolean'],
            'timing_night'        => ['nullable', 'boolean'],
            'timing_before_sleep' => ['nullable', 'boolean'],
            'notes'               => ['nullable', 'string', 'max:1000'],
        ]);

        // 2. チェックボックスの未選択（リクエストに含まれない）に対応するためのデータ整形
        $data = array_merge($validated, [
            'timing_morning'      => $request->has('timing_morning'),
            'timing_noon'         => $request->has('timing_noon'),
            'timing_night'        => $request->has('timing_night'),
            'timing_before_sleep' => $request->has('timing_before_sleep'),
        ]);

        // 3. 安全な一括代入（Mass Assignment）の実行
        Medicine::create($data);

        // 4. UX（ユーザー体験）の最適化：登録完了後は、親である「処方箋が紐づく受診科の詳細画面」等へスマートに戻す
        return redirect()
            ->route('departments.show', $request->input('department_id'))
            ->with('success', 'お薬（' . $data['name'] . '）を正常に登録しました。');
    }
}