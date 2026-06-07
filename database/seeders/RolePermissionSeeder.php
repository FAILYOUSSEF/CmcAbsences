<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-poles',
            'manage-filieres',
            'manage-groupes',
            'manage-stagiaires',
            'manage-formateurs',
            'manage-seances',
            'mark-absences',
            'view-statistics',
            'export-data',
            'view-alerts',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create roles and assign created permissions

        // formateur
        $roleFormateur = Role::firstOrCreate(['name' => 'formateur']);
        $roleFormateur->givePermissionTo(['manage-seances', 'mark-absences', 'view-statistics']);

        // gs
        $roleGS = Role::firstOrCreate(['name' => 'gs']);
        $roleGS->givePermissionTo([
            'manage-groupes', 'manage-stagiaires', 'manage-seances', 
            'view-statistics', 'export-data', 'view-alerts'
        ]);

        // admin
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleAdmin->givePermissionTo(Permission::all());
    }
}
