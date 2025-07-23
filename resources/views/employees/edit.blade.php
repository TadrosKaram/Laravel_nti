@extends('layouts.app')

@section('content')
<a class="text-xl text-white" href="{{ route('employees.index') }}">⬅️ Back to Employees</a>

<div class="flex justify-center">
    <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow mt-10">
        <h1 class="text-3xl font-bold mb-6 text-center text-purple-700">Edit Employee</h1>

        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" value="{{ $employee->name }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="mb-4">
                <label for="job" class="block text-gray-700 font-bold mb-2">Job Title:</label>
                <input type="text" name="job" id="job" value="{{ $employee->job }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" value="{{ $employee->email }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Update Employee
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
