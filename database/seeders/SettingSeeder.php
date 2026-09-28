<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'app_name', 'value' => 'Upsilon', 'type' => 'text', 'description' => 'Application name'],
            ['key' => 'app_url', 'value' => config('app.url', 'http://localhost'), 'type' => 'text', 'description' => 'Application URL'],
            ['key' => 'mail_from_address', 'value' => 'noreply@upsilon.com', 'type' => 'text', 'description' => 'Mail from address'],
            ['key' => 'mail_from_name', 'value' => 'Upsilon', 'type' => 'text', 'description' => 'Mail from name'],
            ['key' => 'whatsapp_number', 'value' => '6281234567890', 'type' => 'text', 'description' => 'WhatsApp number'],
            ['key' => 'whatsapp_default_message', 'value' => 'Hello, I need help with my order.', 'type' => 'text', 'description' => 'Default WhatsApp message'],
            ['key' => 'instagram_account_id', 'value' => '', 'type' => 'text', 'description' => 'Instagram account ID'],
            ['key' => 'instagram_access_token', 'value' => '', 'type' => 'text', 'description' => 'Instagram access token'],
            ['key' => 'instagram_api_version', 'value' => 'v22.0', 'type' => 'text', 'description' => 'Instagram API version'],
            ['key' => 'instagram_api_base_url', 'value' => 'https://graph.facebook.com', 'type' => 'text', 'description' => 'Instagram API base URL'],
            ['key' => 'instagram_cache_ttl', 'value' => '3600', 'type' => 'integer', 'description' => 'Instagram cache TTL in seconds'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
