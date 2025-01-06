<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function logo()
    {
        $user = Auth::user();
        $logo = Storage::get('logos/' . $user->logo);
        return response($logo);
    }
}
