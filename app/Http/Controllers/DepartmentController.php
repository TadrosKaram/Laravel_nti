<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = DB::table('departments')->get();
        
        // Get department doctors
        $departmentDoctors = DB::table('doctor_department')
            ->join('doctors', 'doctor_department.doctor_id', '=', 'doctors.id')
            ->select('doctor_department.department_id', 'doctors.name as doctor_name', 'doctors.id as doctor_id')
            ->get()
            ->groupBy('department_id');
            
        // Get department employees
        $departmentEmployees = DB::table('employee_department')
            ->join('employees', 'employee_department.employee_id', '=', 'employees.id')
            ->select('employee_department.department_id', 'employees.name as employee_name', 'employees.id as employee_id')
            ->get()
            ->groupBy('department_id');
            
        return view('departments.index', compact('departments', 'departmentDoctors', 'departmentEmployees'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
        ]);

        DB::table('departments')->insert([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit($id)
    {
        $department = DB::table('departments')->where('id', $id)->first();
        
        if (!$department) {
            return redirect()->route('departments.index')->with('error', 'Department not found.');
        }
        
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code,' . $id,
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
        ]);

        $updated = DB::table('departments')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'description' => $request->input('description'),
                'location' => $request->input('location'),
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
        }
        
        return redirect()->route('departments.index')->with('error', 'Department not found.');
    }

    public function destroy($id)
    {
        // Delete department assignments first
        DB::table('doctor_department')->where('department_id', $id)->delete();
        DB::table('employee_department')->where('department_id', $id)->delete();
        
        // Delete department
        $deleted = DB::table('departments')->where('id', $id)->delete();
        
        if ($deleted) {
            return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
        }
        
        return redirect()->route('departments.index')->with('error', 'Department not found.');
    }
}
