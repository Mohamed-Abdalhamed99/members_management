<?php

namespace Modules\Course\Database\Seeders;

use App\Models\Chapter;
use App\Models\Lecture;
use App\Models\LectureContent;
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

        $lec1 = Lecture::create(['chapter_id' => $ch1->id, 'name' => 'لفظ القرآن', 'sort' => 1, 'completed_rule' => 2]);
        LectureContent::create(['lecture_id' => $lec1->id, 'title' => 'القرآن ولغة العرب:', 'type' => LectureContent::VIDEO])
            ->addMediaFromUrl('https://www.youtube.com/watch?v=jdyPyjg_Es4')
            ->toMediaCollection('lec_content');
        LectureContent::create(['lecture_id' => $lec1->id, 'title' => 'اكسيل شيت', 'type' => LectureContent::DOCUMENT])
            ->addMedia(public_path('media_library/b451222fcf139a9d7cb5dd8e8971d21c.xlsx'))
            ->usingFileName('b451222fcf139a9d7cb5dd8e8971d21c.xlsx')
            ->preservingOriginal()
            ->toMediaCollection('lec_content');

        $lec2 = Lecture::create(['chapter_id' => $ch1->id, 'name' => 'القرآن ولغة العرب:', 'sort' => 2, 'completed_rule' => 2]);
        LectureContent::create(['lecture_id' => $lec2->id, 'title' => 'القرآن ولغة العرب:', 'type' => LectureContent::VIDEO])
            ->addMediaFromUrl('https://www.youtube.com/watch?v=jdyPyjg_Es4')
            ->toMediaCollection('lec_content');
        LectureContent::create(['lecture_id' => $lec2->id, 'title' => 'ملخص الدرس', 'type' => LectureContent::DOCUMENT])
            ->addMedia(public_path('media_library/e88df53d0dc414ad94ca87275a410175.docx'))
            ->usingFileName('e88df53d0dc414ad94ca87275a410175.docx')
            ->preservingOriginal()
            ->toMediaCollection('lec_content');


        $ch1 = Chapter::create(['name' => 'مفهوم البرمجة', 'course_id' => 27, 'sort' => 1]);
        $ch2 = Chapter::create(['name' => 'أساسيات البرمجة', 'course_id' => 27, 'sort' => 2]);
        $ch3 = Chapter::create(['name' => 'البرمجة الكائنية', 'course_id' => 27, 'sort' => 3]);
        $ch3 = Chapter::create(['name' => 'قواعد البيانات', 'course_id' => 27, 'sort' => 4]);
    }
}
