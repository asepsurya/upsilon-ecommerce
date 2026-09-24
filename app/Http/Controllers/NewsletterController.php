<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ]);

        NewsletterSubscription::create(['email' => $validated['email']]);

        Cache::forget('newsletter_count');

        return back()->with('success', 'Successfully subscribed to newsletter.');
    }
}
