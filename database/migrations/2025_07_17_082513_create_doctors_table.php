<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
             $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->integer('age');
        $table->string('phone') ->unique();
            $table->timestamps();
        });
        DB::table('doctors')->insert([
    [
        'name' => 'Islam Ramadan',
        'email' => 'islam.ramadan@example.com',
        'password' => bcrypt('1234'),
        'age' => 25,
        'phone' => '01012345678',
        'created_at' => '2023-06-09 00:00:00',
        'updated_at' => now()
    ],
    [
        'name' => 'Salma Youssef',
        'email' => 'salma.youssef@example.com',
        'password' => bcrypt('1234'),
        'age' => 32,
        'phone' => '01123456789',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'Ahmed Nabil',
        'email' => 'ahmed.nabil@example.com',
        'password' => bcrypt('1234'),
        'age' => 29,
        'phone' => '01234567890',
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
        Schema::dropIfExists('doctors');
    }
};
