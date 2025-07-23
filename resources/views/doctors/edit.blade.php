@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('doctors.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">⬅️ Back to Doctors</a>

    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6">Edit Doctor</h2>

        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ $doctor->name }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $doctor->email }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ $doctor->phone }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <!-- Assign Courses -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Assign Courses</label>
                <select name="course_ids[]" multiple class="w-full border p-2 rounded">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                            @if(in_array($course->id, $assignedCourses)) selected @endif>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Assign Departments -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Assign Departments</label>
                <select name="department_ids[]" multiple class="w-full border p-2 rounded">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            @if(in_array($department->id, $assignedDepartments)) selected @endif>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit -->
            <div class="text-center">
                
                <button type="submit"
                
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                 
                    Update Doctor
                </button>
                   
            </div>
        </form>
    </div>
</div>
@endsection
