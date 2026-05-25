<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'HOMETIX | متجر القطع الإلكترونية والكهربائية' }}</title>
    <meta name="description" content="HOMETIX - متجر متخصص في القطع الإلكترونية والكهربائية وحلول المنزل الذكي.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-cairo">
    @php
        $whatsAppNumber = preg_replace('/\D+/', '', (string) config('store.whatsapp_number'));
        $whatsAppText = rawurlencode('مرحبًا، أريد الاستفسار عن منتجات HOMETIX');
        $whatsAppUrl = $whatsAppNumber ? "https://wa.me/{$whatsAppNumber}?text={$whatsAppText}" : null;
    @endphp

    <div class="page-wrapper">
        <header class="public-header">
            <div class="mx-auto max-w-7xl px-4 py-3">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/hometix-logo.png') }}" alt="HOMETIX Logo" class="brand-logo">
                        <div>
                            <p class="text-base font-bold text-white">HOMETIX</p>
                            <p class="text-xs text-brand-200">حلول إلكترونية وكهربائية لمنزلك الذكي</p>
                        </div>
                    </a>

                    <nav class="flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                        <a href="{{ route('home') }}" class="public-nav-link">الرئيسية</a>
                        <a href="{{ route('products.index') }}" class="public-nav-link">المنتجات</a>
                        @auth
                            @if(auth()->user()?->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="public-nav-link">لوحة الإدارة</a>
                                <form method="POST" action="{{ route('admin.logout') }}" class="inline-flex">
                                    @csrf
                                    <button type="submit" class="public-nav-link">تسجيل الخروج</button>
                                </form>
                            @endif
                        @endauth

                        @guest
                            <a href="{{ route('admin.login') }}" class="public-nav-link">لوحة الإدارة</a>
                        @endguest
                        @if($whatsAppUrl)
                            <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer" class="btn-whatsapp !px-3 !py-2 text-xs sm:text-sm">واتساب</a>
                        @endif
                    </nav>
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-6">
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

        <footer class="footer-dark">
            <div class="mx-auto grid max-w-7xl gap-6 px-4 py-8 md:grid-cols-3">
                <div>
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset('images/hometix-logo.png') }}" alt="HOMETIX Logo" class="brand-logo">
                        <div class="text-lg font-bold text-white">HOMETIX</div>
                    </div>
                    <p class="text-sm text-brand-100/90">
                        متجر متخصص في القطع الإلكترونية والكهربائية وحلول المنزل الذكي.
                    </p>
                </div>

                <div>
                    <h3 class="mb-3 text-sm font-bold text-white">روابط سريعة</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-brand-100/90 hover:text-white">الرئيسية</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-brand-100/90 hover:text-white">المنتجات</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="text-brand-100/90 hover:text-white">لوحة الإدارة</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-3 text-sm font-bold text-white">تواصل معنا</h3>
                    @if($whatsAppUrl)
                        <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer" class="btn-whatsapp">
                            تواصل عبر واتساب
                        </a>
                    @else
                        <p class="text-sm text-brand-200">رقم واتساب غير مضاف بعد.</p>
                    @endif
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
