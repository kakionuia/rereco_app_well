<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;

class GuestVerifyEmailController extends Controller
{
    /**
     * Handle email verification clicks for guests (link from email).
     * This allows the verification link to work even if the user isn't
     * actively logged in when they click the email link.
     */
    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
        // Ensure URL signature is valid
        if (! $request->hasValidSignature()) {
            abort(403, 'This action is unauthorized.');
        }

        $user = User::findOrFail($id);

        // verify hash matches user's email
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'This action is unauthorized.');
        }

        if ($user->hasVerifiedEmail()) {
            // Ensure the session corresponds to this user: if someone else is
            // logged in (e.g. admin), switch to the verified user so they land
            // in their own account.
            if (auth()->check() && auth()->id() !== $user->id) {
                auth()->logout();
                auth()->loginUsingId($user->id);
                request()->session()->regenerate();
            }

            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        // Log out current user (if any) and log in the verified user to
        // ensure the session belongs to them.
        if (auth()->check() && auth()->id() !== $user->id) {
            auth()->logout();
        }

        auth()->loginUsingId($user->id);
        request()->session()->regenerate();

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
