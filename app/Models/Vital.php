<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;

    // 💡 一括保存を許可するカラムを指定します
    protected $fillable = [
        'weight',
        'blood_pressure_high',
        'blood_pressure_low',
        'blood_sugar',
    ];
}
