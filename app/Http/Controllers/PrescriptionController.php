<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PrescriptionController extends Controller
{
    /**
     * 処方箋登録画面の表示
     */
    public function create(Request $request): View
    {
        $department_id = $request->query('department_id');
        $department = Department::with('hospital')->findOrFail($department_id);

        return view('prescriptions.create', compact('department'));
    }

    /**
     * 特定の受診科に紐づく処方箋データを新規登録する
     */
    public function store(Request $request): RedirectResponse
    {
        // 💡 堅牢なバリデーションへのアップグレード
        $validated = $request->validate([
            'department_id'   => 'required|exists:departments,id',
            // 未来の日付での処方箋発行を防止
            'prescribed_date' => 'required|date|before_or_equal:today', 
            // 次回受診日は、処方日と同日かそれ以降である必要があるという高度な相関チェック
            'next_visit_date' => 'nullable|date|after_or_equal:prescribed_date',
            'doctor_name'     => 'nullable|string|max:100',
        ]);

        // データの保存
        Prescription::create($validated);

        return redirect()->route('departments.show', $request->department_id)
                        ->with('success', '新しい処方箋データを登録しました！📄');
    }
}