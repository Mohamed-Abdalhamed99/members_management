<?php

namespace Modules\Exam\Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class QuestionTypesSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        QuestionType::create(['type' => 'أسئلة الاختيار من متعدد']);
        QuestionType::create(['type' => 'املأ الفراغات']);
        QuestionType::create(['type' => 'صح و خطأ']);
        QuestionType::create(['type' => 'سؤال مقالي']);
        QuestionType::create(['type' => 'توصيل']);
    }
}
