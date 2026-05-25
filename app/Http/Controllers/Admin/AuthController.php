<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login', [
            'title' => 'تسجيل الدخول | HOMETIX',
        ]);
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (!Auth::user()?->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'هذا الحساب لا يملك صلاحيات الدخول للوحة الإدارة.');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'بيانات الدخول غير صحيحة.');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}
