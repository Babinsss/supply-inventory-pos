<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'ICT Section'],
            ['name' => 'Accounting Section'],
            ['name' => 'Male Medical Ward'],
            ['name' => 'Female Medical Ward'],
            ['name' => 'OB-Gyne Ward'],
            ['name' => 'Surgical Ward'],
            ['name' => 'ICU Ward'],
            ['name' => 'NICU'],
            ['name' => 'Orthopedic Ward'],
            ['name' => 'Dialysis Unit'],
            ['name' => 'Pediatric Ward'],
            ['name' => 'Veterans Ward'],
            ['name' => 'Labor Room & Delivery Room'],
            ['name' => 'Operating Room (OR)'],
            ['name' => 'Human Resource (HR)'],
            ['name' => 'Emergency Room (ER)'],
            ['name' => 'Pharmacy'],
            ['name' => 'Laboratory'],
            ['name' => 'Dietary'],
            ['name' => 'Radiology'],
            ['name' => 'Medical Records'],
            ['name' => 'Cashier'],
            ['name' => 'Outpatient Department (OPD)'],
            ['name' => 'Physical Therapy'],
            ['name' => 'Maintenance'],
            ['name' => 'Housekeeping'],
            ['name' => 'Security'],
            ['name' => 'NSO Office'],
            ['name' => 'Chief of Hospital I'],
            ['name' => 'Chief of Hospital II'],
            ['name' => 'Quality Management Office'],
            ['name' => 'Infection Control'],
            ['name' => 'Malasakit Center'],
            ['name' => 'Building & Maintenance Office'],
            ['name' => 'Credit & Collection Office'],
            ['name' => 'Billing and Claims Department'],
        ];

        DB::table('departments')->insert($departments);
    }
}