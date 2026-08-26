<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IDN Boarding School</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Funnel+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#fafafa] text-[#181d27] min-h-screen w-screen overflow-x-hidden font-sans pt-[100px]">

    <!-- REUSABLE NAVBAR COMPONENT -->
    <x-navbar />

    <!-- MAIN BODY PREVIEW -->
    <main class="w-full flex flex-col items-center justify-center py-20 px-5 text-center">
        <div class="max-w-[800px] flex flex-col items-center gap-6">
            <span class="inline-block px-4 py-1.5 rounded-full bg-blue-50 text-[#0c61cf] font-semibold text-sm border border-blue-100">
                #Jagoan IT Pinter Ngaji
            </span>
            <h1 class="text-5xl font-bold leading-tight tracking-tight text-[#0b0d12] max-md:text-3xl font-heading">
                {{ $pageTitle ?? 'Selamat Datang di IDN Boarding School' }}
            </h1>
            <p class="text-[#717680] text-lg max-w-[640px]">
                Pesantren berbasis IT yang membentuk generasi muslim penghafal Al-Qur'an, berkarakter, dan unggul di dunia teknologi.
            </p>
            <div class="flex items-center gap-4 mt-2">
                <a href="/ppdb" class="bg-[#0c61cf] text-white px-6 py-3 rounded-full font-semibold shadow-md hover:bg-[#094fa5] transition-all">
                    Daftar PPDB Sekarang
                </a>
                <a href="/artikel/idn-relawan-dan-markaz-bersama-as-sunnah-salurkan-bantuan-bencana-banjir-di-bali" class="bg-white border border-slate-200 text-[#181d27] px-6 py-3 rounded-full font-semibold shadow-xs hover:bg-slate-50 transition-all">
                    Baca Artikel
                </a>
            </div>
        </div>
    </main>

    <!-- REUSABLE CHATBOT COMPONENT -->
    <x-chatbot />

    </body>
</html>
