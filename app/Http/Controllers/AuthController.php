<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Initialize theme if not already set
            if (!session()->has('theme')) {
                session(['theme' => 'light']);
            }
            
            return redirect()->intended('dashboard')
                ->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }

    public function home()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('welcome');
    }

    // Password Reset Methods
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'We couldn\'t find a user with that email address.',
            ])->onlyInput('email');
        }

        // Generate token
        $token = Str::random(60);

        // Save to password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => Hash::make($token), 'created_at' => now()]
        );

        // Send email with reset link
        $resetLink = route('password.reset', ['token' => $token, 'email' => $user->email]);
        
        // For development, you can log the link or send via email
        \Mail::send('auth.emails.reset-link', ['user' => $user, 'resetLink' => $resetLink], function ($message) use ($user) {
            $message->to($user->email)->subject('Password Reset Request');
        });

        return back()->with('status', 'We have sent a password reset link to your email address.');
    }

    public function showResetForm($token)
    {
        $email = request('email');
        
        // Verify token exists
        $reset = DB::table('password_resets')->where('email', $email)->first();
        if (!$reset || !Hash::check($token, $reset->token)) {
            return redirect()->route('login')->withErrors(['email' => 'Invalid or expired reset link.']);
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Verify token
        $reset = DB::table('password_resets')->where('email', $request->email)->first();
        
        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset link.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Delete reset token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset successfully. Please log in.');
    }
}
