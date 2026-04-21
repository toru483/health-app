<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'name' => 'required|max:255',
        ]);

        \App\Models\Department::create($validated);

        return redirect()->back()->with('success', '受診科を追加しました！');
    }
}
