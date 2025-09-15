<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">

        <!-- <title>{{ config('app.name') }}</title> -->
        <title>@stack('title', 'Default Title')</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        
    </head>

    <body class="antialiased bg-gray-100">
        <div class="mx-auto min-h-full max-w-screen-md bg-grey-400">
            <div class="bg-white px-5 my-5 py-3 rounded-lg shadow-lg">
                {{ $slot }}
            </div>
        </div>



        @livewire('notifications') {{-- Only required if you wish to send flash notifications --}}

        @filamentScripts
        
    </body>
</html>