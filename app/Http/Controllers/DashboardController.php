<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 全ての処方箋を、新しい順に取得（紐づく病院、科、薬も一緒に）
        $prescriptions = \App\Models\Prescription::with(['department.hospital', 'medicines'])
            ->orderBy('prescribed_date', 'desc')
            ->get();

        return view('dashboard', compact('prescriptions'));
    }
}
