<?php

namespace Database\Seeders;

use App\Models\CoursesCategory;
use Illuminate\Database\Seeder;

class CourseCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CoursesCategory::create(['name' => 'علوم القرآن' , 'description' => 'علوم القرآن وتفسيره وأسباب النزول وعلوم التجويد']);
        CoursesCategory::create(['name' => 'علوم الحديث' , 'description' => 'علوم الحديث ومصطلح الحديث ']);
        CoursesCategory::create(['name' => 'البرمجة والتقنيات' , 'description' => 'علوم البرمجة والحاسوب']);
    }
}
