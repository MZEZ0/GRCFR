<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\AdminUserSeeder;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        $this->call([
            RolesSeeder::class,
            AdminUserSeeder::class,
            SmeBaselineSeeder::class,
            CompanySeeder::class,
            QuestionnaireSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
