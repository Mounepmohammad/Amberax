<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class static_db extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            ['name' => 'admin','email' => 'admin@gmail.com','password' => bcrypt('admin123')],
           // ['name' => 'labman','email' => 'labman@gmail.com','password' => bcrypt('labman123'),'role' => '2'],
                  ]);
    }
}
