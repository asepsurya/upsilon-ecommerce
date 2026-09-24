<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Log::info('Contact form submission', $validated);

        if (class_exists(ContactMail::class)) {
            Mail::to(config('mail.from.address'))->send(new ContactMail($validated));
        }

        return back()->with('success', 'Thank you for contacting us. We will get back to you soon.');
    }
}
