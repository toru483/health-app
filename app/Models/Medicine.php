<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    // 保存を許可するカラムを指定
    protected $fillable = [
        'prescription_id',
        'name',
        'dosage_amount',
        'dosage_unit',
        'frequency',
        'notes'
    ];
}
