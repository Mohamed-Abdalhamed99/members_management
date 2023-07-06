<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = Role::create(['name' => 'super_admin' , 'guard_name' => 'api']);

        foreach (Permission::get() as $permission){
            $super_admin->givePermissionTo($permission->name);
        }

      //  $assistant = Role::create(['name' => 'assistant' , 'guard_name' => 'api']);
    }
}
