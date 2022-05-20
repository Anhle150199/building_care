<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('departments')->insert([
            'name' => 'Chăm sóc khách hàng',
            "created_at"=>now(),
            'updated_at'=>now()
        ]);
        DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'anhle150199@gmail.com',
            'password' => Hash::make('superAdmin'),
            'department_id' => '1',
            "position" => "Nhân viên tiếp nhận",
            "avatar" => "avatar-1.png",
            "created_at"=>now(),
            'updated_at'=>now()

        ]);
    }
}
