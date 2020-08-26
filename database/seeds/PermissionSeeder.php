<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Permission::create(['name' => 'edit internal', 'guard_name' => 'internal']);
        Permission::create(['name' => 'delete internal', 'guard_name' => 'internal']);
        Permission::create(['name' => 'create internal', 'guard_name' => 'internal']);

    }
}
