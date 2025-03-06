<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/subscribe/{email}/{location}', function (Request $request, string $email, string $location) {
    return $email . ' ' . $location;
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
