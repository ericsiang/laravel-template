<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::transaction(function () use ($i) {
                $user = User::create([
                    'name' => 'test_user_' . $i,
                    // 'email' => 'test_' . $i . '@example.com',
                    'line_id' => 'test_line_id' . $i,
                ]);
                // $token = $user->createToken('apiToken')->plainTextToken;
                $platinum = 0;
                $gold = 0;
                $diamond = 0;
                foreach (Role::all() as $role) {
                    if ($role->name == 'platinum') {
                        $platinum = $role->id;
                    } elseif ($role->name == 'gold') {
                        $gold = $role->id;
                    } elseif ($role->name == 'diamond') {
                        $diamond = $role->id;
                    }
                }
                if ($i % 3 == 0) {
                    $user->assignRole([$platinum]);
                } elseif ($i % 3 == 1) {
                    $user->assignRole([$gold]);
                } elseif ($i % 3 == 2) {
                    $user->assignRole([$diamond]);
                }
            });
        }
    }
}
