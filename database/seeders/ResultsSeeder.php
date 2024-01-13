<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ResultsSeeder extends Seeder
{
    private const ROWS_COUNT = 10000;
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [];

        $ids = DB::table('members')
            ->select('id')
            ->get()
            ->toArray();

        for ($i = 0; $i < self::ROWS_COUNT; $i++) {
            $memberId = $ids[random_int(0, count($ids) - 1)]->id;

            $rows[] = [
                'member_id' => $memberId,
                'milliseconds' => random_int(1000, 15000)
            ];
        }

        DB::table('results')->insert($rows);
    }
}
