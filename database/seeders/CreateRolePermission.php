<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // user role
        $role_platinum = Role::create(['name' => 'Super Admin']);
        $role_platinum = Role::create(['name' => 'platinum']);
        $role_gold = Role::create(['name' => 'gold']);
        $role_diamond = Role::create(['name' => 'diamond']);

        // user permission
        $permission_birth = Permission::create(['name' => 'birth gift']);
        $permission_early = Permission::create(['name' => 'early check in']);
        $permission_late = Permission::create(['name' => 'late check out']);
        $permission_local = Permission::create(['name' => 'local call service']);
        $permission_free = Permission::create(['name' => 'free flow of drinks']);
        $permission_parking = Permission::create(['name' => 'parking service']);
        $permission_high_net = Permission::create(['name' => 'high speed internet']);
        $permission_two_water = Permission::create(['name' => 'two bottles of mineral water']);
        $permission_living = Permission::create(['name' => 'living']);
        $permission_room_upgrade = Permission::create(['name' => 'room type upgrade']);
        $permission_catering = Permission::create(['name' => 'catering consumption']);
        $permission_lounge = Permission::create(['name' => 'lounge access']);
        $permission_member_only_price = Permission::create(['name' => 'member only price']);
        $permission_24_hour = Permission::create(['name' => '24 hour dedicated service']);
        $permission_personal_butler = Permission::create(['name' => 'personal butler service']);

        // role has permission
        $free_permsssion = [$permission_birth, $permission_early, $permission_late, $permission_local, $permission_free, $permission_parking, $permission_high_net, $permission_two_water];

        $role_platinum->givePermissionTo($free_permsssion);
        $role_gold->givePermissionTo($free_permsssion, $permission_living, $permission_catering);
        $role_diamond->givePermissionTo($free_permsssion, $permission_living, $permission_catering, $permission_room_upgrade, $permission_lounge, $permission_member_only_price, $permission_24_hour, $permission_personal_butler);

        //admin
    }
}
