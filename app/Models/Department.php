<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // 💡 これを追加

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['hospital_id', 'name'];

    /**
     * 所属する病院とのリレーション (多対1)
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * 🌟 追加：この受診科に紐づく処方箋群とのリレーション (1対多)
     * 
     * 1つの受診科（例: 血液内科）は、過去から現在にかけて複数の処方箋（履歴）を持ちます。
     */
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }
}