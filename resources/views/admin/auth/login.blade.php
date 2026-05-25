@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="section-card p-6">
            <div class="mb-5 flex items-center gap-3">
                <img src="{{ asset('images/hometix-logo.png') }}" alt="HOMETIX Logo" class="brand-logo">
                <div>
                    <h1 class="text-lg font-bold text-slate-900">تسجيل الدخول للوحة الإدارة</h1>
                    <p class="text-xs text-slate-600">استخدم حساب المدير للوصول إلى إدارة المنتجات والتصنيفات.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">البريد الإلكتروني</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="input-control">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-semibold text-slate-700">كلمة المرور</label>
                    <input id="password" name="password" type="password" required class="input-control">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full">تسجيل الدخول</button>

                <p class="text-center text-xs text-slate-500">
                    إذا نسيت بيانات الدخول، عدّلها من Seeder `AdminUserSeeder`.
                </p>
            </form>
        </div>
    </div>
@endsection

