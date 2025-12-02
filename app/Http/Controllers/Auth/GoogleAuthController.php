<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Update Google ID if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                }

                // Only allow customer role to login with Google
                if ($user->role !== 'customer') {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Akun ini tidak dapat login menggunakan Google. Silakan gunakan email dan password.',
                    ]);
                }
            } else {
                // Create new customer user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'role' => 'customer',
                    'email_verified_at' => now(),
                    'password' => bcrypt(str()->random(32)), // Random password since using Google
                ]);
            }

            Auth::login($user, true);

            return redirect()->route('homepage');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.',
            ]);
        }
    }
}

