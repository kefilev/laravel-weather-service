<?php

namespace App\Http\Controllers;

use App\Jobs\NewSubscriberMailJob;
use App\Models\EmailSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailSubscriberController extends Controller
{
    public function subscribe(Request $request) {
        try {
            //Validate params
            $validated = $request->validate([
                'email' => 'bail|required||email:rfc,dns|unique:email_subscribers',
                'location' => 'required|string',
            ]);

            //Save to DB
            $subscriber = new EmailSubscriber();
            $subscriber->email = $request->query('email');
            $subscriber->location = $request->query('location');
            $saved = $subscriber->save();

            //Schedule a notification email to let the subscriber know that he has subscibed
            //TODO
            if ($saved) {
                NewSubscriberMailJob::dispatch($subscriber);
            }

        } catch (\Exception $e) {
            // return eror
            return response()->json(['error' => $e->getMessage()], 400);
        }

        //Return OK
        return response()->json(['success' => "You have successfully subscribed your email - {$validated['email']} for the daily weather report"], 200);
    }

    
    public function unsubscribe(Request $request) {
        try {
            //Validate params
            $validated = $request->validate([
                'email' => 'bail|required||email:rfc,dns|exists:email_subscribers'
            ]);

            //forceDelete from DB the unsubscribed users
            EmailSubscriber::where('email', $validated['email'])->forceDelete();

            //Schedule a notification to let the subscriber know that he is no longer a subscriber
            //TODO
        } catch (\Exception $e) {
            // return eror
            return response()->json(['error' => $e->getMessage()], 400);
        }

        //Return OK
        return response()->json(['success' => "You have successfully unsubscribed your email - {$validated['email']} from the daily weather report"], 200);
    }
}
