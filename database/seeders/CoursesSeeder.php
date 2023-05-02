<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'title' => 'مدخل الى علوم القرآن',
            'sub_title' => 'شرح لكتاب المدخل إلى علوم القرآن الكريم لمحمد فاروق النبهان',
            'is_catalog' => '1',
            'level_id' => '1',
            'course_category_id ' => '1',
            'course_logo' => '',
            'about_course' => '',
            'highlights_1' => '',
            'highlights_2' => '',
            'highlights_3' => '',
            'highlights_4' => '',
            'highlights_5' => '',
            'promotional_video' => '',
            'price' => '0'
        ]);
    }
}
