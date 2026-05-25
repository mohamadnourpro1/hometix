<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'لوحة الإدارة | HOMETIX' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-cairo bg-slate-100 text-slate-900">
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/hometix-logo.png') }}" alt="HOMETIX Logo" class="brand-logo">
                    <div class="text-base font-bold">HOMETIX | لوحة الإدارة</div>
                </a>

                <nav class="flex flex-wrap items-center gap-2 text-sm">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 hover:bg-slate-100">لوحة التحكم</a>
                        <a href="{{ route('admin.products.index') }}" class="rounded-lg px-3 py-2 hover:bg-slate-100">المنتجات</a>
                        <a href="{{ route('admin.categories.index') }}" class="rounded-lg px-3 py-2 hover:bg-slate-100">التصنيفات</a>
                        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 hover:bg-slate-100">المتجر</a>

                        <form method="POST" action="{{ route('admin.logout') }}" class="inline-flex">
                            @csrf
                            <button type="submit" class="rounded-lg bg-slate-900 px-3 py-2 text-white hover:bg-slate-800">
                                تسجيل الخروج
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('admin.login') }}" class="rounded-lg bg-slate-900 px-3 py-2 text-white hover:bg-slate-800">تسجيل الدخول</a>
                        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 hover:bg-slate-100">العودة للمتجر</a>
                    @endguest
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6">
            @if(session('success'))
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
