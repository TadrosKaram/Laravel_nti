<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = DB::table('students')->get();
        
        // Get student courses with course names
        $studentCourses = DB::table('course_student')
            ->join('courses', 'course_student.course_id', '=', 'courses.id')
            ->select('course_student.student_id', 'courses.name as course_name', 'courses.id as course_id')
            ->get()
            ->groupBy('student_id');
            
        return view('students.index', compact('students', 'studentCourses'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'gender' => 'required|string|in:male,female',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        DB::table('students')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit($id)
    {
        $student = DB::table('students')->where('id', $id)->first();
        
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }
        
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'gender' => 'required|string|in:male,female',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $updated = DB::table('students')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'gender' => $request->input('gender'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        }
        
        return redirect()->route('students.index')->with('error', 'Student not found.');
    }

    public function destroy($id)
    {
        // Delete student course assignments first
        DB::table('course_student')->where('student_id', $id)->delete();
        
        // Delete student
        $deleted = DB::table('students')->where('id', $id)->delete();
        
        if ($deleted) {
            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        }
        
        return redirect()->route('students.index')->with('error', 'Student not found.');
    }

    // Assignment forms and methods
    public function assignCoursesForm()
    {
        $students = DB::table('students')->get();
        $courses = DB::table('courses')->get();
        
        // Get existing assignments
        $assignments = DB::table('course_student')
            ->join('students', 'course_student.student_id', '=', 'students.id')
            ->join('courses', 'course_student.course_id', '=', 'courses.id')
            ->select('course_student.*', 'students.name as student_name', 'courses.name as course_name')
            ->get();
            
        return view('assignments.student-courses', compact('students', 'courses', 'assignments'));
    }

    public function assignCourses(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $studentId = $request->input('student_id');
        $courseIds = $request->input('course_ids');

        // Remove existing assignments for this student
        DB::table('course_student')->where('student_id', $studentId)->delete();

        // Add new assignments
        foreach ($courseIds as $courseId) {
            DB::table('course_student')->insert([
                'student_id' => $studentId,
                'course_id' => $courseId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('assignments.student.courses.form')
            ->with('success', 'Student courses assigned successfully.');
    }

    // Student self-registration methods
    public function registerCoursesForm()
    {
        $courses = DB::table('courses')->get();
        $studentId = auth()->id(); // Assuming student is authenticated
        
        // Get current registrations
        $registeredCourseIds = DB::table('course_student')
            ->where('student_id', $studentId)
            ->pluck('course_id')
            ->toArray();
            
        return view('students.register-courses', compact('courses', 'registeredCourseIds'));
    }

    public function registerCourses(Request $request)
    {
        $request->validate([
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $studentId = auth()->id();
        $courseIds = $request->input('course_ids');

        // Remove existing registrations
        DB::table('course_student')->where('student_id', $studentId)->delete();

        // Add new registrations
        foreach ($courseIds as $courseId) {
            DB::table('course_student')->insert([
                'student_id' => $studentId,
                'course_id' => $courseId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('students.register.courses.form')
            ->with('success', 'Courses registered successfully.');
    }
}

?>