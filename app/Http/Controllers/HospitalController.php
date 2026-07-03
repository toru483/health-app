<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = \App\Models\Hospital::all();
        return view('hospitals.index', compact('hospitals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hospitals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. バリデーション
        $validated = $request->validate([
            'name' => 'required|max:255',
            'tel' => 'nullable|max:20',
            'address' => 'nullable|max:500',
        ]);

        // 2. データの保存
        Hospital::create($validated);

        // 3. 一覧画面へリダイレクト（成功メッセージ付き）
        return redirect()->route('hospitals.index')->with('success', '病院を登録しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hospital $hospital)
    {
        // 💡 プロの技術：N+1問題を回避するため、紐づく受診科（departments）を先行読み込み
        $hospital->load('departments');

        // resources/views/hospitals/show.blade.php を呼び出す
        return view('hospitals.show', compact('hospital'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
