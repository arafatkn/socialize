<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * User Login Page.
     *
     * @return \Inertia\Response
     */
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * User Login.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'required',
            'remember' => 'boolean',
        ]);

        if (!auth()->attempt($request->only(['email', 'password', 'remember']))) {
            return back()->withErrors(['message' => 'Email or Password is incorrect']);
        }

        $user = auth()->user();

        return redirect($user->dashboard_url)->with([
            'success' => 'You have been logged in successfully.',
        ]);
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * User Registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerAction(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|max:255',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6|confirmed',
        ]);

        $user = new User();
        $user->fill($request->only(['name', 'email']));
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            $user->username = $user->id;
            $user->save();

            auth()->login($user);

            return redirect($user->dashboard_url)->with([
                'success' => 'Registration successful.',
            ]);
        }

        return back()->withErrors(['message' => 'Something is wrong!']);
    }

    public function lostPassword()
    {
        return Inertia::render('Auth/LostPassword');
    }

    public function lostPasswordAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Password reset link sent to your email.')
            : back()->with('error', __($status));
    }

    public function resetPassword(Request $request)
    {
        $user = User::email($request->email)->first();

        if (!$user || !Password::tokenExists($user, $request->token)) {
            return redirect()->route('auth.lost-password')->with([
                'error' => 'Invalid reset password link.',
            ]);
        }

        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->token,
        ]);
    }

    public function resetPasswordAction(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('success', 'Password has been reset successfully.')
            : back()->with('error', __($status));
    }

    /**
     * Log out a user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();

        return redirect()->route('auth.login')->with([
            'success' => 'You have been logged out successfully.',
        ]);
    }
}
