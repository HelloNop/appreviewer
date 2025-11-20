<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\User;
use Illuminate\Http\Request;

class PublicProfile extends Controller
{
    public function publicProfile(User $user)
    {
        if (!$user) {
            abort(404, 'Profile not found.');
        }
        
        return view('public_profile', compact('user'));
    }
}
