@extends('layouts.app') {{-- Optional: remove if not using a layout --}}

@section('content')

<a href="{{route('courses.index')}}" style="color: white">⬅️Back</a>
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Edit Course</h2>

    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 text-gray-700">Course Name</label>
            <input type="text" name="name" value="{{ $course->name }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-gray-700">Hours</label>
            <input type="number" name="hours" value="{{ $course->hours }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Course</button>
    </form>
</div>
@endsection
