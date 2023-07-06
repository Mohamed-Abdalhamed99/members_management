<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // super admin
        $super_admin = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' =>  Hash::make('admin'),
            'mobile' => $faker->phoneNumber,
            'address' => $faker->address,
            'avatar' => 'avatar.png',
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'status' => '1',
        ]);

        $super_admin->assignRole('super_admin');

        User::factory(10)->create();
    }
}
