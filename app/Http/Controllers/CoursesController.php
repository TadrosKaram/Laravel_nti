<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = DB::table('courses')->get();
        
        // Get course students
        $courseStudents = DB::table('course_student')
            ->join('students', 'course_student.student_id', '=', 'students.id')
            ->select('course_student.course_id', 'students.name as student_name', 'students.id as student_id')
            ->get()
            ->groupBy('course_id');
            
        // Get course doctors
        $courseDoctors = DB::table('course_doctor')
            ->join('doctors', 'course_doctor.doctor_id', '=', 'doctors.id')
            ->select('course_doctor.course_id', 'doctors.name as doctor_name', 'doctors.id as doctor_id')
            ->get()
            ->groupBy('course_id');
            
        return view('courses.index', compact('courses', 'courseStudents', 'courseDoctors'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:courses,code',
            'hours' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        DB::table('courses')->insert([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'hours' => $request->input('hours'),
            'description' => $request->input('description'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit($id)
    {
        $course = DB::table('courses')->where('id', $id)->first();
        
        if (!$course) {
            return redirect()->route('courses.index')->with('error', 'Course not found.');
        }
        
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:courses,code,' . $id,
            'hours' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        $updated = DB::table('courses')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'hours' => $request->input('hours'),
                'description' => $request->input('description'),
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
        }
        
        return redirect()->route('courses.index')->with('error', 'Course not found.');
    }

    public function destroy($id)
    {
        // Delete course assignments first
        DB::table('course_student')->where('course_id', $id)->delete();
        DB::table('course_doctor')->where('course_id', $id)->delete();
        
        // Delete course
        $deleted = DB::table('courses')->where('id', $id)->delete();
        
        if ($deleted) {
            return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
        }
        
        return redirect()->route('courses.index')->with('error', 'Course not found.');
    }


}
