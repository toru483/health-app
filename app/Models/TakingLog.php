<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TakingLog extends Model
{
    protected $fillable = [
        'medicine_id',
        'taken_at',
        'time_slot',
    ];

    // どの薬のログか
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('taken_at', now()->toDateString());
    }
}
