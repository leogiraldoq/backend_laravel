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
            ],
            [
                "name" => "Store name hide",
            ],
            [
                "name" => "Carelabel",
            ],
            [
                "name" => "Label prepare",
            ],
            [
                "name" => "Bagging",
            ],
            [
                "name" => "Handtag",
            ]
        ]);
    }
}
