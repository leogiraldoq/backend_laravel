<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            "names" => "Leonardo",
	        "last_names" => "Giraldo",
	        "phone" => "+15628441437",
	        "email" => "giraldoquinteroleo@gmail.com",
            "title" => "Developer",
            "address" => "12345 Goodhue ST",
	        "city" => "Los Angeles",
            "postal_code" => "90023",
	        "birth" =>"1984-10-04"
        ]);
    }
}
