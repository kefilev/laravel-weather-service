<?php

use App\Http\Requests\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->name('verification.verify');
// })->middleware(['auth', 'signed'])->name('verification.verify');