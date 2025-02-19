<?php

use App\Filament\Pages\PendingApproval;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\SessionRevocationController;

Route::get('/', function () {
    return redirect('/app');
});

// Route::get('/logout-session/{session_id}', [SessionRevocationController::class, 'revoke'])
//     ->name('logout.session');

Route::get('/auth/google', [SocialLoginController::class, 'redirectToProvider'])->name('auth.google');
Route::get('/auth/google/callback', [SocialLoginController::class, 'socialCallback']);

Route::get('/pending-approval', PendingApproval::class)->name('pending-approval');

