<?php

use App\Filament\User\Pages\Auth\OtpCode;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/user/otp-code', OtpCode::class)->name('otp_code');
