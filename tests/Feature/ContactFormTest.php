<?php

namespace Tests\Feature;

use App\Mail\ContactMail;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_sends_to_settings_contact_email(): void
    {
        Setting::set('contact_email', 'cs@tokoanda.test');

        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Mail::assertSent(ContactMail::class, function ($mail) {
            return $mail->hasTo('cs@tokoanda.test');
        });
    }

    public function test_contact_form_falls_back_to_mail_from_address(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message',
        ]);

        $response->assertRedirect();

        Mail::assertSent(ContactMail::class, function ($mail) {
            return $mail->hasTo(config('mail.from.address'));
        });
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }
}
