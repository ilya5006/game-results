<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MemberSeeder extends Seeder
{
    private const ROWS_COUNT = 10000;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [];

        for ($i = 0; $i < self::ROWS_COUNT; $i++) {
            $rows[] = [
                'email' => Str::random(random_int(10, 20)).'@example.com',
            ];
        }

        DB::table('Member')->insert($rows);
    }
}
