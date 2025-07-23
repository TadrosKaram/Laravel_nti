@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 mt-10 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center text-blue-700">Add New Student</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Name</label>
            <input type="text" name="name" class="w-full border rounded px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Age</label>
            <input type="number" name="age" class="w-full border rounded px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border rounded px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" class="w-full border rounded px-4 py-2" required>
        </div>



        <div class="text-center">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Add Student
            </button>
        </div>
    </form>
</div>
@endsection
