<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function create(Request $request)
    {
        $department_id = $request->query('department_id');
        $department = \App\Models\Department::with('hospital')->findOrFail($department_id);

        return view('prescriptions.create', compact('department'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'prescribed_date' => 'required|date',
            'next_visit_date' => 'nullable|date|after_or_equal:prescribed_date',
        ]);

        // 保存
        $prescription = \App\Models\Prescription::create($validated);

        // 保存後、この処方箋に紐づく「薬の登録画面」へ移動する
        return redirect()->route('medicines.create', ['prescription_id' => $prescription->id])
                        ->with('success', '処方箋を登録しました。続けてお薬を登録してください。');
    }
}
