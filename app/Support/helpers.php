<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::query()->where('key', $key)->value('value') ?? $default;
    }
}

if (! function_exists('pkr')) {
    function pkr(int|float|string $amount): string
    {
        return 'PKR '.number_format((float) $amount, 0);
    }
}
