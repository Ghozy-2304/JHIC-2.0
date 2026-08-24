<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-slate-800 min-h-screen w-screen overflow-x-hidden font-sans">

    <!-- REUSABLE CHATBOT COMPONENT -->
    <x-chatbot />

    </body>
</html>
