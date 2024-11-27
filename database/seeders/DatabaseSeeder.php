<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $f1 = DB::table('floors')->insertGetId(['name' => 'Lantai 1']);
        $f2 = DB::table('floors')->insertGetId(['name' => 'Lantai 2']);
        $f3 = DB::table('floors')->insertGetId(['name' => 'Lantai 3']);

        DB::table('rooms')->insert(['floor_id' => $f1, 'name' => 'Ruangan 101']);
        DB::table('rooms')->insert(['floor_id' => $f1, 'name' => 'Ruangan 102']);
        DB::table('rooms')->insert(['floor_id' => $f2, 'name' => 'Ruangan 201']);
        DB::table('rooms')->insert(['floor_id' => $f2, 'name' => 'Ruangan 202']);
        DB::table('rooms')->insert(['floor_id' => $f3, 'name' => 'Ruangan 301']);
        DB::table('rooms')->insert(['floor_id' => $f3, 'name' => 'Ruangan 302']);

        DB::table('bookingperiods')->insert(['name' => '09:00 s.d 12:00']);
        DB::table('bookingperiods')->insert(['name' => '13:00 s.d 16:00']);
    }
}
