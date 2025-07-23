@extends('layouts.app')

<a href="{{route('courses.index')}}" style="color: white">⬅️Back</a>

<form action="{{ route('courses.store') }}" method="POST" class="max-w-md mx-auto mt-10">
    @csrf
    <div class="mb-4">
        <label class="block mb-1" style="color:white">Course Name</label>
        <input type="text" name="name" class="w-full border p-2 rounded" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1" style="color: white">Hours</label>
        <input type="number" name="hours" class="w-full border p-2 rounded" required>
    </div>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add Course</button>
</form>
