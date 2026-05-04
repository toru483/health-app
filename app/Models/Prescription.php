<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    // 保存（一括割り当て）を許可するカラムを定義
    protected $fillable = [
        'department_id',
        'prescribed_date',
        'next_visit_date',
    ];

    /**
     * リレーション定義：処方箋は一つの受診科に属する
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * リレーション定義：処方箋は複数の薬を持つ
     */
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
