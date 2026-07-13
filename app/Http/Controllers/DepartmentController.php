<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * 特定の病院に新しい受診科（診療科）を追加する
     */
    public function store(Request $request)
    {
        // 1. バリデーション
        $validated = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'name'        => 'required|string|max:100', // 例：内科、皮膚科など
        ]);

        // 2. データの保存
        Department::create($validated);

        // 3. 元の病院詳細画面にリダイレクトして、成功メッセージを表示
        return redirect()->route('hospitals.show', $request->hospital_id)
                        ->with('success', "受診科「{$request->name}」を登録しました！✨");
    }

    public function show(Department $department)
    {
        // 💡 プロの技術：受診科に紐づく「処方箋（prescriptions）」と、その親である「病院（hospital）」を先行読み込み
        $department->load(['hospital', 'prescriptions']);

        return view('departments.show', compact('department'));
    }
}