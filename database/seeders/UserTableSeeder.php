<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => '田中太郎',
            'email' => 'tarotaro@gmail.com',
            'password' => '12345678',
            'birthday' => '',
            'target_language' => 'en',
            'country' => '日本',
            'region' => '東京',
        ]);
    }
}
