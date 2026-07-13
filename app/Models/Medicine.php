<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    // マスアサインメント可能なカラムの指定（必要に応じて調整してください）
    protected $fillable = [
        'prescription_id',
        'name',
        'dosage',
        'timing_morning',
        'timing_noon',
        'timing_night',
        'timing_before_sleep',
        'notes',
    ];

    /**
     * 処方箋（Prescription）とのリレーション（多対1）
     */
    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class);
    }

    /**
     * 【重要】服薬ログ（TakingLog）とのリレーション（1対多）
     * 💡 コントローラーで指定されている「takingLogs」と名前を完全に一致させます
     */
    public function takingLogs(): HasMany
    {
        return $this->hasMany(TakingLog::class);
    }
}