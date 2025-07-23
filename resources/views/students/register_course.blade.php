@extends('layouts.app')
@section('content')

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4" style="color: white">Register Student to Course</h2>

    <form action="{{ route('students.register') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-medium">Select Student</label>
            <select name="student_id" class="w-full border p-2 rounded">
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Select Course</label>
           <select name="course_id[]" class="w-full border p-2 rounded" multiple>
    @foreach($courses as $course)
        <option value="{{ $course->id }}">{{ $course->name }}</option>
    @endforeach
</select>

        </div>

        <button href="{{ route('students.index') }}" style="background-color: blueviolet; border-radius:5%; color:white" >Register Course</button>

    </form>
</div>
@endsection
