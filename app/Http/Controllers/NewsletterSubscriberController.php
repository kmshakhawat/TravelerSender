<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterSubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        try {
            $subscriber = NewsletterSubscriber::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'subscribed_at' => now(),
                ]
            );

            if (!$subscriber->wasRecentlyCreated) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'You are already subscribed to our newsletter',
                ], 400);
            }

            $commonData = [
                'name' => $request->name,
                'email' => $request->email,
                'subscribed_at' => now(),
            ];

            $emailConfigs = [
                config('app.admin.email') => [
                    'subject' => 'New Newsletter Subscription Alert!',
                    'template' => 'emails.admin.newsletter-subscription',
                ],
                $request->email => [
                    'subject' => 'Welcome to '. config('app.name') .'s Newsletter!',
                    'template' => 'emails.newsletter-subscription',
                ]
            ];

            foreach ($emailConfigs as $recipient => $config) {
                $mailData = array_merge($commonData, $config);
                Mail::to($recipient)->send(new SendMail($mailData));
            }

            return new JsonResponse([
                'status' => 'success',
                'message' => 'Thank you for subscribing to our newsletter',
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Failed to subscribe to our newsletter',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsletterSubscriber $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsletterSubscriber $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsletterSubscriber $newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsletterSubscriber $newsletter)
    {
        //
    }
}
