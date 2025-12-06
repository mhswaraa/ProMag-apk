<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProMag') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-gray-100 dark:bg-gray-900 overflow-hidden">
            
            <!-- Sidebar (Fixed Left) -->
            @include('layouts.sidebar')

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col overflow-hidden">
                
                <!-- Top Navigation -->
                @include('layouts.navigation')

                <!-- Main Page Content (Scrollable) -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900">
                    <!-- Page Heading (Optional) -->
                    @if (isset($header))
                        <header class="bg-white dark:bg-gray-800 shadow-sm z-10 relative">
                            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    <!-- Page Content Slot -->
                    <div class="p-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
            
        </div>
    </body>
</html>
