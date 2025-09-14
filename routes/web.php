<?php

use App\Livewire\FormCall;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/call-reviewer-editor', FormCall::class);