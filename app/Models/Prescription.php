<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    use HasFactory;

    // 💡 漏れなくすべての保存可能カラムを定義
    protected $fillable = [
        'department_id',
        'prescribed_date', // 処方日（clinic_dateから統一）
        'next_visit_date', // 次回受診予定日
        'doctor_name',     // 担当医師名
    ];

    /**
     * リレーション定義：処方箋は一つの受診科に属する
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * リレーション定義：処方箋は複数の薬を持つ
     */
    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class);
    }
}