<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');


Route::middleware('auth:api')->post('/booking', App\Http\Controllers\Api\BookingController::class)->name('booking');
Route::middleware('auth:api')->post('/attendant', App\Http\Controllers\Api\AttendantController::class)->name('attendant');
Route::middleware('auth:api')->get('/memo/{booking_id}', [App\Http\Controllers\Api\MemoController::class, 'get'])->name('memo');
Route::middleware('auth:api')->put('/memo', [App\Http\Controllers\Api\MemoController::class, 'put'])->name('memo');

// Route::fallback(function () {
//     return response()->json([
//         'status'    => false,
//         'message'   => 'Page Not Found.',
//     ], 404);
// });
