<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function create(Request $request)
    {
        $department_id = $request->query('department_id');
        $department = \App\Models\Department::with('hospital')->findOrFail($department_id);

        return view('prescriptions.create', compact('department'));
    }
}
