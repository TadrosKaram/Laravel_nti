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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        $table->integer('hours');
            $table->timestamps();
        });

              DB::table('courses')->insert([
            ['name' => 'Data Structures', 'hours' => 4],
            ['name' => 'Operating Systems', 'hours' => 2],
            ['name' => 'Computer Networks', 'hours' => 3],
            ['name' => 'Database Systems', 'hours' => 4],
            ['name' => 'Software Engineering', 'hours' => 3],
            ['name' => 'Machine Learning', 'hours' => 65],
            ['name' => 'Web Development', 'hours' => 3],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
