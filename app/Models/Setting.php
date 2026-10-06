<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'description'];

    protected $casts = [
        'value' => 'string',
    ];

    protected static $symbol = null;

    protected static $decimals = null;

    public function scopeKey(Builder $query, string $key): Builder
    {
        return $query->where('key', $key);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    public static function currencySymbol(): string
    {
        if (static::$symbol === null) {
            static::$symbol = static::get('currency_symbol', '$') ?: '$';
        }

        return static::$symbol;
    }

    public static function currencyDecimals(): int
    {
        if (static::$decimals === null) {
            static::$decimals = static::get('currency_decimals', 2);
        }

        return static::$decimals;
    }

    public static function set(string $key, mixed $value, string $type = 'text', ?string $description = null): void
    {
        $casted = match ($type) {
            'boolean' => (string) (bool) $value,
            'integer' => (string) (int) $value,
            'json' => json_encode($value),
            default => (string) $value,
        };

        static::updateOrCreate(
            ['key' => $key],
            ['value' => $casted, 'type' => $type, 'description' => $description]
        );

        // Clear static cache for currency settings
        if ($key === 'currency_symbol') {
            static::$symbol = null;
        }
        if ($key === 'currency_decimals') {
            static::$decimals = null;
        }
    }
}
