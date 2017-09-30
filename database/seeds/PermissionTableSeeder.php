<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\User;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Permission::truncate();
        Role::truncate();
        User::truncate();
        DB::table('role_user')->delete();
        DB::table('permission_role')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $ps = User::create([
            'name' => 'ps',
            'email' => 'ps@admin.com',
            'password' => bcrypt('376313736')
            ]);
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'super user',
            'description' => 'super admin'
            ]);
        $permissions = [
        ['name' => 'upload.store'],
        ['name' => 'photos.update'],
        ['name' => 'photos.store'],
        ['name' => 'photos.destroy'],
        ['name' => 'file.down'],
        ['name' => 'albums.update'],
        ['name' => 'albums.store'],
        ['name' => 'albums.destroy'],
        ['name' => 'admin.users.update'],
        ['name' => 'admin.users.destroy'],
        ['name' => 'admin.roles.update'],
        ['name' => 'admin.roles.store'],
        ['name' => 'admin.roles.destroy']
        ];
        foreach ($permissions as $permission) {
            $per = Permission::create($permission);
            $admin->attachPermission($per);
        }
        $ps->attachRole($admin);

    }
}
