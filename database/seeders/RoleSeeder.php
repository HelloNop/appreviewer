<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            'super_admin',
            'panel_user', 
            'reviewer',
            'editor',
            'admin'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
        }

        // You can add specific permissions for each role here if needed
        // Example:
        // $reviewerRole = Role::findByName('reviewer');
        // $reviewerRole->givePermissionTo('view_journals', 'review_articles');
    }
}