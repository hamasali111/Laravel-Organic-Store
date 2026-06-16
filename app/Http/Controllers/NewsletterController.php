<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'name'  => 'nullable|string|max:100',
        ]);

        NewsletterSubscriber::firstOrCreate(
            ['email' => strtolower(trim($request->email))],
            ['name' => $request->name, 'active' => true]
        );

        return redirect()->back()->with('newsletter_success', 'Thank you for subscribing! 🌱');
    }
}
