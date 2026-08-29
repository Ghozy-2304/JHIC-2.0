<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IDN Boarding School - Menghafal Al-Qur'an, Membangun Teknologi</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Inter:ital,wght@0,400;0,500;0,600;1,500&family=Funnel+Display:wght@500;600;700;800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Alpine.js for Interactive Component State -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#fafafa] text-[#181d27] min-h-screen w-screen overflow-x-hidden font-sans antialiased flex flex-col items-center">

    <!-- 1. REUSABLE NAVBAR COMPONENT (Desktop Specs strictly per Figma) -->
    <x-navbar active="beranda" />

    <!-- 2. HERO HEADER SECTION (Figma Node 19900:12342) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-[#fafafa]">
        
        <!-- MAIN CONTENT CONTAINER (1120px width, centered) -->
        <div class="w-[1120px] max-w-full mx-auto flex items-center justify-between gap-14 py-4">
            
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
                    <a href="/ppdb" class="group bg-[#0c61cf] text-white w-[195px] h-[48px] px-5 py-3 rounded-full font-semibold text-[16px] leading-[24px] flex items-center justify-center gap-2 shadow-[0px_2px_6px_rgba(12,97,207,0.32)] transition-all duration-200 hover:bg-[#094fa5] hover:shadow-md shrink-0">
                        <span>Daftar Sekarang</span>
                        <!-- <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg> -->
                    </a>
                    <a href="/program" class="group bg-white border-2 border-[#e9eaeb] text-[#414651] w-[145px] h-[48px] px-5 py-3 rounded-full font-semibold text-[16px] leading-[24px] flex items-center justify-center gap-2 transition-all duration-200 hover:bg-slate-50 hover:border-[#0c61cf] shrink-0">
                        <span>Lihat Jurusan</span>
                        <!-- <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1 text-[#0c61cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg> -->
                    </a>
                </div>
            </div>

            <!-- RIGHT HERO IMAGE (449px x 456px) -->
            <div class="w-[449px] h-[456px] shrink-0 relative">
                <div class="w-full h-full rounded-[18px] shadow-[12px_12px_56px_0px_rgba(0,4,45,0.16)] overflow-hidden bg-slate-200">
                    <img src="{{ asset('assets/Main Image.avif') }}" alt="Gedung IDN Boarding School" class="w-full h-full object-cover">
                </div>
            </div>

        </div>

        <!-- METRIC CONTAINER (1120px width x 120px height, centered) -->
        <div class="w-[1120px] max-w-full mx-auto border-t border-b border-[#e9eaeb] py-[14px] mt-10 flex items-center justify-between text-center">
            <div class="flex-1 border-r border-[#e9eaeb] px-6 py-3 flex flex-col gap-1 items-center">
                <span class="font-bold text-[28px] leading-[38px] text-[#0c61cf]">10+</span>
                <span class="text-[#717680] text-[18px] leading-[26px]">Tahun Berdiri</span>
            </div>
            <div class="flex-1 border-r border-[#e9eaeb] px-6 py-3 flex flex-col gap-1 items-center">
                <span class="font-bold text-[28px] leading-[38px] text-[#0c61cf]">5</span>
                <span class="text-[#717680] text-[18px] leading-[26px]">Cabang</span>
            </div>
            <div class="flex-1 border-r border-[#e9eaeb] px-6 py-3 flex flex-col gap-1 items-center">
                <span class="font-bold text-[28px] leading-[38px] text-[#0c61cf]">1.500+</span>
                <span class="text-[#717680] text-[18px] leading-[26px]">Alumni Sukses</span>
            </div>
            <div class="flex-1 px-6 py-3 flex flex-col gap-1 items-center">
                <span class="font-bold text-[28px] leading-[38px] text-[#0c61cf]">1 Milyar+</span>
                <span class="text-[#717680] text-[18px] leading-[26px]">Penghasilan Siswa</span>
            </div>
        </div>

    </section>


    <!-- 3. KENAPA MEMILIH IDN BOARDING SCHOOL? (Figma Node 19900:12369) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-white">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col items-center gap-12">
            
            <!-- SECTION HEADER -->
            <div class="flex flex-col items-center text-center gap-2">
                <h2 class="font-heading font-bold text-[32px] leading-[42px] text-[#181d27]">
                    Kenapa Memilih <span class="text-[#0c61cf]">IDN Boarding School?</span>
                </h2>
                <p class="text-[#717680] text-[16px] leading-[24px] max-w-[640px]">
                    Lebih dari Sekadar Sekolah. Tapi menjadi tempat untuk Membangun Masa Depanmu.
                </p>
            </div>

            <!-- 6 CARDS GRID (3 cols x 2 rows, 360px x 208px each, rounded-2xl) -->
            <div class="grid grid-cols-3 gap-5 w-full">
                
                <!-- Card 1: Sekolah IT Terbaik -->
                <div class="feature-card bg-white border-2 border-[#e9eaeb] rounded-[18px] p-4 flex flex-col gap-4 items-start w-[360px] max-w-full">
                    <div class="feature-icon-btn bg-white border-2 border-[#e9eaeb] w-12 h-12 rounded-full flex items-center justify-center text-[#414651] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Sekolah IT Terbaik</h3>
                        <p class="text-[#717680] text-[16px] leading-[24px]">Terbukti dengan lulusan kami yang berada di atas standar atau bisa dikatakan expert, dan siap menjadi talenta IT profesional.</p>
                    </div>
                </div>

                <!-- Card 2: Ekstrakurikuler Menarik -->
                <div class="feature-card bg-white border-2 border-[#e9eaeb] rounded-[18px] p-4 flex flex-col gap-4 items-start w-[360px] max-w-full">
                    <div class="feature-icon-btn bg-white border-2 border-[#e9eaeb] w-12 h-12 rounded-full flex items-center justify-center text-[#414651] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Ekstrakurikuler Menarik</h3>
                        <p class="text-[#717680] text-[16px] leading-[24px]">Backpacking ASEAN, Edurace, Entrepreneur, Public Speaking, Berkuda, Beladiri, dan berbagai kegiatan menarik lainnya.</p>
                    </div>
                </div>

                <!-- Card 3: Pengajar Profesional (Hover Example in Figma with Active Blue Border & Shadow) -->
                <div class="feature-card bg-white border-2 border-[#e9eaeb] rounded-[18px] p-4 flex flex-col gap-4 items-start w-[360px] max-w-full">
                    <div class="feature-icon-btn bg-white border-2 border-[#e9eaeb] w-12 h-12 rounded-full flex items-center justify-center text-[#414651] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Pengajar Profesional</h3>
                        <p class="text-[#717680] text-[16px] leading-[24px]">S2 UI, CCIE, Alumni STDI Imam Syafii Jember, Florida USA, dan berbagai pengalaman profesional di bidangnya.</p>
                    </div>
                </div>

                <!-- Card 4: Program Unggulan -->
                <div class="feature-card bg-white border-2 border-[#e9eaeb] rounded-[18px] p-4 flex flex-col gap-4 items-start w-[360px] max-w-full">
                    <div class="feature-icon-btn bg-white border-2 border-[#e9eaeb] w-12 h-12 rounded-full flex items-center justify-center text-[#414651] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Program Unggulan</h3>
                        <p class="text-[#717680] text-[16px] leading-[24px]">Mengembangkan soft skill dan kompetensi melalui IDN Mengajar, Bootcamp, Leadership Camp, English Camp, IT Camp, dan lainnya.</p>
                    </div>
                </div>

                <!-- Card 5: Pesantren Berbasis IT -->
                <div class="feature-card bg-white border-2 border-[#e9eaeb] rounded-[18px] p-4 flex flex-col gap-4 items-start w-[360px] max-w-full">
                    <div class="feature-icon-btn bg-white border-2 border-[#e9eaeb] w-12 h-12 rounded-full flex items-center justify-center text-[#414651] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Pesantren Berbasis IT</h3>
                        <p class="text-[#717680] text-[16px] leading-[24px]">Menggabungkan pembelajaran Diniyah, Tahfidz, Bahasa Inggris, dan teknologi sesuai dengan jurusan serta kebutuhan industri.</p>
                    </div>
                </div>

                <!-- Card 6: Full Praktik -->
                <div class="feature-card bg-white border-2 border-[#e9eaeb] rounded-[18px] p-4 flex flex-col gap-4 items-start w-[360px] max-w-full">
                    <div class="feature-icon-btn bg-white border-2 border-[#e9eaeb] w-12 h-12 rounded-full flex items-center justify-center text-[#414651] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Full Praktik</h3>
                        <p class="text-[#717680] text-[16px] leading-[24px]">Pembelajaran berbasis praktik yang membuat siswa terbiasa mengerjakan project nyata dan siap terjun di lapangan</p>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- 4. JURUSAN YANG ADA DI IDN BOARDING SCHOOL (Figma Node 19900:12404) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-[#fafafa]">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col items-center gap-12">
            
            <!-- SECTION HEADER -->
            <div class="flex flex-col items-center text-center gap-2">
                <h2 class="font-heading font-bold text-[32px] leading-[42px] text-[#0b0d12]">
                    Jurusan yang ada di <span class="text-[#0c61cf]">IDN Boarding School</span>
                </h2>
                <p class="text-[#717680] text-[16px] leading-[24px] max-w-[640px]">
                    Setiap jurusan dirancang bersama praktisi industri, dengan portofolio proyek nyata dan jalur sertifikasi yang diakui.
                </p>
            </div>

            <!-- 3 MAJOR CARDS GRID (360px width each) -->
            <div class="grid grid-cols-3 gap-5 w-full">
                
                <!-- Major 1: RPL -->
                <div class="bg-white border border-[#e9eaeb] rounded-[18px] p-6 flex flex-col gap-8 items-center w-[360px] max-w-full justify-between transition-all duration-300 hover:border-[#0c61cf] hover:shadow-lg hover:-translate-y-1">
                    <div class="flex flex-col gap-6 w-full items-start">
                        <div class="flex items-center justify-between w-full">
                            <div class="w-12 h-12 rounded-full border border-[#c2d8f5] bg-white flex items-center justify-center text-[#0c61cf]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                            </div>
                            <span class="bg-[#d9e7f9] text-[#0c61cf] px-3 py-1 rounded-full text-[12px] font-semibold">RPL</span>
                        </div>
                        <div class="flex flex-col gap-3 w-full">
                            <h3 class="font-semibold text-[20px] leading-[28px] text-[#181d27]">Rekayasa Perangkat Lunak</h3>
                            <p class="text-[#545e6f] text-[14px] leading-[20px]">
                                Membentuk developer muda yang menguasai web, mobile, dan pemrograman modern yang profesional.
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 w-full">
                            <div class="flex gap-3 flex-wrap">
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Web Development</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Mobile App</span>
                            </div>
                            <div class="flex gap-3 flex-wrap">
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Database</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Front-End</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Back-End</span>
                            </div>
                        </div>
                    </div>
                    <a href="/program" class="group bg-[#0c61cf] text-white w-full h-[48px] rounded-full font-semibold text-[16px] flex items-center justify-center gap-2 transition-all duration-200 hover:bg-[#094fa5]">
                        <span>Selengkapnya</span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Major 2: TKJ -->
                <div class="bg-white border border-[#e9eaeb] rounded-[18px] p-6 flex flex-col gap-8 items-center w-[360px] max-w-full justify-between transition-all duration-300 hover:border-[#0c61cf] hover:shadow-lg hover:-translate-y-1">
                    <div class="flex flex-col gap-6 w-full items-start">
                        <div class="flex items-center justify-between w-full">
                            <div class="w-12 h-12 rounded-full border border-[#c2d8f5] bg-white flex items-center justify-center text-[#0c61cf]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <span class="bg-[#d9e7f9] text-[#0c61cf] px-3 py-1 rounded-full text-[12px] font-semibold">TKJ</span>
                        </div>
                        <div class="flex flex-col gap-3 w-full">
                            <h3 class="font-semibold text-[20px] leading-[28px] text-[#181d27]">Teknologi Jaringan & Komputer</h3>
                            <p class="text-[#545e6f] text-[14px] leading-[20px]">
                                Menyiapkan network engineer, administrator server, dan spesialis cybersecurity yang profesional.
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 w-full">
                            <div class="flex gap-3 flex-wrap">
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Cisco CCNA</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">CCNP</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">AWS Cloud</span>
                            </div>
                            <div class="flex gap-3 flex-wrap">
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">CCIE</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Mikrotik</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">DevOps</span>
                            </div>
                        </div>
                    </div>
                    <a href="/program" class="group bg-[#0c61cf] text-white w-full h-[48px] rounded-full font-semibold text-[16px] flex items-center justify-center gap-2 transition-all duration-200 hover:bg-[#094fa5]">
                        <span>Selengkapnya</span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Major 3: DKV -->
                <div class="bg-white border border-[#e9eaeb] rounded-[18px] p-6 flex flex-col gap-8 items-center w-[360px] max-w-full justify-between transition-all duration-300 hover:border-[#0c61cf] hover:shadow-lg hover:-translate-y-1">
                    <div class="flex flex-col gap-6 w-full items-start">
                        <div class="flex items-center justify-between w-full">
                            <div class="w-12 h-12 rounded-full border border-[#c2d8f5] bg-white flex items-center justify-center text-[#0c61cf]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </div>
                            <span class="bg-[#d9e7f9] text-[#0c61cf] px-3 py-1 rounded-full text-[12px] font-semibold">DKV</span>
                        </div>
                        <div class="flex flex-col gap-3 w-full">
                            <h3 class="font-semibold text-[20px] leading-[28px] text-[#181d27]">Desain Komunikasi Visual</h3>
                            <p class="text-[#545e6f] text-[14px] leading-[20px]">
                                Melahirkan UI/UX Designer, kreator konten, motion designer, dan visual storyteller yang profesional.
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 w-full">
                            <div class="flex gap-3 flex-wrap">
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">UI/UX</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">3D Design</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Graphic Design</span>
                            </div>
                            <div class="flex gap-3 flex-wrap">
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Video Editing</span>
                                <span class="bg-white border border-[#e9eaeb] px-3.5 py-2 rounded-full text-[14px] text-black">Motion Graphic</span>
                            </div>
                        </div>
                    </div>
                    <a href="/program" class="group bg-[#0c61cf] text-white w-full h-[48px] rounded-full font-semibold text-[16px] flex items-center justify-center gap-2 transition-all duration-200 hover:bg-[#094fa5]">
                        <span>Selengkapnya</span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

            </div>

        </div>
    </section>


    <!-- 5. PENCAPAIAN WISUDAWAN DARI IDN BOARDING SCHOOL (Figma Node 19900:12412) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-white">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col items-center gap-12">
            
            <!-- SECTION HEADER -->
            <div class="flex flex-col items-center text-center gap-2">
                <h2 class="font-heading font-bold text-[32px] leading-[42px] text-[#0b0d12]">
                    Pencapaian Wisudawan dari <span class="text-[#0c61cf]">IDN Boarding School</span>
                </h2>
                <p class="text-[#717680] text-[16px] leading-[24px] max-w-[700px]">
                    IDN Boarding School melahirkan berbagai santri yang memiliki pencapaian yang membanggakan dan siap membangun masa depan!
                </p>
            </div>

            <!-- AWARDS GRID (2 cols x 4 rows = 8 Wisudawan Image Cards, 550px x 312px each) -->
            <div class="grid grid-cols-2 gap-5 w-full">
                <div class="w-[550px] max-w-full h-[312px] rounded-[14px] overflow-hidden bg-slate-200 shadow-sm border border-[#e9eaeb] transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <img src="{{ asset('assets/Award Image 1.avif') }}" alt="Pencapaian Wisudawan 1" class="w-full h-full object-cover">
                </div>
                <div class="w-[550px] max-w-full h-[312px] rounded-[14px] overflow-hidden bg-slate-200 shadow-sm border border-[#e9eaeb] transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <img src="{{ asset('assets/Award Image 2.avif') }}" alt="Pencapaian Wisudawan 2" class="w-full h-full object-cover">
                </div>
                <div class="w-[550px] max-w-full h-[312px] rounded-[14px] overflow-hidden bg-slate-200 shadow-sm border border-[#e9eaeb] transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <img src="{{ asset('assets/Award Image 3.avif') }}" alt="Pencapaian Wisudawan 3" class="w-full h-full object-cover">
                </div>
                <div class="w-[550px] max-w-full h-[312px] rounded-[14px] overflow-hidden bg-slate-200 shadow-sm border border-[#e9eaeb] transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <img src="{{ asset('assets/Award Image 4.avif') }}" alt="Pencapaian Wisudawan 4" class="w-full h-full object-cover">
                </div>
                <div class="w-[550px] max-w-full h-[312px] rounded-[14px] overflow-hidden bg-slate-200 shadow-sm border border-[#e9eaeb] transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <img src="{{ asset('assets/Award Image 5.avif') }}" alt="Pencapaian Wisudawan 5" class="w-full h-full object-cover">
                </div>
                <div class="w-[550px] max-w-full h-[312px] rounded-[14px] overflow-hidden bg-slate-200 shadow-sm border border-[#e9eaeb] transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <img src="{{ asset('assets/Award Image 6.avif') }}" alt="Pencapaian Wisudawan 6" class="w-full h-full object-cover">
                </div>
                <div class="w-[550px] max-w-full h-[312px] rounded-[14px] overflow-hidden bg-slate-200 shadow-sm border border-[#e9eaeb] transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <img src="{{ asset('assets/Award Image 7.avif') }}" alt="Pencapaian Wisudawan 7" class="w-full h-full object-cover">
                </div>
                <div class="w-[550px] max-w-full h-[312px] rounded-[14px] overflow-hidden bg-slate-200 shadow-sm border border-[#e9eaeb] transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <img src="{{ asset('assets/Award Image 8.avif') }}" alt="Pencapaian Wisudawan 8" class="w-full h-full object-cover">
                </div>
            </div>

        </div>
    </section>


    <!-- 6. KERJASAMA INDUSTRI (Figma Node 19900:12425) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-[#fafafa] overflow-hidden">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col items-center gap-10">
            
            <!-- SECTION HEADER -->
            <div class="flex flex-col items-center text-center gap-2">
                <h2 class="font-heading font-bold text-[32px] leading-[42px] text-[#0b0d12]">
                    Kerjasama Industri
                </h2>
                <div class="text-[#717680] text-[16px] leading-[24px] max-w-[750px]">
                    <p>IDN Boarding School telah menjalin kerjasama dengan berbagai perusahaan, baik nasional maupun internasional</p>
                    <p>untuk mendukung berbagai program, dan pengembangan karir para siswa.</p>
                </div>
            </div>

            <!-- MARQUEE LOGO TICKER CONTAINER (Partner Logo Cards, 160px x 100px) -->
            <div class="w-full overflow-hidden relative py-4 group">
                <!-- Fades -->
                <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-[#fafafa] to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-[#fafafa] to-transparent z-10 pointer-events-none"></div>

                <div class="animate-marquee flex gap-6 items-center">
                    @php
                        $partners = [
                            ['name' => 'Fast Response', 'code' => 'FR', 'color' => '#e11d48', 'img' => 'FR.avif'],
                            ['name' => 'PLN', 'code' => 'PLN', 'color' => '#0284c7', 'img' => 'PLN.avif'],
                            ['name' => 'Sisindokom', 'code' => 'SISINDOKOM', 'color' => '#ea580c', 'img' => 'Sisindokom.avif'],
                            ['name' => 'Jatelindo', 'code' => 'JATELINDO', 'color' => '#0284c7', 'img' => 'JATELINDO.avif'],
                            ['name' => 'IGNITE', 'code' => 'IGNITE', 'color' => '#dc2626', 'img' => 'IGNITE.avif'],
                            ['name' => 'JICT', 'code' => 'JICT', 'color' => '#1e3a8a', 'img' => 'JICT.avif'],
                            ['name' => 'FIM Piston', 'code' => 'FIM', 'color' => '#b91c1c', 'img' => 'FIM.avif'],
                            ['name' => 'Atlasat', 'code' => 'ATLASAT', 'color' => '#0369a1', 'img' => 'ATLASAT.avif'],
                            ['name' => 'METRO TV', 'code' => 'METRO TV', 'color' => '#1e40af', 'img' => 'METRO TV.avif'],
                            ['name' => 'DIGMAZA', 'code' => 'DIGMAZA', 'color' => '#d97706', 'img' => 'DIGMAZA.avif'],
                            ['name' => 'bayarind', 'code' => 'BAYARIND', 'color' => '#65a30d', 'img' => 'bayarind.avif'],
                            ['name' => 'addOn finance', 'code' => 'ADDON', 'color' => '#c2410c', 'img' => 'ADDON.avif'],
                            ['name' => 'IASA Multi Integrator', 'code' => 'IASA', 'color' => '#1d4ed8', 'img' => 'IASA.avif'],
                            ['name' => 'ICS', 'code' => 'ICS', 'color' => '#b91c1c', 'img' => 'ICS.avif'],
                            ['name' => 'PT. Lintas Data Prima', 'code' => 'LDP', 'color' => '#0284c7', 'img' => 'LDP.avif'],
                            ['name' => 'FiberStar', 'code' => 'FIBERSTAR', 'color' => '#ea580c', 'img' => 'FIBERSTAR.avif'],
                            ['name' => 'MULTIINTEGRA', 'code' => 'MULTIINTEGRA', 'color' => '#991b1b', 'img' => 'MULTIINTEGRA.avif'],
                            ['name' => 'INDOWIPI', 'code' => 'INDOWIPI', 'color' => '#991b1b', 'img' => 'INDOWIPI.avif'],
                            ['name' => 'mtm', 'code' => 'MTM', 'color' => '#1d4ed8', 'img' => 'MTM.avif']
                        ];
                    @endphp

                    <!-- Loop 1 -->
                    @foreach($partners as $p)
                    <div class="bg-white rounded-[14px] w-[160px] h-[100px] flex flex-col items-center justify-center shrink-0 shadow-2xs transition-all duration-200 hover:border-[#0c61cf] hover:shadow-md">
                        @if(isset($p['img']))
                            <img src="{{ asset('assets/' . $p['img']) }}" alt="{{ $p['name'] }}" class="max-h-[60px] max-w-[120px] object-contain">
                        @else
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs mb-1" style="background-color: {{ $p['color'] }}20; color: {{ $p['color'] }};">
                                🏢
                            </div>
                            <span class="font-bold text-[13px] text-[#181d27] text-center line-clamp-1" style="color: {{ $p['color'] }};">{{ $p['name'] }}</span>
                        @endif
                    </div>
                    @endforeach

                    <!-- Loop 2 for Seamless Loop -->
                    @foreach($partners as $p)
                    <div class="bg-white rounded-[14px] w-[160px] h-[100px] flex flex-col items-center justify-center shrink-0 transition-all duration-200 hover:border-[#0c61cf] hover:shadow-md">
                        @if(isset($p['img']))
                            <img src="{{ asset('assets/' . $p['img']) }}" alt="{{ $p['name'] }}" class="max-h-[60px] max-w-[120px] object-contain">
                        @else
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs mb-1" style="background-color: {{ $p['color'] }}20; color: {{ $p['color'] }};">
                                🏢
                            </div>
                            <span class="font-bold text-[13px] text-[#181d27] text-center line-clamp-1" style="color: {{ $p['color'] }};">{{ $p['name'] }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>


    <!-- 7. PRESTASI SISWA IDN BOARDING SCHOOL (Figma Node 19900:12470) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-white">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col items-center gap-12">
            
            <!-- SECTION HEADER -->
            <div class="flex flex-col items-center text-center gap-2">
                <h2 class="font-heading font-bold text-[32px] leading-[42px] text-[#0b0d12]">
                    Prestasi Siswa <span class="text-[#0c61cf]">IDN Boarding School</span>
                </h2>
                <p class="text-[#545e6f] text-[16px] leading-[24px] max-w-[700px]">
                    Santri IDN aktif berkompetisi dan berkarya di ajang teknologi, desain, dan keagamaan tingkat nasional maupun internasional.
                </p>
            </div>

            <!-- 3 STUDENT AWARD CARDS GRID -->
            <div class="grid grid-cols-3 gap-5 w-full">
                
                <!-- Card 1 -->
                <div class="bg-white rounded-[18px] overflow-hidden border border-[#e9eaeb] flex flex-col shadow-2xs transition-all duration-300 hover:border-[#0c61cf] hover:shadow-lg hover:-translate-y-1">
                    <div class="h-[300px] w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ asset('assets/rel_IIBS.avif') }}" alt="Award 1" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 flex flex-col gap-6 justify-between bg-white flex-1">
                        <div class="flex flex-col gap-3">
                            <h3 class="font-semibold text-[18px] leading-[26px] text-[#181d27]">
                                Siswa SMP IDN Juara 1 Coding Scratch Nasional di IIBS Almaahira Malang.
                            </h3>
                            <p class="text-[#414651] text-[14px] leading-[20px]">
                                Ahmad Bilal Al Fatih · SMP IDN
                            </p>
                        </div>
                        <p class="text-[#717680] text-[14px] leading-[20px]">
                            21 April 2026
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-[18px] overflow-hidden border border-[#e9eaeb] flex flex-col shadow-2xs transition-all duration-300 hover:border-[#0c61cf] hover:shadow-lg hover:-translate-y-1">
                    <div class="h-[300px] w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ asset('assets/rel_jamnyut.avif') }}" alt="Award 2" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 flex flex-col gap-6 justify-between bg-white flex-1">
                        <div class="flex flex-col gap-3">
                            <h3 class="font-semibold text-[18px] leading-[26px] text-[#181d27]">
                                Siswa SMK IDN Raih Juara 2 Nasional Lomba Networking di Universitas Udayana
                            </h3>
                            <p class="text-[#414651] text-[14px] leading-[20px]">
                                Sharul Azzam · 10 TKJ SMK IDN
                            </p>
                        </div>
                        <p class="text-[#717680] text-[14px] leading-[20px]">
                            21 April 2026
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-[18px] overflow-hidden border border-[#e9eaeb] flex flex-col shadow-2xs transition-all duration-300 hover:border-[#0c61cf] hover:shadow-lg hover:-translate-y-1">
                    <div class="h-[300px] w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ asset('assets/rel_TFI.avif') }}" alt="Award 3" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 flex flex-col gap-6 justify-between bg-white flex-1">
                        <div class="flex flex-col gap-3">
                            <h3 class="font-semibold text-[18px] leading-[26px] text-[#181d27]">
                                Siswi SMK IDN Akhwat Raih Juara 2 Kompetisi UI/UX Design Tech Fest INSTIKI.
                            </h3>
                            <p class="text-[#414651] text-[14px] leading-[20px]">
                                10 DKV SMK IDN Akhwat
                            </p>
                        </div>
                        <p class="text-[#717680] text-[14px] leading-[20px]">
                            20 April 2026
                        </p>
                    </div>
                </div>

            </div>

            <!-- BUTTON: Selengkapnya (149px width x 48px height) -->
            <a href="/artikel/idn-relawan-dan-markaz-bersama-as-sunnah-salurkan-bantuan-bencana-banjir-di-bali" class="group bg-[#0c61cf] text-white w-[149px] h-[48px] rounded-full font-semibold text-[16px] flex items-center justify-center gap-2 shadow-md transition-all duration-200 hover:bg-[#094fa5]">
                <span>Selengkapnya</span>
            </a>

        </div>
    </section>


    <!-- 8. UNIVERSITAS ALUMNI IDN BOARDING SCHOOL (Figma Node 19900:12504) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-[#fafafa]">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col items-center gap-10">
            
            <!-- SECTION HEADER -->
            <div class="flex flex-col items-center text-center gap-2">
                <h2 class="font-heading font-bold text-[32px] leading-[42px] text-[#0b0d12]">
                    Universitas Alumni <span class="text-[#0c61cf]">IDN Boarding School</span>
                </h2>
                <p class="text-[#545e6f] text-[16px] leading-[24px] max-w-[700px]">
                    Alumni IDN Boarding School berhasil menembus berbagai kampus kampus ternama, di dalam negeri maupun luar negeri.
                </p>
            </div>

            <!-- 50 UNIVERSITIES LOGO GRID (94px x 94px LOGO CONTAINERS WITH FLOATING RECTANGULAR TOOLTIP TEXTBOX ON HOVER) -->
            @php
                $allUniversities = [
                    // Baris 1
                    ['name' => 'Nanjing University of Information Science & Technology', 'img' => 'univ cina 1.avif'],
                    ['name' => 'National Dong Hwa University (NDHU)', 'img' => 'univ cina 2.avif'],
                    ['name' => 'University of Malaya (UM)', 'img' => 'UTM.avif'],
                    ['name' => 'Universiti Utara Malaysia (UUM)', 'img' => 'uum.avif'],
                    ['name' => 'Universitas Indonesia (UI)', 'img' => 'UI.avif'],
                    ['name' => 'Universitas Tanjungpura (UNTAN)', 'img' => 'UTP.avif'],
                    ['name' => 'Universitas Bina Sarana Informatika (BSI)', 'img' => 'BSI.avif'],
                    ['name' => 'Program Studi Ilmu Hadits (STIU)', 'img' => 'STDIIS.avif'],
                    ['name' => 'STIT Al-Marhalah Al-Aliyyah (STITMA)', 'img' => 'STITMA.avif'],
                    ['name' => 'Universitas Negeri Semarang (UNNES)', 'img' => 'UNNES.avif'],
                    // Baris 2
                    ['name' => 'Universitas Brawijaya (UB)', 'img' => 'univ brawijaya.avif'],
                    ['name' => 'President University', 'img' => 'president university.avif'],
                    ['name' => 'Universitas Gunadarma', 'img' => 'univ gunadarma.avif'],
                    ['name' => 'Politeknik IDN', 'img' => 'poltek idn.avif'],
                    ['name' => 'Telkom University', 'img' => 'telkom.avif'],
                    ['name' => 'Universitas Muhammadiyah Malang (UMM)', 'img' => 'UMM.avif'],
                    ['name' => 'Universitas Sriwijaya (UNSRI)', 'img' => 'US.avif'],
                    ['name' => 'Universitas Negeri Surabaya (UNESA)', 'img' => 'UNESA.avif'],
                    ['name' => 'Politeknik Elektronika Negeri Surabaya (PENS)', 'img' => 'PENS.avif'],
                    ['name' => 'Universitas Tarumanagara (UNTAR)', 'img' => 'UNTAR.avif'],
                    // Baris 3
                    ['name' => 'Universitas Pertamina', 'img' => 'univ pertamina.avif'],
                    ['name' => 'Politeknik Negeri Media Kreatif (Polimedia)', 'img' => 'Poltek negeri media keratif.avif'],
                    ['name' => 'BINUS University', 'img' => 'binus.avif'],
                    ['name' => 'Istanbul Zaim Üniversitesi (IZU)', 'img' => 'univ di istanbul.avif'],
                    ['name' => 'Universitas Bakrie', 'img' => 'univ bakrie.avif'],
                    ['name' => 'Politeknik Negeri Indramayu (POLINDRA)', 'img' => 'PNI.avif'],
                    ['name' => 'Universitas Multimedia Nusantara (UMN)', 'img' => 'UMN.avif'],
                    ['name' => 'CEP-CCIT Fakultas Teknik Universitas Indonesia', 'img' => 'UI Teknik.avif'],
                    ['name' => 'Bursa Uludağ Üniversitesi', 'img' => 'BUU.avif'],
                    ['name' => 'Cheng Shiu University (CSU)', 'img' => 'CHINA.avif'],
                    // Baris 4
                    ['name' => 'IDS Digital College', 'img' => 'IDF.avif'],
                    ['name' => 'Universitas Muhammadiyah Jakarta (UMJ)', 'img' => 'UMJ.avif'],
                    ['name' => 'Universitas Diponegoro (UNDIP)', 'img' => 'Univ diponegoro.avif'],
                    ['name' => 'Kütahya Dumlupınar Üniversitesi', 'img' => 'dumlupinar universitesi kutahya.avif'],
                    ['name' => 'Swiss German University (SGU)', 'img' => 'SGU.avif'],
                    ['name' => 'Universitas Negeri Jakarta (UNJ)', 'img' => 'UJ.avif'],
                    ['name' => 'Universitas Pembangunan Nasional "Veteran" Jakarta (UPNVJ)', 'img' => 'UNIJA.avif'],
                    ['name' => 'Universitas Indraprasta PGRI (UNINDRA)', 'img' => 'PGRI.avif'],
                    ['name' => 'Universitas Komputer Indonesia (UNIKOM)', 'img' => 'UNIKOM.avif'],
                    ['name' => 'Institut Pertanian Bogor (IPB University)', 'img' => 'IPB.avif'],
                    // Baris 5
                    ['name' => 'Politeknik Negeri Jakarta (PNJ)', 'img' => 'PNJ.avif'],
                    ['name' => 'Universitas Primagraha (UPG)', 'img' => 'Universitas Primagraha (UPG) .avif'],
                    ['name' => 'Harbour.Space University', 'img' => 'harbour space university.avif'],
                    ['name' => 'Universitas Lampung (UNILA)', 'img' => 'univ lampung.avif'],
                    ['name' => 'Universitas Borneo Tarakan (UBT)', 'img' => 'univ borneo tarakan.avif'],
                    ['name' => 'Universitas Gadjah Mada (UGM)', 'img' => 'UP.avif'],
                    ['name' => 'Universitas Esa Unggul (UAI / UEU)', 'img' => 'UAI.avif'],
                    ['name' => 'Universitas Teknologi Sumbawa (UTS)', 'img' => 'UTS.avif'],
                    ['name' => 'Universitas Airlangga (UNAIR)', 'img' => 'UNAIR.avif'],
                    ['name' => 'Universiti Putra Malaysia (UPM)', 'img' => 'UPM.avif']
                ];
            @endphp

            <div class="grid grid-cols-10 gap-5 w-[1120px] max-w-full justify-items-center">
                @foreach($allUniversities as $index => $u)
                @php
                    $uName = is_array($u) ? $u['name'] : $u;
                    $uImg = is_array($u) && isset($u['img']) ? $u['img'] : null;
                @endphp
                <div class="univ-card bg-white w-[94px] h-[94px] rounded-[18px] flex items-center justify-center cursor-pointer shadow-2xs"
                     onmousemove="const r=this.getBoundingClientRect(); this.style.setProperty('--mouse-x', (event.clientX-r.left)+'px'); this.style.setProperty('--mouse-y', (event.clientY-r.top)+'px');">
                    
                    <!-- University Logo Badge / Emblem -->
                    @if($uImg)
                        <img src="{{ asset('assets/' . $uImg) }}" alt="{{ $uName }}" class="w-full h-full rounded-[17px] object-cover shrink-0">
                    @else
                        <div class="w-12 h-12 rounded-full bg-[#f0f6fe] border border-[#c2d8f5] text-[#0c61cf] flex items-center justify-center font-bold text-lg shrink-0">
                            🎓
                        </div>
                    @endif

                    <!-- Floating Rectangular Tooltip Textbox on Hover -->
                    <div class="univ-tooltip bg-[#0c61cf] text-white px-3 py-1.5 rounded-md text-[12px] font-semibold shadow-lg border border-white/20">
                        {{ $uName }}
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>


    <!-- 9. APA KATA MEREKA TENTANG IDN? (Figma Node 19900:12609) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-[#f5f5f5]" x-data="{ activeTab: 'Perusahaan' }">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col items-center gap-10">
            
            <!-- SECTION HEADER -->
            <div class="flex flex-col items-center text-center gap-2">
                <h2 class="font-heading font-bold text-[32px] leading-[42px] text-[#0b0d12]">
                    Apa Kata Mereka Tentang <span class="text-[#0c61cf]">IDN?</span>
                </h2>
            </div>

            <!-- FILTER TABS BUTTONS -->
            <div class="flex items-center justify-center gap-6">
                <button @click="activeTab = 'Perusahaan'"
                        :class="activeTab === 'Perusahaan' ? 'bg-[#0c61cf] text-white shadow-xs' : 'bg-white text-[#414651] border-2 border-[#e9eaeb]'"
                        class="h-[48px] px-[20px] py-[12px] rounded-full font-semibold text-[16px] transition-all duration-200 cursor-pointer">
                    Perusahaan
                </button>
                <button @click="activeTab = 'Wali Santri'"
                        :class="activeTab === 'Wali Santri' ? 'bg-[#0c61cf] text-white shadow-xs' : 'bg-white text-[#414651] border-2 border-[#e9eaeb]'"
                        class="h-[48px] px-[20px] py-[12px] rounded-full font-semibold text-[16px] transition-all duration-200 cursor-pointer">
                    Wali Santri
                </button>
                <button @click="activeTab = 'Alumni'"
                        :class="activeTab === 'Alumni' ? 'bg-[#0c61cf] text-white shadow-xs' : 'bg-white text-[#414651] border-2 border-[#e9eaeb]'"
                        class="h-[48px] px-[20px] py-[12px] rounded-full font-semibold text-[16px] transition-all duration-200 cursor-pointer">
                    Alumni
                </button>
            </div>

            <!-- TESTIMONIAL CARDS SLIDER CONTAINER -->
            <div class="w-full overflow-hidden min-h-[340px]">
                <div class="flex w-full transition-transform duration-500 ease-in-out"
                     :style="activeTab === 'Perusahaan' ? 'transform: translateX(0%);' : (activeTab === 'Wali Santri' ? 'transform: translateX(-100%);' : 'transform: translateX(-200%);')">
                    
                    <!-- TAB 1: PERUSAHAAN TESTIMONIALS (550px width cards per Figma) -->
                    <div class="w-full shrink-0 flex gap-5 justify-center">
                        
                        <!-- Perusahaan 1 -->
                        <div class="bg-white rounded-[18px] p-6 flex flex-col h-[340px] justify-between w-[550px] max-w-full border border-[#e9eaeb] shadow-sm">
                            <div class="flex flex-col gap-5">
                                <div class="flex justify-between items-center">
                                    <div class="w-8 h-8 text-[#0c61cf] text-3xl font-bold leading-none">“</div>
                                    <div class="flex text-[#ff7a29] gap-1 text-sm">★★★★★</div>
                                </div>
                                <p class="text-[#414651] text-[14px] leading-[20px]">
                                    “Team alumni SMK IDN siap untuk diberikan Tugas, dapat task dan mampu belajar cepat untuk menyesuaikan Tugas Technical yang cukup dynamis. Adanya team IDN sangat membantu akselerasi Teknis dan kompetensi terhadap kebutuhan Mobile Developer dan Kebutuhan Network Operation Center, IT & Internet Service . Semoga IDN Terus menghasilkan SDM yang terlatih baik soft skill atau pun hardskill.”
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#e9eaeb] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-[#0c61cf]">👤</div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold text-[16px] text-[#414651]">Nugroho Wibisono</h4>
                                    <span class="text-[#717680] text-[12px]">General Manager IT & Cyber Security Telkomsat</span>
                                </div>
                            </div>
                        </div>

                        <!-- Perusahaan 2 -->
                        <div class="bg-white rounded-[18px] p-6 flex flex-col h-[340px] justify-between w-[550px] max-w-full border border-[#e9eaeb] shadow-sm">
                            <div class="flex flex-col gap-5">
                                <div class="flex justify-between items-center">
                                    <div class="w-8 h-8 text-[#0c61cf] text-3xl font-bold leading-none">“</div>
                                    <div class="flex text-[#ff7a29] gap-1 text-sm">★★★★★</div>
                                </div>
                                <p class="text-[#414651] text-[14px] leading-[20px]">
                                    MobileCom telah beberapa kali merekrut siswa dan alumni IDN, dan yang dapat kami sampaikan adalah bahwa kami benar-benar puas dan bangga dengan pendidikan yang diberikan IDN Boarding School kepada para siswanya; kami sangat yakin bahwa IDN telah berhasil menumbuhkan ketangguhan mental dan kemampuan mereka untuk memasuki dunia kerja dengan lancar. Para lulusan IDN memiliki karakter yang bertanggung jawab terhadap tugas yang diberikan, kepribadian yang baik, serta mampu bekerja sama dalam tim dengan sangat baik.
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#e9eaeb] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-[#0c61cf]">👤</div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold text-[16px] text-[#414651]">Suryanto Hinarto</h4>
                                    <span class="text-[#717680] text-[12px]">CTO MobileCom</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- TAB 2: WALI SANTRI TESTIMONIALS (360px width cards per Figma) -->
                    <div class="w-full shrink-0 flex gap-5 justify-center">
                        
                        <!-- Wali Santri 1 -->
                        <div class="bg-white rounded-[18px] p-6 flex flex-col h-[340px] justify-between w-[360px] max-w-full border border-[#e9eaeb] shadow-sm">
                            <div class="flex flex-col gap-4">
                                <div class="flex justify-between items-center">
                                    <div class="w-8 h-8 text-[#0c61cf] text-3xl font-bold leading-none">“</div>
                                    <div class="flex text-[#ff7a29] gap-1 text-sm">★★★★★</div>
                                </div>
                                <p class="font-medium text-[#414651] text-[14px] leading-[20px]">
                                    "Awalnya ragu, tapi sekarang sangat bersyukur! Setelah beberapa bulan di IDN Boarding School, anak saya jadi jauh lebih mandiri, disiplin, dan sopan. Kemampuan IT-nya pun melesat hingga sudah bisa bikin website sendiri. Sekolah yang luar biasa dalam menyeimbangkan agama dan teknologi."
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#e9eaeb] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-[#0c61cf]">👤</div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold text-[16px] text-[#414651]">Abu Athallah</h4>
                                    <span class="text-[#717680] text-[12px]">Walisantri SMK IDN</span>
                                </div>
                            </div>
                        </div>

                        <!-- Wali Santri 2 -->
                        <div class="bg-white rounded-[18px] p-6 flex flex-col h-[340px] justify-between w-[360px] max-w-full border border-[#e9eaeb] shadow-sm">
                            <div class="flex flex-col gap-4">
                                <div class="flex justify-between items-center">
                                    <div class="w-8 h-8 text-[#0c61cf] text-3xl font-bold leading-none">“</div>
                                    <div class="flex text-[#ff7a29] gap-1 text-sm">★★★★★</div>
                                </div>
                                <p class="font-medium text-[#414651] text-[14px] leading-[20px]">
                                    'IDN Boarding School pilihan tepat! Kedua anak kami (kelas 7 & 9) makin mandiri dan percaya diri berkat pendidikan adab, IT, hingga public speaking dan entrepreneurship. Sangat terasa peningkatan positif di bidang rohani, akademik, dan sosialnya. Terima kasih para ustadz IDN, Jazaakallahu khairan katsiran.'
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#e9eaeb] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-[#0c61cf]">👤</div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold text-[16px] text-[#414651]">Abu Kuswandi</h4>
                                    <span class="text-[#717680] text-[12px]">Walisantri SMP IDN</span>
                                </div>
                            </div>
                        </div>

                        <!-- Wali Santri 3 -->
                        <div class="bg-white rounded-[18px] p-6 flex flex-col h-[340px] justify-between w-[360px] max-w-full border border-[#e9eaeb] shadow-sm">
                            <div class="flex flex-col gap-4">
                                <div class="flex justify-between items-center">
                                    <div class="w-8 h-8 text-[#0c61cf] text-3xl font-bold leading-none">“</div>
                                    <div class="flex text-[#ff7a29] gap-1 text-sm">★★★★★</div>
                                </div>
                                <p class="font-medium text-[#414651] text-[14px] leading-[20px]">
                                    'Bersekolah di IDN Boarding School membawa dampak luar biasa. Anak kami yang tadinya pendiam kini tumbuh menjadi lebih percaya diri dan berani tampil. Lingkungan yang positif serta bimbingan para ustadz yang penuh kepedulian tidak hanya mendidik karakter anak, tetapi juga menginspirasi kami sebagai orang tua tentang pentingnya pendidikan berkarakter.'
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#e9eaeb] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-[#0c61cf]">👤</div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold text-[16px] text-[#414651]">Abu Fauzan</h4>
                                    <span class="text-[#717680] text-[12px]">Walisantri SMK IDN</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- TAB 3: ALUMNI TESTIMONIALS (360px width cards per Figma) -->
                    <div class="w-full shrink-0 flex gap-5 justify-center">
                        
                        <!-- Alumni 1 -->
                        <div class="bg-white rounded-[18px] p-6 flex flex-col h-[340px] justify-between w-[360px] max-w-full border border-[#e9eaeb] shadow-sm">
                            <div class="flex flex-col gap-4">
                                <div class="flex justify-between items-center">
                                    <div class="w-8 h-8 text-[#0c61cf] text-3xl font-bold leading-none">“</div>
                                    <div class="flex text-[#ff7a29] gap-1 text-sm">★★★★★</div>
                                </div>
                                <p class="font-medium text-[#414651] text-[14px] leading-[20px]">
                                    IDN adalah starting point saya di dunia IT, disana saya pertama kali mengenal pemrograman, pertama kali terjun ke dunia industri (PKL), dan pertama kali public speaking di depan banyak orang yang mayoritas diatas saya dari segi umur dan pengalaman. Jadi bersekolah di IDN sangat menyenangkan pun juga bermanfaat.
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#e9eaeb] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-[#0c61cf]">👤</div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold text-[16px] text-[#414651]">Hafidz Naufal</h4>
                                    <span class="text-[#717680] text-[12px]">Alumni SMK IDN · Angkatan 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Alumni 2 -->
                        <div class="bg-white rounded-[18px] p-6 flex flex-col h-[340px] justify-between w-[360px] max-w-full border border-[#e9eaeb] shadow-sm">
                            <div class="flex flex-col gap-4">
                                <div class="flex justify-between items-center">
                                    <div class="w-8 h-8 text-[#0c61cf] text-3xl font-bold leading-none">“</div>
                                    <div class="flex text-[#ff7a29] gap-1 text-sm">★★★★★</div>
                                </div>
                                <p class="font-medium text-[#414651] text-[14px] leading-[20px]">
                                    3 tahun di IDN merupakan 3 tahun yang sangat berwarna, karena tidak hanya belajar IT dan Ngaji, kami juga mendapatkan lingkungan dan pertemanan yang dapat membentuk karakter, komunikasi, sosialisasi, problem solving, serta bekal-bekal lainnya yang dibutuhkan untuk survive.
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#e9eaeb] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-[#0c61cf]">👤</div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold text-[16px] text-[#414651]">Joe Renaldi F.</h4>
                                    <span class="text-[#717680] text-[12px]">Alumni SMK IDN · Angkatan 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Alumni 3 -->
                        <div class="bg-white rounded-[18px] p-6 flex flex-col h-[340px] justify-between w-[360px] max-w-full border border-[#e9eaeb] shadow-sm">
                            <div class="flex flex-col gap-4">
                                <div class="flex justify-between items-center">
                                    <div class="w-8 h-8 text-[#0c61cf] text-3xl font-bold leading-none">“</div>
                                    <div class="flex text-[#ff7a29] gap-1 text-sm">★★★★★</div>
                                </div>
                                <p class="font-medium text-[#414651] text-[14px] leading-[20px]">
                                    Bersekolah di IDN Sangat membentuk mental salah satunya adalah mental kemandirian yang mungkin hanya di dapat dari perpaduan antara SMK dan Boarding School, magang, Public Speaking yang mungkin tidak akan saya dapat jika bersekolah diluar dan juga, mental preparation untuk bekerja dibidang industri.
                                </p>
                            </div>
                            <div class="pt-4 border-t border-[#e9eaeb] flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-[#0c61cf]">👤</div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold text-[16px] text-[#414651]">Abdul Hadi</h4>
                                    <span class="text-[#717680] text-[12px]">Alumni SMK IDN · Angkatan 3</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- 10. BIAYA PENDIDIKAN (Figma Node 19900:12612) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-[#fafafa]">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col gap-8 items-start">
            <div class="flex items-center justify-between gap-14 w-full">
                
                <!-- LEFT TUITION INFO -->
                <div class="flex-1 flex flex-col gap-4 items-start">
                    <div class="flex flex-col gap-2">
                        <span class="text-[#717680] text-[14px] font-normal">Biaya Pendidikan</span>
                        <h2 class="font-heading font-semibold text-[48px] leading-[60px] tracking-[-1.92px] text-[#0b0d12]">
                            <span class="text-[#0c61cf]">Transparan,</span><br>
                            tanpa biaya<br>
                            tersembunyi.
                        </h2>
                    </div>
                    <p class="text-[#717680] text-[16px] leading-[24px]">
                        Estimasi biaya untuk santri baru IDN Boarding School,<br>tahun ajaran 2027/2028.
                    </p>
                </div>

                <!-- RIGHT COST BREAKDOWN -->
                <div class="flex-1 flex flex-col w-full text-[#414651]">
                    <div class="flex justify-between items-center py-4 border-b border-[#e9eaeb]">
                        <span class="text-[16px] font-normal">Biaya Pendaftaran</span>
                        <span class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Rp 900.000</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-b border-[#e9eaeb]">
                        <span class="text-[16px] font-normal">Uang Masuk</span>
                        <span class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Rp 40.000.000</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-b border-[#e9eaeb]">
                        <span class="text-[16px] font-normal">SPP Bulanan</span>
                        <span class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Rp 4.000.000</span>
                    </div>
                    <div class="flex justify-between items-center py-4 border-b border-[#e9eaeb]">
                        <span class="text-[16px] font-normal">Biaya Tahunan</span>
                        <span class="font-semibold text-[24px] leading-[32px] text-[#181d27]">Rp 4.000.000</span>
                    </div>
                </div>

            </div>

            <!-- BUTTON: Selengkapnya (149px width x 48px height) -->
            <a href="/ppdb" class="group bg-[#0c61cf] text-white w-[149px] h-[48px] rounded-full font-semibold text-[16px] flex items-center justify-center gap-2 border border-[#d5d7da] shadow-md transition-all duration-200 hover:bg-[#094fa5]">
                <span>Selengkapnya</span>
            </a>
        </div>
    </section>


    <!-- 11. REGISTRATION BANNER / PPDB 2027/2028 (Figma Node 19900:12633) -->
    <section class="w-full flex flex-col items-center py-[110px] bg-[#fafafa]">
        <div class="w-[1120px] max-w-full mx-auto bg-[#0c61cf] rounded-[20px] p-[40px] text-white flex flex-col gap-8 relative overflow-hidden shadow-lg">
            <div class="w-[390px] h-[423px] rounded-full bg-white/20 blur-[64px] absolute -right-20 -top-40 pointer-events-none"></div>

            <div class="flex flex-col gap-4 z-10 max-w-[672px]">
                <span class="text-[#d5d7da] text-[14px]">PPDB 2027/2028</span>
                <h2 class="font-heading font-bold text-[48px] leading-[60px] tracking-[-1.92px]">
                    <span class="text-[#ff7a29]">Kuota terbatas.</span> Ambil langkahmu hari ini.
                </h2>
                <p class="text-[#d5d7da] text-[16px] leading-[24px]">
                    Gelombang 1 dibuka hingga kuota per jurusan terpenuhi. Daftar sekarang untuk mengamankan tempat dan mendapatkan potongan uang masuk.
                </p>
            </div>

            <!-- BUTTONS CONTAINER -->
            <div class="flex items-center gap-4 z-10">
                <a href="/ppdb" class="group bg-white text-[#0c61cf] px-6 py-3 rounded-full font-semibold text-[16px] h-[48px] flex items-center justify-center gap-2 shadow-md transition-all duration-200 hover:bg-slate-100">
                    <span>Mulai Pendaftaran</span>
                </a>
                <a href="https://wa.me/6282210102006" target="_blank" class="group bg-[#0c61cf] border border-[#d5d7da] text-white px-6 py-3 rounded-full font-semibold text-[16px] h-[48px] flex items-center justify-center gap-2 transition-all duration-200 hover:bg-[#094fa5]">
                    <span>Tanya Via WhatsApp</span>
                </a>
            </div>
        </div>
    </section>


    <!-- 12. FOOTER WITH REAL INTERACTIVE GOOGLE MAP (Figma Node 19900:12644) -->
    <footer class="w-full bg-white border-t border-[#e9eaeb] pt-[110px] pb-[64px] flex flex-col items-center">
        <div class="w-[1120px] max-w-full mx-auto flex flex-col gap-[64px]">
            
            <!-- TOP FOOTER CONTENT -->
            <div class="flex justify-between items-start gap-12 w-full">
                
                <!-- BRAND & SOCIALS (253px width) -->
                <div class="flex flex-col gap-8 w-[253px] shrink-0">
                    <a href="/" class="block">
                        <img src="{{ asset('assets/logo_idn_footer.png') }}" alt="Logo IDN" class="h-[72px] w-[160px] object-cover">
                    </a>
                    <div class="flex flex-col gap-5 text-[14px] leading-[20px]">
                        <p class="text-[#414651]">
                            Pesantren berbasis IT yang membentuk generasi muslim penghafal Al-Qur'an, berkarakter, dan unggul di dunia teknologi.
                        </p>
                        <div class="flex flex-col font-medium italic text-[#0c61cf] tracking-[-0.56px]">
                            <span>#Jagoan IT Pinter Ngaji</span>
                            <span>#Muda Mendunia</span>
                        </div>
                    </div>
                    <!-- SOCIAL BUTTONS -->
                    <div class="flex items-center gap-3">
                        <!-- Instagram -->
                        <a href="#" class="group w-12 h-12 rounded-full border-2 border-[#e9eaeb] bg-white flex items-center justify-center text-[#717680] transition-all duration-200 hover:border-[#0c61cf] hover:text-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(12,97,207,0.15)]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <!-- YouTube -->
                        <a href="#" class="group w-12 h-12 rounded-full border-2 border-[#e9eaeb] bg-white flex items-center justify-center text-[#717680] transition-all duration-200 hover:border-[#0c61cf] hover:text-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(12,97,207,0.15)]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                            </svg>
                        </a>
                        <!-- Facebook -->
                        <a href="#" class="group w-12 h-12 rounded-full border-2 border-[#e9eaeb] bg-white flex items-center justify-center text-[#717680] transition-all duration-200 hover:border-[#0c61cf] hover:text-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(12,97,207,0.15)]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692 1.005 0 1.971.074 1.971.074v2.926z"/>
                            </svg>
                        </a>
                        <!-- WhatsApp -->
                        <a href="#" class="group w-12 h-12 rounded-full border-2 border-[#e9eaeb] bg-white flex items-center justify-center text-[#717680] transition-all duration-200 hover:border-[#0c61cf] hover:text-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(12,97,207,0.15)]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- LINKS & SCHOOL INFO -->
                <div class="flex gap-14 items-start">
                    
                    <!-- Menu Utama (90px) -->
                    <div class="flex flex-col gap-3 w-[90px]">
                        <h4 class="font-semibold text-[14px] text-[#181d27]">Menu Utama</h4>
                        <div class="flex flex-col gap-1.5 text-[14px] text-[#717680]">
                            <a href="/" class="hover:text-[#0c61cf]">Beranda</a>
                            <a href="/ppdb" class="hover:text-[#0c61cf]">PPDB</a>
                            <a href="/tentang-kami" class="hover:text-[#0c61cf]">Tentang Kami</a>
                            <a href="/program" class="hover:text-[#0c61cf]">Program</a>
                            <a href="/career-center" class="hover:text-[#0c61cf]">Career Center</a>
                            <a href="/artikel/idn-relawan-dan-markaz-bersama-as-sunnah-salurkan-bantuan-bencana-banjir-di-bali" class="hover:text-[#0c61cf]">Artikel</a>
                            <a href="/kontak" class="hover:text-[#0c61cf]">Kontak</a>
                        </div>
                    </div>

                    <!-- Program (113px) -->
                    <div class="flex flex-col gap-3 w-[113px]">
                        <h4 class="font-semibold text-[14px] text-[#181d27]">Program</h4>
                        <div class="flex flex-col gap-1.5 text-[14px] text-[#717680]">
                            <a href="/program/pkl" class="hover:text-[#0c61cf]">PKL</a>
                            <a href="/program/idn-mengajar" class="hover:text-[#0c61cf]">IDN Mengajar</a>
                            <a href="/program/ekstrakurikuler" class="hover:text-[#0c61cf]">Ekstrakurikuler</a>
                            <a href="/program/edurace" class="hover:text-[#0c61cf]">Edurace</a>
                            <a href="/program/live-in" class="hover:text-[#0c61cf]">Live In</a>
                            <a href="/program/business-survival" class="hover:text-[#0c61cf]">Business Survival</a>
                            <a href="/program/backpacker" class="hover:text-[#0c61cf]">Backpacker</a>
                            <a href="/program/it-camp" class="hover:text-[#0c61cf]">IT Camp</a>
                            <a href="/program/mpls" class="hover:text-[#0c61cf]">MPLS</a>
                            <a href="/program/idn-bersyukur" class="hover:text-[#0c61cf]">IDN Bersyukur</a>
                        </div>
                    </div>

                    <!-- Artikel -->
                    <div class="flex flex-col gap-3 w-[88px]">
                        <h4 class="font-semibold text-[14px] text-[#181d27]">Artikel</h4>
                        <div class="flex flex-col gap-1.5 text-[14px] text-[#717680]">
                            <a href="#" class="hover:text-[#0c61cf]">Prestasi</a>
                            <a href="#" class="hover:text-[#0c61cf]">News & Event</a>
                        </div>
                    </div>

                    <!-- Informasi Sekolah (236px) -->
                    <div class="flex flex-col gap-3 w-[236px]">
                        <h4 class="font-semibold text-[14px] text-[#181d27]">Informasi Sekolah</h4>
                        <div class="flex flex-col gap-3 text-[14px] text-[#717680]">
                            <div class="flex items-start gap-3">
                                <img src="{{ asset('assets/location.svg') }}" alt="Address" class="w-6 h-6 shrink-0 mt-0.5">
                                <p class="leading-[20px]">Jl. Raya Jonggol-Dayeuh, Sukanegara, Kec. Jonggol, Kabupaten Bogor, Jawa Barat 16830</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/phone.svg') }}" alt="Phone" class="w-6 h-6 shrink-0">
                                <span>+62 822-1010-2006</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/gmail.svg') }}" alt="Gmail" class="w-6 h-6 shrink-0">
                                <span>idnboardingschool@gmail.com</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- REAL INTERACTIVE MAP EMBED (460px height with border 8px rgba(0,0,0,0.2) rounded-3xl) -->
            <div class="w-full h-[460px] rounded-[24px] overflow-hidden border-8 border-black/20 relative shadow-sm">
                <iframe 
                     src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16020.98488009986!2d107.04213275!3d-6.52736515!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69bc6e5be3d9bd%3A0x6b9881dabd801476!2sSMK%20IDN%20Boarding%20School!5e1!3m2!1sid!2sid!4v1787887529975!5m2!1sid!2sid"
                    class="w-full h-full border-0" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- BOTTOM FOOTER & SPONSORS -->
            <div class="flex justify-between items-center w-full pt-4 text-[14px] text-[#414651]">
                <span>© Copyright | 2026 IDN Boarding School.</span>
                <div class="flex items-center gap-8">
                    <img src="{{ asset('assets/logo_jhic.png') }}" alt="JHIC Logo" class="h-8 w-auto">
                    <div class="h-6 w-px bg-[#e9eaeb]"></div>
                    <div class="flex items-center gap-8">
                        <img src="{{ asset('assets/logo_jagoanhosting.png') }}" alt="Jagoan Hosting" class="h-8 w-auto">
                        <img src="{{ asset('assets/logo_komdigi.png') }}" alt="Komdigi" class="h-8 w-auto">
                        <img src="{{ asset('assets/logo_garuda.png') }}" alt="Garuda Spark" class="h-8 w-auto">
                        <img src="{{ asset('assets/logo_ngalup.png') }}" alt="Ngalup" class="h-8 w-auto">
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <!-- 13. REUSABLE CHATBOT COMPONENT -->
    <x-chatbot />

    </body>
</html>
