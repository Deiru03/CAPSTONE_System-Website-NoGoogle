<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Register') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="fixed top-3 left-3">
            <a href="{{ url()->previous() }}" class="flex items-center text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back
            </a>
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="flex flex-col items-center">
                <a href="/" class="group relative transition-transform duration-300 ease-in-out hover:scale-105">
                    {{--<x-application-logo class="block h-9 w-auto fill-current text-gray-800" /> "Component Ito kahit saan pwede gamitin" --}}
                    <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="w-32 h-32 shadow-lg rounded-full" />
                    <span class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center whitespace-nowrap">Return to Home</span>
                </a>
                <h3 class="mt-4 text-2xl font-serif font-semibold text-gray-800 transition-all duration-300 ease-in-out hover:text-gray-600 hover:shadow-sm text-center">OCCIDENTAL MINDORO STATE COLLEGE</h3>
            </div>

            <div class="w-full sm:max-w-xl mt-6 px-8 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
