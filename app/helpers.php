<?php

use App\Models\Setting;

if (! function_exists('currency_format')) {
    function currency_format(float|int|null $amount, ?int $decimals = null): string
    {
        if ($amount === null) {
            return '';
        }

        $decimals ??= Setting::currencyDecimals();
        $symbol = Setting::currencySymbol();

        $formatted = number_format((float) $amount, $decimals, '.', ',');

        return $symbol.$formatted;
    }
}

if (! function_exists('currency_symbol')) {
    function currency_symbol(): string
    {
        return Setting::currencySymbol();
    }
}

if (! function_exists('currency_decimals')) {
    function currency_decimals(): int
    {
        return Setting::currencyDecimals();
    }
}
