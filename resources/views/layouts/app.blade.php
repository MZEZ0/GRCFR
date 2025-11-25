<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Enterprise-grade governance, risk, and compliance platform">
    <meta name="generator" content="v0.app">

    <title>@yield('title', 'GRC - Governance, Risk & Compliance Platform')</title>

    {{-- ===== Favicon & Icons ===== --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icon-light-32x32.png') }}" media="(prefers-color-scheme: light)">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icon-dark-32x32.png') }}" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/svg+xml" href="{{ asset('icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-icon.png') }}">

    {{-- ===== Fonts (Roboto Flex) ===== --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- ===== Vite CSS ===== --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="min-h-screen">
        @auth
            @include('layouts.navigation')
        @endauth

        @if (isset($header) || trim($__env->yieldContent('header')))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header ?? '' }}
                    @yield('header')
                </div>
            </header>
        @endif

        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
