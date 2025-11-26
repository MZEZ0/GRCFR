<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Company;
use App\Models\Policy;
use App\Models\Risk;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first();

        if (! $company) {
            return;
        }

        $user = User::first();

        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
            ]);
        }

        $statuses = ['compliant', 'partial', 'non_compliant'];
        $policies = Policy::inRandomOrder()->take(12)->get();

        foreach ($policies as $policy) {
            Assessment::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'company_id' => $company->id,
                    'policy_id' => $policy->id,
                ],
                [
                    'status' => $statuses[array_rand($statuses)],
                    'notes' => 'Initial demo assessment',
                ]
            );
        }

        $riskAdjustments = [
            ['code' => 'R4', 'likelihood' => 2, 'impact' => 2, 'residual_level' => 'Low'],
            ['code' => 'R8', 'likelihood' => 2, 'impact' => 3, 'residual_level' => 'Low'],
            ['code' => 'R15', 'likelihood' => 3, 'impact' => 3, 'residual_level' => 'Medium'],
            ['code' => 'R21', 'likelihood' => 2, 'impact' => 3, 'residual_level' => 'Low'],
            ['code' => 'R22', 'likelihood' => 3, 'impact' => 5, 'residual_level' => 'High'],
        ];

        foreach ($riskAdjustments as $adjustment) {
            Risk::where('code', $adjustment['code'])->update([
                'likelihood' => $adjustment['likelihood'],
                'impact' => $adjustment['impact'],
                'residual_level' => $adjustment['residual_level'],
                'score' => $adjustment['likelihood'] * $adjustment['impact'],
            ]);
        }
    }
}
