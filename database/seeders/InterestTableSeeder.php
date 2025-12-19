<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('interests')->insert([
            [
               'name' => 'Entertainment' 
            ],
            [
                'name' => 'Sports & Fitness'
            ],
            [
                'name' => 'Food & Drink'
            ],
            [
                'name' => 'Travel'
            ],
            [
                'name' => 'Education & Learning'
            ],
            [
                'name' => 'Technology'
            ],
            [
                'name' => 'Fashion & Beauty'
            ],
            [
                'name' => 'Business & Finance'
            ],
            [
                'name' => 'Art & Design'
            ],
            [
                'name' => 'Lifestyle & Wellness'
            ],
            [
                'name' => 'Family & Relationships'
            ],
            [
                'name' => 'Gaming'
            ],
            [
                'name' => 'Social Causes'
            ],
            [
                'name' => 'Shopping & Deals'
            ],
            [
                'name' => 'Pets & Animals'
            ],
            [
                'name' => 'Books & Literature'
            ]

            ,[
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
                


        ]);
    }
}
