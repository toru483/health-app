<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vital;
use Illuminate\Http\Request;

class VitalController extends Controller
{
    public function index()
    {
        // 💡 Auth::id() の代わりに、仮で固定の「1」を指定して取得します
        $vitals = Vital::where('user_id', 1)
            ->latest()
            ->take(10)
            ->get();

        $avgWeight = $vitals->avg('weight');
        $avgBpHigh = $vitals->avg('blood_pressure_high');
        $avgBpLow  = $vitals->avg('blood_pressure_low');
        $avgSugar  = $vitals->avg('blood_sugar');

        return view('vitals.index', compact('vitals', 'avgWeight', 'avgBpHigh', 'avgBpLow', 'avgSugar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'weight' => 'nullable|numeric|between:10,200',
            'blood_pressure_high' => 'nullable|integer|between:40,250',
            'blood_pressure_low' => 'nullable|integer|between:30,200',
            'blood_sugar' => 'nullable|integer|between:10,600',
        ]);

        // 💡 ログインしていない状態なので、常にユーザーID「1」として保存します
        $validated['user_id'] = 1;

        Vital::create($validated);

        return redirect()->route('vitals.index')->with('success', '今日の体調データを記録しました！');
    }
}