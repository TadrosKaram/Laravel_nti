<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
    $table->string('job')->nullable();
    $table->string('email')->unique();
            $table->timestamps();
        });
         DB::table('employees')->insert([
        [
            'name' => 'Ahmed Mostafa',
            'job' => 'Software Engineer',
            'email' => 'ahmed@example.com',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Sara Ali',
            'job' => 'HR Manager',
            'email' => 'sara@example.com',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Tarek Nabil',
            'job' => 'Designer',
            'email' => 'tarek@example.com',
            'created_at' => now(),
            'updated_at' => now()
        ]
    ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
