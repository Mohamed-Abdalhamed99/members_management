<?php

namespace Modules\Student\Database\Seeders;

use App\Models\Student;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class StudentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $tenant = Tenant::where('id' , 'demo')->first();
        $tenant->run(function (){
            Student::factory(50)->create();
        });

        // $this->call("OthersTableSeeder");
    }
}
