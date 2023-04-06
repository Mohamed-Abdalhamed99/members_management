<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        /**
         * Central App Permissions
         */

        //logout
        Permission::create(['name' => 'dashboard.logout.api', 'display_name_ar' => 'تسجيل الخروج','display_name_en' => 'Logout', 'guard_name' => 'api', 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '0']);

        //Roles
        Permission::create(['name' => 'dashboard.roles.index'  , 'display_name_en' => 'Roles'        , 'display_name_ar' => 'الأدوار'         ,'guard_name' => 'api', 'route' => 'roles' ,'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'dashboard.roles.show'   , 'display_name_en' => 'Show Roles'   , 'display_name_ar' => 'قرائة الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'dashboard.roles.store'  , 'display_name_en' => 'Store Roles'  , 'display_name_ar' => 'إضاقة الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'dashboard.roles.update' , 'display_name_en' => 'Update Roles' , 'display_name_ar' => 'تعديل الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'dashboard.roles.delete' , 'display_name_en' => 'Delete Roles' , 'display_name_ar' => 'حذف الأدوار'     ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);

        // users
        Permission::create(['name' => 'dashboard.users.index' , 'display_name_en' => 'users'        , 'display_name_ar' => 'المستخدمين' ,'guard_name' => 'api',             'route' => 'users' ,'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'dashboard.users.show'  , 'display_name_en' => 'Show users'   , 'display_name_ar' => 'قرائة المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'dashboard.users.store' , 'display_name_en' => 'Store users'  , 'display_name_ar' => 'إضاقة المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'dashboard.users.update', 'display_name_en' => 'Update users' , 'display_name_ar' => 'تعديل المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'dashboard.users.delete', 'display_name_en' => 'Delete users' , 'display_name_ar' => 'حذف المستخدمين'       ,'guard_name' => 'api',   'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);


        /**
         * Tenant App
         */
        Permission::create(['name' => 'lms.logout.api', 'display_name_ar' => 'تسجيل الخروج','display_name_en' => 'Logout', 'guard_name' => 'api', 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '0']);

        //Roles
        Permission::create(['name' => 'lms.roles.index'  , 'display_name_en' => 'Roles'        , 'display_name_ar' => 'الأدوار'         ,'guard_name' => 'api', 'route' => 'roles' ,'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'lms.roles.show'   , 'display_name_en' => 'Show Roles'   , 'display_name_ar' => 'قرائة الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'lms.roles.store'  , 'display_name_en' => 'Store Roles'  , 'display_name_ar' => 'إضاقة الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'lms.roles.update' , 'display_name_en' => 'Update Roles' , 'display_name_ar' => 'تعديل الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'lms.roles.delete' , 'display_name_en' => 'Delete Roles' , 'display_name_ar' => 'حذف الأدوار'     ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);

        // users
        Permission::create(['name' => 'lms.users.index' , 'display_name_en' => 'users'        , 'display_name_ar' => 'المستخدمين' ,'guard_name' => 'api',             'route' => 'users' ,'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'lms.users.show'  , 'display_name_en' => 'Show users'   , 'display_name_ar' => 'قرائة المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'lms.users.store' , 'display_name_en' => 'Store users'  , 'display_name_ar' => 'إضاقة المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'lms.users.update', 'display_name_en' => 'Update users' , 'display_name_ar' => 'تعديل المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'lms.users.delete', 'display_name_en' => 'Delete users' , 'display_name_ar' => 'حذف المستخدمين'       ,'guard_name' => 'api',   'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);


        //Tenants
        Permission::create(['name' => 'tenants.index'       , 'display_name_en' => 'Tenant'        , 'display_name_ar' => 'المستأجرين' ,'guard_name' => 'api',            'route' => 'tenants' , 'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'tenants.show'  , 'display_name_en' => 'Show Tenant'   , 'display_name_ar' => 'قرائة المستأجرين'       ,'guard_name' => 'api','route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'tenants.store' , 'display_name_en' => 'Store Tenant'  , 'display_name_ar' => 'إضاقة المستأجرين'       ,'guard_name' => 'api','route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'tenants.update', 'display_name_en' => 'Update Tenant' , 'display_name_ar' => 'تعديل المستأجرين'       ,'guard_name' => 'api','route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'tenants.delete', 'display_name_en' => 'Delete Tenant' , 'display_name_ar' => 'حذف المستأجرين'       ,'guard_name' => 'api',  'route' => null    ,  'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);


    }
}
