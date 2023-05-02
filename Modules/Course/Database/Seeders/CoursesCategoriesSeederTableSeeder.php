<?php

namespace Modules\Course\Database\Seeders;

use App\Models\CoursesCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CoursesCategoriesSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CoursesCategory::create(['name' => 'علوم القرآن' , 'description' => 'علوم القرآن وتفسيره وأسباب النزول وعلوم التجويد']);
        CoursesCategory::create(['name' => 'علوم الحديث' , 'description' => 'علوم الحديث ومصطلح الحديث ']);
        CoursesCategory::create(['name' => 'البرمجة والتقنيات' , 'description' => 'علوم البرمجة والحاسوب']);
    }
}
