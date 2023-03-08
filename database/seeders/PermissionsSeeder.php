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
       // Permission::create(['name' => '', 'display_name' => 'Home', 'guard_name' => 'admin', 'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'logout', 'display_name_ar' => 'تسجيل الخروج','display_name_en' => 'Logout', 'guard_name' => 'api', 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '0']);

        //Roles
        Permission::create(['name' => 'roles'       , 'display_name_en' => 'Roles'        , 'display_name_ar' => 'الأدوار'         ,'guard_name' => 'api', 'route' => 'roles' ,'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'roles.show'  , 'display_name_en' => 'Show Roles'   , 'display_name_ar' => 'قرائة الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'roles.store' , 'display_name_en' => 'Store Roles'  , 'display_name_ar' => 'إضاقة الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'roles.update', 'display_name_en' => 'Update Roles' , 'display_name_ar' => 'تعديل الأدوار'   ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'roles.delete', 'display_name_en' => 'Delete Roles' , 'display_name_ar' => 'حذف الأدوار'     ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);

        //Tenants
        Permission::create(['name' => 'tenants'       , 'display_name_en' => 'Tenant'        , 'display_name_ar' => 'المستأجرين' ,'guard_name' => 'api',            'route' => 'tenants' , 'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'tenants.show'  , 'display_name_en' => 'Show Tenant'   , 'display_name_ar' => 'قرائة المستأجرين'       ,'guard_name' => 'api','route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'tenants.store' , 'display_name_en' => 'Store Tenant'  , 'display_name_ar' => 'إضاقة المستأجرين'       ,'guard_name' => 'api','route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'tenants.update', 'display_name_en' => 'Update Tenant' , 'display_name_ar' => 'تعديل المستأجرين'       ,'guard_name' => 'api','route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'tenants.delete', 'display_name_en' => 'Delete Tenant' , 'display_name_ar' => 'حذف المستأجرين'       ,'guard_name' => 'api',  'route' => null    ,  'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);

        //plans
        Permission::create(['name' => 'plans'       , 'display_name_en' => 'Plans'        , 'display_name_ar' => 'الخطط' ,'guard_name' => 'api',             'route' => 'plans' , 'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'plans.show'  , 'display_name_en' => 'Show Plans'   , 'display_name_ar' => 'قرائة الخطط'       ,'guard_name' => 'api', 'route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'plans.store' , 'display_name_en' => 'Store Plans'  , 'display_name_ar' => 'إضاقة الخطط'       ,'guard_name' => 'api', 'route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'plans.update', 'display_name_en' => 'Update Plans' , 'display_name_ar' => 'تعديل الخطط'       ,'guard_name' => 'api', 'route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'plans.delete', 'display_name_en' => 'Delete Plans' , 'display_name_ar' => 'حذف الخطط'       ,'guard_name' => 'api',   'route' => null    , 'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);

        //plans
        Permission::create(['name' => 'users'       , 'display_name_en' => 'users'        , 'display_name_ar' => 'المستخدمين' ,'guard_name' => 'api',             'route' => 'users' ,'icon' => 'fas fa-user', 'appear' => '1', 'ordering' => '1']);
        Permission::create(['name' => 'users.show'  , 'display_name_en' => 'Show users'   , 'display_name_ar' => 'قرائة المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'users.store' , 'display_name_en' => 'Store users'  , 'display_name_ar' => 'إضاقة المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'users.update', 'display_name_en' => 'Update users' , 'display_name_ar' => 'تعديل المستخدمين'       ,'guard_name' => 'api', 'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);
        Permission::create(['name' => 'users.delete', 'display_name_en' => 'Delete users' , 'display_name_ar' => 'حذف المستخدمين'       ,'guard_name' => 'api',   'route' => null    ,'icon' => 'fas fa-user', 'appear' => '0', 'ordering' => '1']);

    }
}
