<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'يرجى تسجيل الدخول للوصول إلى لوحة الإدارة.');
        }

        if (!$user->is_admin) {
            abort(403, 'غير مصرح لك بالوصول.');
        }

        return $next($request);
    }
}

