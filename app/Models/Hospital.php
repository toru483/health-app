<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = ['name', 'tel', 'address'];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
