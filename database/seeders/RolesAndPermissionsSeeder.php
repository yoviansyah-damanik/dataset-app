<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create voter']);
        Permission::create(['name' => 'create voter family']);
        Permission::create(['name' => 'read voter']);
        Permission::create(['name' => 'show voter']);
        Permission::create(['name' => 'update voter']);
        Permission::create(['name' => 'delete voter']);
        Permission::create(['name' => 'print voter']);
        Permission::create(['name' => 'migration voter']);
        Permission::create(['name' => 'transfer voter']);

        Permission::create(['name' => 'read dpt']);

        Permission::create(['name' => 'read region']);

        Permission::create(['name' => 'create district']);
        Permission::create(['name' => 'read district']);
        Permission::create(['name' => 'update district']);
        Permission::create(['name' => 'delete district']);

        Permission::create(['name' => 'create village']);
        Permission::create(['name' => 'read village']);
        Permission::create(['name' => 'update village']);
        Permission::create(['name' => 'delete village']);

        Permission::create(['name' => 'create tps']);
        Permission::create(['name' => 'read tps']);
        Permission::create(['name' => 'update tps']);
        Permission::create(['name' => 'delete tps']);

        Permission::create(['name' => 'read master']);

        Permission::create(['name' => 'create marital_status']);
        Permission::create(['name' => 'read marital_status']);
        Permission::create(['name' => 'update marital_status']);
        Permission::create(['name' => 'delete marital_status']);

        Permission::create(['name' => 'create profession']);
        Permission::create(['name' => 'read profession']);
        Permission::create(['name' => 'update profession']);
        Permission::create(['name' => 'delete profession']);

        Permission::create(['name' => 'create religion']);
        Permission::create(['name' => 'read religion']);
        Permission::create(['name' => 'update religion']);
        Permission::create(['name' => 'delete religion']);

        Permission::create(['name' => 'create nasionality']);
        Permission::create(['name' => 'read nasionality']);
        Permission::create(['name' => 'update nasionality']);
        Permission::create(['name' => 'delete nasionality']);

        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'read users administrator']);

        Permission::create(['name' => 'personalization']);

        Permission::create(['name' => 'general config']);
        Permission::create(['name' => 'log_activity config']);
        Permission::create(['name' => 'log_activity config all']);

        Role::create(['name' => 'Superadmin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'Administrator'])
            ->givePermissionTo(
                'create voter',
                'show voter',
                'read voter',
                'read dpt',
                'read region',
                'read master',
                'read district',
                'read village',
                'read tps',
                'read marital_status',
                'read profession',
                'read religion',
                'read nasionality',
                'log_activity config'
            );

        Role::create(['name' => 'Administrator Keluarga'])
            ->givePermissionTo(
                'create voter family',
                'show voter',
                'read voter',
                'read dpt',
                'read region',
                'read master',
                'read district',
                'read village',
                'read tps',
                'read marital_status',
                'read profession',
                'read religion',
                'read nasionality',
                'log_activity config'
            );

        Role::create(['name' => 'Koordinator Kecamatan'])
            ->givePermissionTo(
                [
                    'show voter',
                    'read voter',
                    'read region',
                    'read master',
                    'log_activity config',
                    'personalization'
                ]
            );

        Role::create(['name' => 'Koordinator Kelurahan/Desa'])
            ->givePermissionTo(
                [
                    'show voter',
                    'read voter',
                    'read region',
                    'read master',
                    'log_activity config',
                    'personalization'
                ]
            );

        Role::create(['name' => 'Koordinator TPS'])
            ->givePermissionTo([
                'show voter',
                'read voter',
                'read region',
                'read master',
                'log_activity config',
                'personalization'
            ]);

        Role::create(['name' => 'Koordinator Keluarga'])
            ->givePermissionTo([
                'show voter',
                'read voter',
                'read region',
                'read master',
                'log_activity config',
                'personalization'
            ]);

        Role::create(['name' => 'Tim Bersinar'])
            ->givePermissionTo([
                'show voter',
                'read voter',
                'read region',
                'read master',
                'log_activity config',
                'personalization'
            ]);
    }
}
