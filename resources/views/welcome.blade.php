<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IDN Boarding School - Menghafal Al-Qur'an, Membangun Teknologi</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Funnel+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#fafafa] text-[#181d27] min-h-screen w-screen overflow-x-hidden font-sans">

    <!-- REUSABLE NAVBAR COMPONENT -->
    <x-navbar active="beranda" />

    <!-- HERO HEADER SECTION (Figma Spec Node 19900:12342 Implementation) -->
    <section class="w-full flex flex-col items-center pt-[110px] pb-16 px-5 bg-[#fafafa]">
        
        <!-- MAIN CONTENT CONTAINER (1120px) -->
        <div class="w-[1120px] max-w-full flex items-center justify-between gap-14 py-8">
            
            <!-- LEFT TEXT CONTAINER (615px width) -->
            <div class="w-[615px] max-w-full flex flex-col gap-8 items-start">
                
                <!-- SLOGAN BADGE -->
                <div class="bg-white border border-[#d5d7da] flex items-center justify-center gap-2 px-4 py-2.5 rounded-full shadow-2xs">
                    <span class="w-3.5 h-3.5 rounded-full bg-[#ff7a29] shrink-0"></span>
                    <span class="text-[#0c61cf] font-medium text-[16px] leading-[24px]">Muda Mendunia</span>
                </div>

                <!-- DESCRIPTION CONTAINER -->
                <div class="flex flex-col gap-6 items-start w-full">
                    <!-- MAIN HEADING (56px Geist/Funnel Display) -->
                    <h1 class="font-heading font-semibold text-[56px] leading-[68px] tracking-[-2.24px] text-[#0b0d12] flex flex-col">
                        <span>Menghafal Al-Qur'an.</span>
                        <span class="text-[#0c61cf]">Membangun Teknologi.</span>
                        <span>Berkarya di Dunia Nyata.</span>
                    </h1>

                    <!-- PARAGRAPH TEXT -->
                    <p class="text-[#717680] text-[16px] leading-[24px] max-w-[615px] font-normal">
                        IDN Boarding School Bogor memadukan kurikulum teknologi, dengan tarbiyah Islami dan kehidupan asrama yang membentuk akhlak mulia.
                    </p>
                </div>

                <!-- BUTTON CONTAINER -->
                <div class="flex items-center gap-4 pt-2">
                    <a href="/ppdb" class="bg-[#0c61cf] text-white w-[195px] h-[48px] px-5 py-3 rounded-full font-semibold text-[16px] leading-[24px] flex items-center justify-center shadow-[0px_2px_6px_rgba(12,97,207,0.32)] transition-all duration-200 hover:bg-[#094fa5] hover:shadow-md shrink-0">
                        Daftar Sekarang
                    </a>
                    <a href="/program" class="bg-white border-2 border-[#e9eaeb] text-[#414651] h-[48px] px-5 py-3 rounded-full font-semibold text-[16px] leading-[24px] flex items-center justify-center transition-all duration-200 hover:bg-slate-50 shrink-0">
                        Lihat Jurusan
                    </a>
                </div>
            </div>

            <!-- RIGHT HERO IMAGE (449px x 456px) -->
            <div class="w-[449px] h-[456px] shrink-0 relative">
                <div class="w-full h-full rounded-[18px] border-8 border-white/40 shadow-[12px_12px_56px_0px_rgba(0,4,45,0.16)] overflow-hidden bg-slate-200">
                    <img src="{{ asset('assets/main_bali.png') }}" alt="Gedung IDN Boarding School" class="w-full h-full object-cover">
                </div>
            </div>

        </div>

        <!-- METRIC CONTAINER (1120px width) -->
        <div class="w-[1120px] max-w-full border-t border-b border-[#e9eaeb] py-[14px] mt-12 flex items-center justify-between text-center">
            
            <!-- Metric 1 -->
            <div class="flex-1 border-r border-[#e9eaeb] px-6 py-3 flex flex-col gap-1 items-center">
                <span class="font-bold text-[28px] leading-[38px] text-[#0c61cf]">10+</span>
                <span class="text-[#717680] text-[18px] leading-[26px]">Tahun Berdiri</span>
            </div>

            <!-- Metric 2 -->
            <div class="flex-1 border-r border-[#e9eaeb] px-6 py-3 flex flex-col gap-1 items-center">
                <span class="font-bold text-[28px] leading-[38px] text-[#0c61cf]">5</span>
                <span class="text-[#717680] text-[18px] leading-[26px]">Cabang</span>
            </div>

            <!-- Metric 3 -->
            <div class="flex-1 border-r border-[#e9eaeb] px-6 py-3 flex flex-col gap-1 items-center">
                <span class="font-bold text-[28px] leading-[38px] text-[#0c61cf]">1.500+</span>
                <span class="text-[#717680] text-[18px] leading-[26px]">Alumni Sukses</span>
            </div>

            <!-- Metric 4 -->
            <div class="flex-1 px-6 py-3 flex flex-col gap-1 items-center">
                <span class="font-bold text-[28px] leading-[38px] text-[#0c61cf]">1 Milyar+</span>
                <span class="text-[#717680] text-[18px] leading-[26px]">Penghasilan Siswa</span>
            </div>

        </div>

    </section>

    <!-- REUSABLE CHATBOT COMPONENT -->
    <x-chatbot />

    </body>
</html>
