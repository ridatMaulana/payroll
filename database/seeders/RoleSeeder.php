<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'nama' => 'Direktur'],
            ['id' => 2, 'nama' => 'Admin'],
            ['id' => 3, 'nama' => 'Karyawan'],
        ]);
    }
}
