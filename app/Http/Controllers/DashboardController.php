<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TakingLog;
use App\Models\Prescription; // ← 追加：バックスラッシュを消すため
// ↓ ここを追加！
use App\Services\HealthLogService;

class DashboardController extends Controller
{
    /**
     * ダッシュボード表示（お薬手帳メイン画面）
     */
    public function index(HealthLogService $service)
    {
        $currentSlotId = $service->getCurrentSlotId();
        $slotName = $service->getSlotName($currentSlotId);
        
        // 1. 服用中のお薬（N+1問題対策済み）
        $prescriptions = Prescription::with(['department.hospital', 'medicines.takingLogs'])->get();

        // 2. 【追加】本日の服用履歴を最新順に取得
        $todayLogs = TakingLog::with('medicine')
            ->whereDate('taken_at', now()->toDateString())
            ->orderBy('taken_at', 'desc')
            ->get();

        // viewに $todayLogs を追加して渡す
        return view('dashboard', compact('prescriptions', 'currentSlotId', 'slotName', 'todayLogs'));
    }
    
    /**
     * 服用チェック処理（「飲んだ！」ボタンの実行）
     */
    public function takeMedicine(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
        ]);

        // 服用ログを記録
        TakingLog::create([
            'medicine_id' => $request->medicine_id,
            'taken_at'    => now(), // 今日の日付(時分秒も含めて)
            'time_slot'   => $this->getCurrentTimeSlot(), // 現在の時刻から判定
        ]);

        return back()->with('success', '服用を記録しました！');
    }

    /**
     * 現在時刻から時間帯（朝・昼・晩など）を判定する
     */
    private function getCurrentTimeSlot()
    {
        $hour = now()->hour;
        if ($hour >= 4 && $hour < 11) return '朝';
        if ($hour >= 11 && $hour < 16) return '昼';
        if ($hour >= 16 && $hour < 21) return '晩';
        return '寝る前';
    }
}
