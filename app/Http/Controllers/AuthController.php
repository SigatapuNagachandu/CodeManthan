<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show premium Login View
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectUser(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Step 1: Validate Password Credentials, Generate OTP
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }

        // Generate a 6-digit OTP code
        $otp = random_int(100000, 999999);
        $user->update([
            'otp_code' => (string) $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Keep email and mock OTP in session for local sandbox assistance
        session(['otp_email' => $user->email, 'sandbox_otp' => $otp]);

        return redirect()->route('login.otp')->with('success', 'A 6-digit security OTP code has been generated!');
    }

    /**
     * Show premium Register/Signup View
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectUser(Auth::user());
        }
        return view('auth.register');
    }

    /**
     * Step 1: Create Account, Generate OTP
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'role' => 'required|in:candidate,organizer',
        ]);

        // Hash password and create User in MongoDB
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'profile_picture' => 'https://api.dicebear.com/7.x/pixel-art/svg?seed=' . urlencode($data['name']),
        ]);

        // Generate 6-digit OTP
        $otp = random_int(100000, 999999);
        $user->update([
            'otp_code' => (string) $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        session(['otp_email' => $user->email, 'sandbox_otp' => $otp]);

        return redirect()->route('login.otp')->with('success', 'Account registered! A 6-digit security OTP code has been generated!');
    }

    /**
     * Show OTP Verification screen
     */
    public function showOtp()
    {
        if (!session('otp_email')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    /**
     * Step 2: Validate OTP Code, Login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|min:6|max:6',
        ]);

        $otpCode = implode('', $request->otp);
        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('login');
        }

        $user = User::where('email', $email)->first();

        if (!$user || $user->otp_code !== $otpCode || Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'The OTP code is invalid or has expired.']);
        }

        // Clear OTP columns
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        // Authenticate
        Auth::login($user);
        session()->forget(['otp_email', 'sandbox_otp']);

        return $this->redirectUser($user)->with('success', 'Verification successful! Welcome back, ' . $user->name . '.');
    }

    /**
     * Renders Simulated Google OAuth Chooser Portal
     */
    public function showGoogleSelect()
    {
        return view('auth.google-select');
    }

    /**
     * Google Login Simulator (Interactive OAuth Mock)
     */
    public function mockGoogleLogin(Request $request, $role)
    {
        // Support custom account generation under Google simulator
        if ($request->filled('email') && $request->filled('name')) {
            $email = $request->email;
            $name = $request->name;
            
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => $role, // e.g. candidate
                    'profile_picture' => 'https://api.dicebear.com/7.x/pixel-art/svg?seed=' . urlencode($name),
                ]);
            }
        } else {
            // Standard seeded account redirect
            $user = User::where('role', $role)->first();

            if (!$user) {
                $user = User::create([
                    'name' => 'Google User (' . ucfirst($role) . ')',
                    'email' => $role . '@google-login.com',
                    'password' => Hash::make('password'),
                    'role' => $role,
                    'profile_picture' => 'https://api.dicebear.com/7.x/pixel-art/svg?seed=' . $role,
                ]);
            }
        }

        Auth::login($user);
        return $this->redirectUser($user)->with('success', 'Logged in securely via Google Account: ' . $user->name . '!');
    }

    /**
     * Destroy Session (Logout)
     */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('landing')->with('info', 'Logged out successfully. Secure sessions cleared.');
    }

    /**
     * Redirect User based on their role
     */
    private function redirectUser($user)
    {
        if ($user->isSuperAdmin() || $user->isOrganizer()) {
            return redirect()->route('organizer.dashboard');
        } elseif ($user->isCandidate()) {
            return redirect()->route('candidate.dashboard');
        } elseif ($user->isProctor()) {
            return redirect()->route('proctor.dashboard');
        }

        return redirect()->route('login');
    }
}
