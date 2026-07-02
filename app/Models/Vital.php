<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;

    // 💡 user_id も一括保存できるように追加します
    protected $fillable = [
        'user_id', 
        'weight',
        'blood_pressure_high',
        'blood_pressure_low',
        'blood_sugar',
    ];

    /**
     * リレーション定義：バイタルデータは一人のユーザーに属する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}