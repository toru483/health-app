<?php

namespace App\Services;

use Carbon\Carbon;

class HealthLogService
{
    /**
     * 現在時刻に基づいた服用スロットIDを返す
     */
    public function getCurrentSlotId(): int
    {
        $hour = Carbon::now()->hour;

        if ($hour >= 5 && $hour < 11) return 1;  // 朝：5時〜11時
        if ($hour >= 11 && $hour < 16) return 2; // 昼：11時〜16時
        if ($hour >= 16 && $hour < 21) return 3; // 晩：16時〜21時
        return 4;                                // 寝る前：それ以外
    }

    /**
     * スロットIDを日本語名に変換
     */
    public function getSlotName(int $id): string
    {
        return [1 => '朝', 2 => '昼', 3 => '晩', 4 => '寝る前'][$id] ?? '随時';
    }
}