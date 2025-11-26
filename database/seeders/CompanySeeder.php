<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::updateOrCreate(
            ['name' => 'Demo SME Co.'],
            [
                'sector' => 'Retail / Services',
                'size' => 'SME',
                'country' => 'Jordan',
                'contact_person' => 'Security Manager',
                'contact_email' => 'security@demo-sme.com',
            ]
        );
    }
}
