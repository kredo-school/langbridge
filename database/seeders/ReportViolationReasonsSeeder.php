<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportViolationReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * 
     * 
     */
    public function run(): void
    {

        DB::table('report_violation_reasons')->insert([
            // --- user category ---
            [
                'category' => 'user',
                'name' => 'Inappropriate or false information'
            ],
            [
                'category' => 'user',
                'name' => 'External links or social media promotion'
            ],
            [
                'category' => 'user',
                'name' => 'Self-promotion or solicitation'
            ],
            [
                'category' => 'user',
                'name' => 'Offensive or inappropriate language'
            ],
            [
                'category' => 'user',
                'name' => 'Other'
            ],

            // --- chat category ---
            [
                'category' => 'chat',
                'name' => 'Content unrelated to language exchange'
            ],
            [
                'category' => 'chat',
                'name' => 'Offensive or aggressive remarks'
            ],
            [
                'category' => 'chat',
                'name' => 'Solicitation, promotion, or spam'
            ],
            [
                'category' => 'chat',
                'name' => 'Sending inappropriate images or links'
            ],
            [
                'category' => 'chat',
                'name' => 'Other'
            ],
        ]);
    }
}
