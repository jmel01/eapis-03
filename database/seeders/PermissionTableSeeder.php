<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'announcement-browse',
            'announcement-read',
            'announcement-edit',
            'announcement-add',
            'announcement-delete',
            'application-browse',
            'application-read',
            'application-edit',
            'application-add',
            'application-delete',
            'document-browse',
            'document-read',
            'document-edit',
            'document-add',
            'document-delete',
            'grant-browse',
            'grant-read',
            'grant-edit',
            'grant-add',
            'grant-delete',
            'profile-browse',
            'profile-read',
            'profile-edit',
            'profile-add',
            'profile-delete',
            'role-browse',
            'role-read',
            'role-edit',
            'role-add',
            'role-delete',
            'user-browse',
            'user-read',
            'user-edit',
            'user-add',
            'user-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
