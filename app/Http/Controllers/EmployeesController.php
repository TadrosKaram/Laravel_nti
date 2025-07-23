<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = DB::table('employees')->get();
        
        // Get employee departments
        $employeeDepartments = DB::table('employee_department')
            ->join('departments', 'employee_department.department_id', '=', 'departments.id')
            ->select('employee_department.employee_id', 'departments.name as department_name', 'departments.id as department_id')
            ->get()
            ->groupBy('employee_id');
            
        return view('employees.index', compact('employees', 'employeeDepartments'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'position' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'salary' => 'nullable|numeric|min:0',
        ]);

        DB::table('employees')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'position' => $request->input('position'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'salary' => $request->input('salary'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $employee = DB::table('employees')->where('id', $id)->first();
        
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', 'Employee not found.');
        }
        
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'position' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'salary' => 'nullable|numeric|min:0',
        ]);

        $updated = DB::table('employees')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'position' => $request->input('position'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'salary' => $request->input('salary'),
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        }
        
        return redirect()->route('employees.index')->with('error', 'Employee not found.');
    }

    public function destroy($id)
    {
        // Delete employee department assignments first
        DB::table('employee_department')->where('employee_id', $id)->delete();
        
        // Delete employee
        $deleted = DB::table('employees')->where('id', $id)->delete();
        
        if ($deleted) {
            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
        }
        
        return redirect()->route('employees.index')->with('error', 'Employee not found.');
    }

    // Department assignment methods
    public function assignDepartmentsForm()
    {
        $departments = DB::table('departments')->get();
        $employeeId = auth()->id(); // Assuming employee is authenticated
        
        // Get current assignments
        $assignedDepartmentIds = DB::table('employee_department')
            ->where('employee_id', $employeeId)
            ->pluck('department_id')
            ->toArray();
            
        return view('employees.assign-departments', compact('departments', 'assignedDepartmentIds'));
    }

    public function assignDepartments(Request $request)
    {
        $request->validate([
            'department_ids' => 'required|array',
            'department_ids.*' => 'exists:departments,id',
        ]);

        $employeeId = auth()->id();
        $departmentIds = $request->input('department_ids');

        // Remove existing assignments
        DB::table('employee_department')->where('employee_id', $employeeId)->delete();

        // Add new assignments
        foreach ($departmentIds as $departmentId) {
            DB::table('employee_department')->insert([
                'employee_id' => $employeeId,
                'department_id' => $departmentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('employees.assign.departments.form')
            ->with('success', 'Departments assigned successfully.');
    }

    // Admin assignment methods
    public function assignDepartmentsFormAdmin()
    {
        $employees = DB::table('employees')->get();
        $departments = DB::table('departments')->get();
        
        // Get existing assignments
        $assignments = DB::table('employee_department')
            ->join('employees', 'employee_department.employee_id', '=', 'employees.id')
            ->join('departments', 'employee_department.department_id', '=', 'departments.id')
            ->select('employee_department.*', 'employees.name as employee_name', 'departments.name as department_name')
            ->get();
            
        return view('assignments.employee-departments', compact('employees', 'departments', 'assignments'));
    }

    public function assignDepartmentsAdmin(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'department_ids' => 'required|array',
            'department_ids.*' => 'exists:departments,id',
        ]);

        $employeeId = $request->input('employee_id');
        $departmentIds = $request->input('department_ids');

        // Remove existing assignments for this employee
        DB::table('employee_department')->where('employee_id', $employeeId)->delete();

        // Add new assignments
        foreach ($departmentIds as $departmentId) {
            DB::table('employee_department')->insert([
                'employee_id' => $employeeId,
                'department_id' => $departmentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('assignments.employee.departments.form')
            ->with('success', 'Employee departments assigned successfully.');
    }
}
