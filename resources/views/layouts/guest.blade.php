<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Rsk Air Travesl</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900">
    <div class="flex flex-col items-center min-h-screen pt-6 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 sm:justify-center sm:pt-0">
        <div class="text-center">
            <div class="flex justify-center mb-3">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}"
                         style="width: 150px; height: auto;"
                         alt="Logo"
                         class="drop-shadow-lg">
                </a>
            </div>

            <h1 class="text-2xl font-extrabold tracking-wide text-transparent sm:text-3xl bg-clip-text bg-gradient-to-r from-amber-300 via-amber-400 to-yellow-300 drop-shadow-md">
                RSK AIR TRAVELS ADMIN PANEL
            </h1>

            <p class="mt-1 text-sm font-medium text-amber-100/80">
                Secure access for administrators only
            </p>
        </div>

        <div class="w-full px-6 py-6 mt-6 overflow-hidden bg-white shadow-xl sm:max-w-md sm:rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
