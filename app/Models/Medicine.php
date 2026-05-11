<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'hospital_name',
        'department_name',
        'notes'
    ];

    /**
     * 服用履歴とのリレーション
     */
    public function takingLogs(): HasMany
    {
        return $this->hasMany(TakingLog::class);
    }

    /**
     * 今日すでに服用したかを確認
     */
    public function isTakenToday(): bool
    {
        return $this->takingLogs()->today()->exists();
    }
}
