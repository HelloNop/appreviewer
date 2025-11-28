<?php

use App\Http\Controllers\PublicProfile;
use App\Livewire\FormCall;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/call-reviewer-editor', FormCall::class);

Route::get('academic-profile/{user:uuid}', [PublicProfile::class, 'publicProfile'])->name('public-profile');
