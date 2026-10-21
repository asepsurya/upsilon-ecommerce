<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin Upsilon',
            'email' => 'admin@tokoanda.test',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);
    }

    public function test_settings_page_renders_grouped_sections_from_schema(): void
    {
        $response = $this->actingAs($this->admin())->get(route('admin.settings.index'));

        $response->assertOk();

        foreach (config('settings.groups') as $groupKey => $group) {
            $response->assertSee($group['label']);
            $response->assertSee('data-settings-group="'.$groupKey.'"', false);
            $response->assertSee($group['description']);
        }
    }

    public function test_settings_page_shows_stored_values_and_hints(): void
    {
        Setting::set('app_name', 'Toko Sepatku');
        Setting::set('currency_symbol', 'Rp');

        $response = $this->actingAs($this->admin())->get(route('admin.settings.index'));

        $response->assertOk();
        $response->assertSee('Toko Sepatku');
        $response->assertSee('Rp');
        $response->assertSee(config('settings.groups')['currency']['fields']['currency_decimals']['hint']);
    }

    public function test_settings_can_be_saved_with_schema_types(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.settings.update'), [
            'app_name' => 'Upsilon Official',
            'tagline' => 'Minimalist elegance. Refined craftsmanship.',
            'currency_symbol' => 'Rp',
            'currency_decimals' => '0',
            'contact_email' => 'cs@tokoanda.com',
            'instagram_cache_ttl' => '900',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $response->assertSessionHas('success');

        $this->assertSame('Upsilon Official', Setting::get('app_name'));
        $this->assertSame('Minimalist elegance. Refined craftsmanship.', Setting::get('tagline'));
        $this->assertSame('Rp', Setting::get('currency_symbol'));
        $this->assertSame(0, Setting::get('currency_decimals'));
        $this->assertSame('cs@tokoanda.com', Setting::get('contact_email'));
        $this->assertSame(900, Setting::get('instagram_cache_ttl'));
    }

    public function test_settings_page_renders_tagline_field(): void
    {
        Setting::set('tagline', 'Crafted with precision.');

        $response = $this->actingAs($this->admin())->get(route('admin.settings.index'));

        $response->assertOk();
        $response->assertSee(config('settings.groups')['general']['fields']['tagline']['label']);
        $response->assertSee('Crafted with precision.');
    }

    public function test_settings_validation_rejects_invalid_values_per_field(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.settings.update'), [
            'currency_symbol' => str_repeat('x', 20),
            'currency_decimals' => '9',
            'contact_email' => 'bukan-email',
            'social_instagram' => 'instagram.com/toko',
            'instagram_cache_ttl' => '-5',
        ]);

        $response->assertSessionHasErrors([
            'currency_symbol',
            'currency_decimals',
            'contact_email',
            'social_instagram',
            'instagram_cache_ttl',
        ]);

        $this->assertSame(0, Setting::where('key', 'currency_decimals')->count());
    }

    public function test_unknown_setting_keys_are_ignored(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.settings.update'), [
            'app_name' => 'Aman',
            'is_admin' => '1',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertSame('Aman', Setting::get('app_name'));
        $this->assertSame(0, Setting::where('key', 'is_admin')->count());
    }

    public function test_whatsapp_settings_are_written_to_env_not_database(): void
    {
        $envPath = base_path('.env');
        $originalEnv = file_get_contents($envPath);

        try {
            $response = $this->actingAs($this->admin())->post(route('admin.settings.update'), [
                'whatsapp_number' => '6282212345678',
                'whatsapp_default_message' => 'Halo, saya inginkan bertanya.',
            ]);

            $response->assertRedirect(route('admin.settings.index'));
            $response->assertSessionHas('success');

            $this->assertNull(Setting::where('key', 'whatsapp_number')->first());
            $this->assertNull(Setting::where('key', 'whatsapp_default_message')->first());

            $envContent = file_get_contents($envPath);
            $this->assertStringContainsString('WHATSAPP_NUMBER="6282212345678"', $envContent);
            $this->assertStringContainsString('WHATSAPP_DEFAULT_MESSAGE="Halo, saya inginkan bertanya."', $envContent);
        } finally {
            file_put_contents($envPath, $originalEnv);
        }
    }
}
