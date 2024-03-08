<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessAddWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('process_add_work')->insert([
            [
                "name" => "Prepare Branch",
                "cost" => 0,
            ],
            [
                "name" => "Store name hide",
                "cost" => 0,
            ],
            [
                "name" => "Carelabel",
                "cost" => 0,
            ],
            [
                "name" => "Label prepare",
                "cost" => 0,
            ],
            [
                "name" => "Bagging",
                "cost" => 0,
            ],
            [
                "name" => "Handtag",
                "cost" => 0,
            ]
        ]);
    }
}
