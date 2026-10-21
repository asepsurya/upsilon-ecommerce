<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Share contact/social settings globally
        View::composer('*', function ($view) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();

            $view->with('siteSettings', [
                'app_name' => $settings['app_name'] ?? config('app.name', 'Upsilon'),
                'tagline' => $settings['tagline'] ?? '',
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
                'whatsapp_number' => config('services.whatsapp.number', ''),
                'whatsapp_default_message' => config('services.whatsapp.default_message', ''),
                'checkout_mode' => $settings['checkout_mode'] ?? 'midtrans',
                'midtrans_client_key' => $settings['midtrans_client_key'] ?? config('services.midtrans.client_key', ''),
                'midtrans_environment' => $settings['midtrans_environment'] ?? 'sandbox',
                'about_hero_badge' => $settings['about_hero_badge'] ?? 'UPSILON ATELIER // EST. 2025',
                'about_hero_meta_left' => $settings['about_hero_meta_left'] ?? 'MINIMALIST ELEGANCE',
                'about_hero_meta_right' => $settings['about_hero_meta_right'] ?? 'EMBROIDERED CRAFTSMANSHIP',
                'about_hero_manifesto' => $settings['about_hero_manifesto'] ?? 'OUR MANIFESTO',
                'about_hero_headline' => $settings['about_hero_headline'] ?? "Engineered With\nRadical Precision\nDefined By Form",
                'about_hero_lead' => $settings['about_hero_lead'] ?? 'Upsilon was founded on a singular principle: to redefine everyday essential wear through uncompromising fabric selection, ergonomic silhouette engineering, and intricate computer-embroidered details.',
                'about_factory_title' => $settings['about_factory_title'] ?? 'Our Factory',
                'about_factory_description' => $settings['about_factory_description'] ?? 'At Upsilon, we blend tradition with cutting-edge technology in our state-of-the-art manufacturing facility. Every garment is crafted with meticulous attention to detail, ensuring lasting quality and sustainability.',
                'about_philosophy_title' => $settings['about_philosophy_title'] ?? 'The Philosophy Behind The Upsilon Symbol',
                'about_philosophy_description' => $settings['about_philosophy_description'] ?? 'The Greek letter Upsilon (Υ) represents branching paths, decision points, and the pursuit of excellence. In our garment design, it symbolizes the choice to reject disposable fast fashion in favor of timeless structural integrity and refined aesthetics. Every piece crafted under the Upsilon emblem is built to empower individuals who navigate life with intention, quiet confidence, and unyielding self-expression.',
                'about_pillars_title' => $settings['about_pillars_title'] ?? 'Three Pillars Of Excellence',
                'about_pillars_subtitle' => $settings['about_pillars_subtitle'] ?? 'Why Upsilon garments deliver unparalleled comfort, drape, and durability.',
                'about_cta_title' => $settings['about_cta_title'] ?? 'Elevate Your Daily Style',
                'about_cta_description' => $settings['about_cta_description'] ?? 'Discover the difference of precision embroidery and 100% combed cotton. Step out in confidence with Upsilon.',
                'about_cta_button_text' => $settings['about_cta_button_text'] ?? 'Explore Collection',
            ]);
        });
    }
}
