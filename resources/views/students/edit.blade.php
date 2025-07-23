@extends('layouts.app')

@section('content')
<a class="text-xl text-white" href="{{ route('students.index') }}">⬅️ Back to Student</a>

<div class="flex justify-center">
    <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow mt-10">
        <h1 class="text-3xl font-bold mb-6 text-center text-blue-700">Edit Student</h1>

        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" name="name" value="{{ $student->name }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
            </div>

           <div class="mb-4">
                <label for="age" class="block text-gray-700 font-bold mb-2">Age:</label>
                <input type="number" name="age" value="{{ $student->age }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" name="email" value="{{ $student->email }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
            </div>

                       <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-bold mb-2">Phone:</label>
                <input type="text" name="phone" value="{{ $student->phone }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
            </div>
            <div class="mb-4">
    <label for="courses" class="block text-gray-700 font-bold mb-2">Registered Courses:</label>
    <select name="courses[]" multiple class="w-full border p-2 rounded">
        @foreach($courses as $course)
            <option value="{{ $course->id }}" 
                @if(in_array($course->id, $studentCourseIds)) selected @endif>
                {{ $course->name }}
            </option>
        @endforeach
    </select>
    
</div>


            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Update Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
