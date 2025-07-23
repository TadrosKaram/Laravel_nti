<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = DB::table('doctors')->get();
        
        // Get doctor courses with course names
        $doctorCourses = DB::table('course_doctor')
            ->join('courses', 'course_doctor.course_id', '=', 'courses.id')
            ->select('course_doctor.doctor_id', 'courses.name as course_name', 'courses.id as course_id')
            ->get()
            ->groupBy('doctor_id');
            
        // Get doctor departments
        $doctorDepartments = DB::table('doctor_department')
            ->join('departments', 'doctor_department.department_id', '=', 'departments.id')
            ->select('doctor_department.doctor_id', 'departments.name as department_name', 'departments.id as department_id')
            ->get()
            ->groupBy('doctor_id');
            
        return view('doctors.index', compact('doctors', 'doctorCourses', 'doctorDepartments'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        DB::table('doctors')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'specialization' => $request->input('specialization'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

   public function edit($id)
{
      $doctor = DB::table('doctors')->where('id', $id)->first();
    if (!$doctor) {
        abort(404);
    }

    // Fetch all courses and departments
    $courses = DB::table('courses')->get();
    $departments = DB::table('departments')->get();

    // Get assigned course IDs
    $assignedCourses = DB::table('course_doctor')
        ->where('doctor_id', $id)
        ->pluck('course_id')
        ->toArray();

    // Get assigned department IDs
    $assignedDepartments = DB::table('doctor_department')
        ->where('doctor_id', $id)
        ->pluck('department_id')
        ->toArray();

    return view('doctors.edit', compact(
        'doctor', 'courses', 'departments', 'assignedCourses', 'assignedDepartments'
    ));
}

   public function update(Request $request, $id)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:doctors,email,' . $id,
        'phone' => 'nullable|string|max:20',
        'course_ids' => 'array',
        'department_ids' => 'array',
    ]);

    // Update doctor
    DB::table('doctors')->where('id', $id)->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'updated_at' => now(),
    ]);

    // Sync courses
    DB::table('course_doctor')->where('doctor_id', $id)->delete();
    if (!empty($validated['course_ids'])) {
        foreach ($validated['course_ids'] as $courseId) {
            DB::table('course_doctor')->insert([
                'doctor_id' => $id,
                'course_id' => $courseId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Sync departments
    DB::table('doctor_department')->where('doctor_id', $id)->delete();
    if (!empty($validated['department_ids'])) {
        foreach ($validated['department_ids'] as $deptId) {
            DB::table('doctor_department')->insert([
                'doctor_id' => $id,
                'department_id' => $deptId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // ✅ Redirect back to index
    return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
}

    public function destroy($id)
    {
        // Delete doctor course assignments first
        DB::table('course_doctor')->where('doctor_id', $id)->delete();
        
        // Delete doctor department assignments
        DB::table('doctor_department')->where('doctor_id', $id)->delete();
        
        // Delete doctor
        $deleted = DB::table('doctors')->where('id', $id)->delete();
        
        if ($deleted) {
            return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
        }
        
        return redirect()->route('doctors.index')->with('error', 'Doctor not found.');
    }

    // Course assignment methods
    public function assignCoursesForm()
    {
        $courses = DB::table('courses')->get();
        $doctorId = auth()->id(); // Assuming doctor is authenticated
        
        // Get current assignments
        $assignedCourseIds = DB::table('course_doctor')
            ->where('doctor_id', $doctorId)
            ->pluck('course_id')
            ->toArray();
            
        return view('doctors.assign-courses', compact('courses', 'assignedCourseIds'));
    }
public function assignCourse(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'course_id' => 'required|exists:courses,id',
    ]);

    DB::table('course_doctor')->insert([
        'doctor_id' => $request->doctor_id,
        'course_id' => $request->course_id,
    ]);

    return redirect()->route('doctors.index')->with('success', 'Course assigned to doctor.');
}
public function assignDepartmentForm()
{
    $doctors = DB::table('doctors')->get();
    $departments = DB::table('departments')->get();
    return view('doctors.assign_department', compact('doctors', 'departments'));
}

public function assignDepartment(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'department_id' => 'required|exists:departments,id',
    ]);

    DB::table('department_doctor')->insert([
        'doctor_id' => $request->doctor_id,
        'department_id' => $request->department_id,
    ]);

    return redirect()->route('doctors.index')->with('success', 'Doctor assigned to department.');
}


}
