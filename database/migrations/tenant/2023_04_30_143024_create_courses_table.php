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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('sub_title');
            $table->boolean('is_catalog')->default(0);
            $table->string('instructor_name');
            $table->string('instructor_avatar')->nullable();
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('course_category_id');
            $table->string('course_logo')->nullable();
            $table->text('about_course');
            $table->text('about_instructor');
            $table->string('highlights_1');
            $table->string('highlights_2')->nullable();
            $table->string('highlights_3')->nullable();
            $table->string('highlights_4')->nullable();
            $table->string('highlights_5')->nullable();
            $table->string('promotional_video')->nullable();
            $table->double('price')->default(0);
            $table->boolean('is_publish')->default(0);
            $table->timestamps();

            $table->foreign('level_id')->references('id')->on('courses_levels');
            $table->foreign('course_category_id')->references('id')->on('courses_categories')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
