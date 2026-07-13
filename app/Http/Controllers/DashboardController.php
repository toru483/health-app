<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\TakingLog;
use App\Services\HealthLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * ダッシュボード表示（お薬手帳メインタイムライン）
     */
    public function index(HealthLogService $service): View
    {
        $currentSlotId = $service->getCurrentSlotId();
        $slotName = $service->getSlotName($currentSlotId);
        
        // 1. 処方箋データの一括取得（N+1問題を回避し、リレーション先を統合ロード）
        $prescriptions = Prescription::with([
            'department.hospital', 
            'medicines.takingLogs' => function($query) {
                $query->today(); // 既存のスコープを利用してSQLレベルで当日に絞り込む
            }
        ])->get();

        // 2. 本日の服用履歴を最新順に取得
        $todayLogs = TakingLog::with('medicine')
            ->whereDate('taken_at', now()->toDateString())
            ->orderBy('taken_at', 'desc')
            ->get();

        // 3. 【プロ仕様】タイムライン表示用に、時間帯ごとの「今日飲むべきお薬」を事前にグルーピング
        // 💡 物理インデックスを活用した爆速クエリを背後で支える構造
        $timeline = [
            'morning'      => Medicine::where('timing_morning', true)->with('prescription.department.hospital')->get(),
            'noon'         => Medicine::where('timing_noon', true)->with('prescription.department.hospital')->get(),
            'night'        => Medicine::where('timing_night', true)->with('prescription.department.hospital')->get(),
            'before_sleep' => Medicine::where('timing_before_sleep', true)->with('prescription.department.hospital')->get(),
        ];

        return view('dashboard', compact(
            'prescriptions', 
            'currentSlotId', 
            'slotName', 
            'todayLogs',
            'timeline'
        ));
    }
    
    /**
     * 服用チェック処理（「飲んだ！」ボタンの実行）
     */
    public function takeMedicine(Request $request): RedirectResponse
    {
        // 1. 厳格なバリデーション
        $validated = $request->validate([
            'medicine_id' => ['required', 'exists:medicines,id'],
        ]);

        // 2. 服用ログを安全に記録
        TakingLog::create([
            'medicine_id' => $validated['medicine_id'],
            'taken_at'    => now(), 
            'time_slot'   => $this->getCurrentTimeSlot(), // 一元管理された時間帯判定
        ]);

        return back()->with('success', '服用を正常に記録しました！');
    }

    /**
     * 現在時刻から時間帯（DBのカラムプレフィックスに準拠）を判定する
     * 💡 将来的にデータベースの値や多言語化に対応できるよう、英名キーを返却
     */
    private function getCurrentTimeSlot(): string
    {
        $hour = now()->hour;

        if ($hour >= 4 && $hour < 11) {
            return 'morning';
        }
        if ($hour >= 11 && $hour < 16) {
            return 'noon';
        }
        if ($hour >= 16 && $hour < 21) {
            return 'night';
        }
        
        return 'before_sleep';
    }
}