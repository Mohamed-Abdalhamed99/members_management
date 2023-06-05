<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        \App\Models\CoursesLevel::create(['name' => 'مبتدئ']);
        \App\Models\CoursesLevel::create(['name' => 'متوسط']);
        \App\Models\CoursesLevel::create(['name' => 'محترف']);
        \App\Models\CoursesLevel::create(['name' => 'كل المستويات']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_levels');
    }
};
