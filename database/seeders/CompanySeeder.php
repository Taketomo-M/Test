<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create(['name' => 'ソニー']);
        Company::create(['name' => 'パナソニック']);
        Company::create(['name' => '東芝']);
    }
}
