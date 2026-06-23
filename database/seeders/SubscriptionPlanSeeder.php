<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['name' => '1 Month',   'duration_days' => 30,  'price' => 2500, 'sort_order' => 1],
            ['name' => '6 Months',  'duration_days' => 180, 'price' => 4500, 'sort_order' => 2],
            ['name' => '12 Months', 'duration_days' => 365, 'price' => 6500, 'sort_order' => 3],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::query()->updateOrCreate(
                ['duration_days' => $plan['duration_days']],
                [
                    'name'       => $plan['name'],
                    'price'      => $plan['price'],
                    'status'     => 'active',
                    'sort_order' => $plan['sort_order'],
                ]
            );
        }
    }
}
