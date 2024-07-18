<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create roles
        $roleAdmin = Role::create(['name'=>'admin']);
        $roleArtisan = Role::create(['name'=>'artisan']);
        $roleAuthClient = Role::create(['name'=>'authClient']);

        //create permission
        $viewUsersPermission = permission::create(['name'=> 'view.users']);
        $createProductsPermission = permission::create(['name'=> 'create.product']);
        $viewOrderPermission = permission::create(['name'=> 'view.order']);

        //create,update,view,delete

        //give permission
        $roleAdmin->givePermissionTo
        ($viewUsersPermission,$createProductsPermission,$viewOrderPermission);
        $roleArtisan->givePermissionTo($createProductsPermission,$viewOrderPermission);
        $roleAuthClient ->givePermissionTo([$viewOrderPermission]);





    }
}
