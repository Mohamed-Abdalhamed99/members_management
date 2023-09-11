<?php

namespace Modules\Exam\Database\Seeders;

use App\Models\Exam;
use App\Models\Tenant;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ExamDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $tenant = Tenant::find('demo');

        $tenant->run(function () use ($faker) {

            for ($i =0 ; $i < 5 ; $i++)
            {
                $exam = Exam::create([
                    'name' => $faker->unique()->sentence(),
                    'description' => "<p>". $faker->paragraph() ."</p>",
                    'instructor' => $faker->name(),
                    'instructions' => "<p>". $faker->paragraph() ."</p>",
                    'passing_score' => 100,
                    'price' => 250,]);

                for($j = 0 ; $j<2 ; $j++)
                {
                    $q1 = $exam->questions()->create([
                        'title' => $faker->sentence,
                        'grade' => 1,
                        'question_type_id' => 1,
                    ]);

                    $q1->choices()->create([
                        'choice_a' => $faker->word(),
                        'choice_b' => $faker->word(),
                        'choice_c' => $faker->word(),
                        'choice_d' => $faker->word(),
                        'answer' => $faker->word()
                    ]);

                    $q2 = $exam->questions()->create([
                        'title' => "Hello , My name is [a] , I am from [b] , My age is [c]",
                        'grade' => 3,
                        'question_type_id' => 2,
                    ]);
                    $q2->fillblank()->create([
                        'blank_name' => 'a',
                        'answer' => $faker->name
                    ]);
                    $q2->fillblank()->create([
                        'blank_name' => 'b',
                        'answer' => $faker->address()
                    ]);
                    $q2->fillblank()->create([
                        'blank_name' => 'c',
                        'answer' => $faker->numberBetween(10 , 25)
                    ]);

                    $q3 = $exam->questions()->create([
                        'title' => $faker->sentence,
                        'grade' => 3,
                        'question_type_id' => 3,
                    ]);
                    $q3->tureOrFalse()->create([
                        'answer' => $faker->boolean()
                    ]);

                    $q4 = $exam->questions()->create([
                        'title' => $faker->sentence,
                        'grade' => 10,
                        'question_type_id' => 4,
                    ]);
                    $q4->freetext()->create([
                        'words' => $faker->boolean()
                    ]);

                    $q5 = $exam->questions()->create([
                        'title' => $faker->sentence,
                        'grade' => 5,
                        'question_type_id' => 5,
                    ]);
                    for($k = 0 ; $k<5 ; $k++)
                    {
                        $q5->matching()->create([
                            'option' => $faker->sentence(),
                            'match' => $faker->sentence()
                       ]);
                    }
                }
            }

        });


    }
}
