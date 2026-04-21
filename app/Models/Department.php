<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['hospital_id', 'name'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
