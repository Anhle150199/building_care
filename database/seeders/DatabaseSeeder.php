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
        // DB::table('departments')->insert([
        //     'name' => 'Chăm sóc khách hàng',
        //     "created_at"=>now(),
        //     'updated_at'=>now()
        // ]);
        DB::table('admins')->insert([
            'name' => 'Super Admin 1',
            'email' => 'aefreete@aefreetemplates.com',
            'password' => Hash::make('12345678'),
            'department_id' => '2',
            'role' =>'super',
            "position" => "Trưởng bộ phận",
            "avatar" => "avatar-1.png",
            "created_at"=>now(),
            'updated_at'=>now()

        ]);
    }
}
