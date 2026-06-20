<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Qalam Academy',
            'jazzcash_number' => '03XX-XXXXXXX',
            'jazzcash_account_name' => 'Qalam Academy',
            'basic_plan_price' => '2500',
            'standard_plan_price' => '4500',
            'premium_plan_price' => '6500',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
