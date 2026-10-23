<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#263746">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Artline Traffic">

    <link rel="icon" type="favicon/ico" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

    <title>@yield('title', 'Artline Traffic')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen items-stretch">

    @include('layouts.sidebar')

    <div class="flex min-w-0 flex-1 flex-col">

        <header class="border-b border-gray-200 bg-white px-6 py-4">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">
                    Hoş Geldiniz, {{ auth()->user()->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Artline Traffic Teklif operasyonlarınızı buradan yönetebilirsiniz.
                </p>
            </div>
        </header>

        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</div>

@stack('scripts')
</body>
</html>
