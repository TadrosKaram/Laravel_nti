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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
              $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->integer('age');
        $table->string('phone') ->unique();
            $table->timestamps();
        });
DB::table('students')->insert([
    [
        'name' => 'mohsen',
        'email' => 'mohsen@gmail.com',
        'password' => bcrypt('1234'),
        'age' => 19,
        'phone' => '011xxxxxxx',
        'created_at' => '2023-06-09 20:30:00',
        'updated_at' => now()
    ]
]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }

    
};
