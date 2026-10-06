<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Share contact/social settings globally
        View::composer('*', function ($view) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();

            $view->with('siteSettings', [
                'app_name' => $settings['app_name'] ?? config('app.name', 'Upsilon'),
                'currency_symbol' => $settings['currency_symbol'] ?? '$',
                'currency_decimals' => (int) ($settings['currency_decimals'] ?? 2),
                'contact_email' => $settings['contact_email'] ?? '',
                'contact_phone' => $settings['contact_phone'] ?? '',
                'contact_address' => $settings['contact_address'] ?? '',
                'google_maps_embed' => $settings['google_maps_embed'] ?? '',
                'social_instagram' => $settings['social_instagram'] ?? '',
                'social_facebook' => $settings['social_facebook'] ?? '',
                'social_twitter' => $settings['social_twitter'] ?? '',
                'social_tiktok' => $settings['social_tiktok'] ?? '',
                'social_youtube' => $settings['social_youtube'] ?? '',
                'social_linkedin' => $settings['social_linkedin'] ?? '',
                'whatsapp_number' => $settings['whatsapp_number'] ?? config('services.whatsapp.number', ''),
                'whatsapp_default_message' => $settings['whatsapp_default_message'] ?? config('services.whatsapp.default_message', ''),
                'checkout_mode' => $settings['checkout_mode'] ?? 'midtrans',
                'midtrans_client_key' => $settings['midtrans_client_key'] ?? config('services.midtrans.client_key', ''),
                'midtrans_environment' => $settings['midtrans_environment'] ?? 'sandbox',
            ]);
        });
    }
}
