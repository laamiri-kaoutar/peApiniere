<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run(): void
     {
         DB::table('roles')->insert([
             ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'client', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'employe', 'created_at' => now(), 'updated_at' => now()],

         ]);
     }
}
