<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="w-full max-w-full overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <x-seo-head 
        title="Kontak Kami - IDN Boarding School"
        description="Hubungi layanan informasi, customer service, dan panitia PPDB IDN Boarding School melalui WhatsApp, Telepon, Email, atau kunjungan langsung."
        keywords="Kontak IDN Boarding School, Alamat Sekolah IDN Jonggol, No WA IDN Boarding School"
    />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Inter:ital,wght@0,400;0,500;0,600;1,500&family=Funnel+Display:wght@500;600;700;800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js for Interactive Component State -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fafafa] text-[#181d27] min-h-screen w-full max-w-full overflow-x-hidden font-sans antialiased flex flex-col items-center relative">

    <!-- NAVBAR -->
    <x-navbar active="kontak" />

    <!-- MAIN CONTENT -->
    <main class="w-full flex-grow flex flex-col items-center">

        <!-- HERO & CONTACT CARDS SECTION (Figma Node 19889:5497) -->
        <section class="w-full max-w-full overflow-hidden flex flex-col items-center pt-[130px] md:pt-[160px] pb-12 md:pb-[110px] px-6 md:px-[64px] lg:px-[160px] bg-[#fafafa]">
            <div class="w-full max-w-[706px] lg:max-w-[1120px] mx-auto flex flex-col gap-10 md:gap-[64px]">
                
                <!-- HEADER CONTENT (Figma Node 19889:5498 - w-[674px]) -->
                <div class="flex flex-col gap-3 items-start text-left w-full max-w-[674px]">
                    <span class="text-[#717680] text-[15px] md:text-[16px] font-normal">Kontak</span>
                    
                    <div class="flex flex-col gap-4 items-start text-left w-full">
                        <h1 class="font-heading font-semibold text-[36px] sm:text-[48px] md:text-[56px] leading-[44px] sm:leading-[58px] md:leading-[68px] tracking-[-2.24px] text-[#0b0d12]">
                            Kami senang mendengar<br>
                            <span class="text-[#0c61cf]">kabar dari Anda</span><span class="text-[#181d27]">.</span>
                        </h1>
                        <p class="text-[#717680] text-[15px] md:text-[16px] leading-[24px] font-normal">
                            Punya pertanyaan seputar penerimaan santri baru (PPDB), kurikulum IT & Diniyah, kehidupan asrama, beasiswa, atau program kemitraan? Hubungi kami langsung melalui kanal resmi di bawah ini.
                        </p>
                    </div>
                </div>

                <!-- 6 CONTACT CARDS GRID (Figma Node 19889:5503 - Default state, Hover effect like WhatsApp, template <img> tags) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 w-full">
                    
                    <!-- CARD 1: WHATSAPP -->
                    <div class="bg-white border border-[#e9eaeb] hover:border-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(0,0,0,0.1)] rounded-[18px] p-5 sm:p-6 flex flex-col justify-between gap-8 h-full transition-all duration-200 ease-out group">
                        <div class="flex flex-col gap-6 items-start text-left w-full">
                            <!-- WHATSAPP ICON (wa.avif) -->
                            <div class="w-10 h-10 flex items-center justify-center shrink-0">
                                <img src="{{ asset('assets/icons/wa.avif') }}" alt="WhatsApp Icon" class="w-10 h-10 object-contain">
                            </div>
                            <h2 class="font-semibold text-[20px] sm:text-[24px] leading-[32px] text-[#181d27]">
                                +62 822-1010-2006
                            </h2>
                        </div>
                        <a href="https://wa.me/6282210102006" target="_blank" class="bg-white border-2 border-[#e9eaeb] text-[#414651] group-hover:border-[#0c61cf] group-hover:bg-[#0c61cf] group-hover:text-white px-5 py-3 rounded-full font-semibold text-[16px] leading-none flex items-center justify-center gap-2 w-fit transition-all duration-200 ease-out">
                            <span>Chat Whatsapp</span>
                            <svg class="w-4 h-4 transition-transform duration-200 ease-out group-hover:translate-x-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>

                    <!-- CARD 2: INSTAGRAM -->
                    <div class="bg-white border border-[#e9eaeb] hover:border-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(0,0,0,0.1)] rounded-[18px] p-5 sm:p-6 flex flex-col justify-between gap-8 h-full transition-all duration-200 ease-out group">
                        <div class="flex flex-col gap-6 items-start text-left w-full">
                            <!-- INSTAGRAM ICON (ig.avif) -->
                            <div class="w-10 h-10 flex items-center justify-center shrink-0">
                                <img src="{{ asset('assets/icons/ig.avif') }}" alt="Instagram Icon" class="w-10 h-10 object-contain">
                            </div>
                            <h2 class="font-semibold text-[20px] sm:text-[24px] leading-[32px] text-[#181d27]">
                                @idnboardingschool
                            </h2>
                        </div>
                        <a href="https://instagram.com/idnboardingschool" target="_blank" class="bg-white border-2 border-[#e9eaeb] text-[#414651] group-hover:border-[#0c61cf] group-hover:bg-[#0c61cf] group-hover:text-white px-5 py-3 rounded-full font-semibold text-[16px] transition-all duration-200 ease-out w-fit">
                            Buka Instagram
                        </a>
                    </div>

                    <!-- CARD 3: EMAIL -->
                    <div class="bg-white border border-[#e9eaeb] hover:border-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(0,0,0,0.1)] rounded-[18px] p-5 sm:p-6 flex flex-col justify-between gap-8 h-full transition-all duration-200 ease-out group">
                        <div class="flex flex-col gap-6 items-start text-left w-full">
                            <!-- EMAIL ICON (gmail.avif) -->
                            <div class="w-10 h-10 flex items-center justify-center shrink-0">
                                <img src="{{ asset('assets/icons/gmail.avif') }}" alt="Email Icon" class="w-10 h-10 object-contain">
                            </div>
                            <h2 class="font-semibold text-[20px] sm:text-[24px] leading-[32px] text-[#181d27]">
                                info@idn.sch.id
                            </h2>
                        </div>
                        <a href="mailto:info@idn.sch.id" class="bg-white border-2 border-[#e9eaeb] text-[#414651] group-hover:border-[#0c61cf] group-hover:bg-[#0c61cf] group-hover:text-white px-5 py-3 rounded-full font-semibold text-[16px] transition-all duration-200 ease-out w-fit">
                            Kirim Email
                        </a>
                    </div>

                    <!-- CARD 4: FACEBOOK -->
                    <div class="bg-white border border-[#e9eaeb] hover:border-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(0,0,0,0.1)] rounded-[18px] p-5 sm:p-6 flex flex-col justify-between gap-8 h-full transition-all duration-200 ease-out group">
                        <div class="flex flex-col gap-6 items-start text-left w-full">
                            <!-- FACEBOOK ICON (fb.avif) -->
                            <div class="w-10 h-10 flex items-center justify-center shrink-0">
                                <img src="{{ asset('assets/icons/fb.avif') }}" alt="Facebook Icon" class="w-10 h-10 object-contain">
                            </div>
                            <h2 class="font-semibold text-[20px] sm:text-[24px] leading-[32px] text-[#181d27]">
                                IDN Boarding School
                            </h2>
                        </div>
                        <a href="https://www.facebook.com/idnboardingschool" target="_blank" class="bg-white border-2 border-[#e9eaeb] text-[#414651] group-hover:border-[#0c61cf] group-hover:bg-[#0c61cf] group-hover:text-white px-5 py-3 rounded-full font-semibold text-[16px] transition-all duration-200 ease-out w-fit">
                            Buka Facebook
                        </a>
                    </div>

                    <!-- CARD 5: TIKTOK -->
                    <div class="bg-white border border-[#e9eaeb] hover:border-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(0,0,0,0.1)] rounded-[18px] p-5 sm:p-6 flex flex-col justify-between gap-8 h-full transition-all duration-200 ease-out group">
                        <div class="flex flex-col gap-6 items-start text-left w-full">
                            <!-- TIKTOK ICON (tt.avif) -->
                            <div class="w-10 h-10 flex items-center justify-center shrink-0">
                                <img src="{{ asset('assets/icons/tt.avif') }}" alt="TikTok Icon" class="w-10 h-10 object-contain">
                            </div>
                            <h2 class="font-semibold text-[20px] sm:text-[24px] leading-[32px] text-[#181d27]">
                                IDN Boarding School
                            </h2>
                        </div>
                        <a href="https://www.tiktok.com/@idn.boardingschool" target="_blank" class="bg-white border-2 border-[#e9eaeb] text-[#414651] group-hover:border-[#0c61cf] group-hover:bg-[#0c61cf] group-hover:text-white px-5 py-3 rounded-full font-semibold text-[16px] transition-all duration-200 ease-out w-fit">
                            Buka Tiktok
                        </a>
                    </div>

                    <!-- CARD 6: YOUTUBE -->
                    <div class="bg-white border border-[#e9eaeb] hover:border-[#0c61cf] hover:shadow-[0px_4px_20px_rgba(0,0,0,0.1)] rounded-[18px] p-5 sm:p-6 flex flex-col justify-between gap-8 h-full transition-all duration-200 ease-out group">
                        <div class="flex flex-col gap-6 items-start text-left w-full">
                            <!-- YOUTUBE ICON (yt.avif) -->
                            <div class="w-10 h-10 flex items-center justify-center shrink-0">
                                <img src="{{ asset('assets/icons/yt.avif') }}" alt="YouTube Icon" class="w-10 h-10 object-contain">
                            </div>
                            <h2 class="font-semibold text-[20px] sm:text-[24px] leading-[32px] text-[#181d27]">
                                IDN TV
                            </h2>
                        </div>
                        <a href="https://www.youtube.com/@IDNTV2022" target="_blank" class="bg-white border-2 border-[#e9eaeb] text-[#414651] group-hover:border-[#0c61cf] group-hover:bg-[#0c61cf] group-hover:text-white px-5 py-3 rounded-full font-semibold text-[16px] transition-all duration-200 ease-out w-fit">
                            Buka Youtube
                        </a>
                    </div>

                </div>

            </div>
        </section>


        <!-- REGISTRATION SECTION (Figma Node 19889:5542) -->
        <x-cta-section />

    </main>

    <!-- FOOTER -->
    <x-footer />

    <!-- CHATBOT COMPONENT -->
    <x-chatbot />

</body>
</html>
