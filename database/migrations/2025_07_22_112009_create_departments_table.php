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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
                    $table->string('name');

            $table->timestamps();

            
        });
        DB::table('departments')->insert([
    ['name' => 'Computer Engineering', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Electrical Engineering', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Mechanical Engineering', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Civil Engineering', 'created_at' => now(), 'updated_at' => now()],
]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
