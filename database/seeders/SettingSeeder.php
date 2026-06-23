<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name'             => 'Noor-e-Quran Scholars Academy',
            'jazzcash_number'       => '03XX-XXXXXXX',
            'jazzcash_account_name' => 'Noor-e-Quran Scholars Academy',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
