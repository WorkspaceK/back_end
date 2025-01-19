<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicRankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('academic_ranks')->insert([
            [
                'code' => '1',
                'name' => 'GS',
                'description' => 'Giáo sư',
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '2',
                'name' => 'PGS',
                'description' => 'Phó giáo sư',
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        }
}
