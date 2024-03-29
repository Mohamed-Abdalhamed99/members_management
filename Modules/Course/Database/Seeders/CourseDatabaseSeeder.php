<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CourseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         $this->call(CoursesCategoriesSeederTableSeeder::class);
         $this->call(CoursesSeederTableSeeder::class);
         $this->call(CourseContentSeederTableSeeder::class);
    }
}
