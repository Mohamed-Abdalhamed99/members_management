<?php

namespace Modules\Course\Database\Seeders;

use App\Models\Chapter;
use App\Models\Lecture;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CourseContentSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $ch1 = Chapter::create(['name' => 'الفصل الأول: القرآن الكريم', 'course_id' => 3, 'sort' => 1]);
        $ch2 = Chapter::create(['name' => 'الفصل الثاني: الوحي والقرآن', 'course_id' => 3, 'sort' => 2]);
        $ch3 = Chapter::create(['name' => 'الفصل الثالث: نشأة علوم القرآن', 'course_id' => 3, 'sort' => 3]);

        $lec1 = Lecture::create(['chapter_id' => $ch1->id , 'name' => 'الفصل الثاني: الوحي والقرآن', 'sort' => 2, 'completed_role' => 2]);


    }
}
