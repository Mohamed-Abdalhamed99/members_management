<?php

use App\Models\QuestionType;
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
        Schema::create('question_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        QuestionType::create(['type' => 'أسئلة الاختيار من متعدد']);
        QuestionType::create(['type' => 'املأ الفراغات']);
        QuestionType::create(['type' => 'صح و خطأ']);
        QuestionType::create(['type' => 'سؤال مقالي']);
        QuestionType::create(['type' => 'توصيل']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_types');
    }
};
