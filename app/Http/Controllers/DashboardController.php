<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\UniformMaster;
use App\Models\UniformIssue;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Employee counts
        $activeEmployees = Employee::where('status', 'active')->count();
        $inactiveEmployees = Employee::where('status', 'inactive')->count();

        // Uniform counts
        $uniformCount = UniformMaster::count();

        // Uniform issued records
        $issuedRecords = UniformIssue::with(['employee', 'items.master'])
            ->latest()
            ->take(10) // recent 10 records
            ->get();

        return view('dashboard', compact(
            'activeEmployees',
            'inactiveEmployees',
            'uniformCount',
            'issuedRecords'
        ));
    }
}
