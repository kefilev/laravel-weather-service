<?php

use App\Http\Controllers\EmailSubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(EmailSubscriberController::class)->group(function () {
    Route::get('/subscribe', 'subscribe'); //use get to let users subscribe even from the browser
    Route::get('/unsubscribe', 'unsubscribe'); //using get to let users unsubscribe by visiting a link
}); //->middleware('auth:sanctum')
