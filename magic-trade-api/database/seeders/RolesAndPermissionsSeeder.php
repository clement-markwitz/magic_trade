<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name'=> 'me']);
        Permission::create(['name'=> 'add card']);
        Permission::create(['name'=> 'show card']);
        Permission::create(['name'=> 'my cards']);
        Permission::create(['name'=> 'show by user card']);
        Permission::create(['name'=> 'update card']);
        Permission::create(['name'=> 'delete card']);
        Permission::create(['name'=> 'update user card']);
        Permission::create(['name'=> 'delete user card']);
        Permission::create(['name'=> 'list clients']);
        Permission::create(['name'=> 'show client']);
        Permission::create(['name'=> 'update client']);
        Permission::create(['name'=> 'delete client']);
        Permission::create(['name'=> 'list trades']);
        Permission::create(['name'=> 'create trade']);
        Permission::create(['name'=> 'show trade']);
        Permission::create(['name'=> 'update trade']);
        Permission::create(['name'=> 'delete trade']);
        Permission::create(['name'=> 'list trade items']);
        Permission::create(['name'=> 'create trade item']);
        Permission::create(['name'=>'update trade item']);
        Permission::create(['name'=> 'delete trade item']);

        Role::create(['name'=> 'admin'])->givePermissionTo('me');
        Role::create(['name'=> 'client'])->givePermissionTo(['me','add card','show card',
    'my cards','show by user card','update card','delete card','update user card','delete user card','update client','list trades','create trade','show trade','update trade',
'delete trade','list trade items','create trade item','update trade item','delete trade item']);
    }
}
