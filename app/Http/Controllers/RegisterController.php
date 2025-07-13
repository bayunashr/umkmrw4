<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:4|max:32|unique:users,username',
            'password' => 'required|string|confirmed|min:6',
            'name' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180',
        ]);

        $user = User::create([
            'name' => $validated['owner'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 1,
        ]);

        $slug = generate_unique_slug('profiles', 'slug', $validated['name']);

        $user->profile()->create([
            'name' => $validated['name'],
            'slug' => $slug,
            'phone' => $validated['phone'],
            'latitude' => $validated['lat'],
            'longitude' => $validated['lon'],
        ]);


        Auth::login($user);

        return redirect()->route('approval.waiting');
    }
}
