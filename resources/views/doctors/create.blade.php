@extends('layouts.app')

@section('content')
<a class="text-xl text-white" href="{{ route('doctors.index') }}">⬅️ Back to Doctors</a>

<div class="flex justify-center">
    <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow mt-10">
        <h1 class="text-3xl font-bold mb-6 text-center text-purple-700">Add New Doctor</h1>

        <form action="{{ route('doctors.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="mb-4">
                <label for="age" class="block text-gray-700 font-bold mb-2">Age:</label>
                <input type="number" name="age" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-bold mb-2">Phone:</label>
                <input type="text" name="phone" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-600">
            </div>

            <div class="text-center">
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                    Add Doctor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
