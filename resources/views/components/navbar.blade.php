@props(['active' => null, 'activeSub' => null])

@php
    // Detect current route / path
    $currentPath = request()->path();
    $currentRouteName = request()->route() ? request()->route()->getName() : '';

    // Auto-detect main active item if not explicitly passed
    $isBeranda = $active === 'beranda' || ($active === null && (request()->is('/') || $currentPath === '' || $currentPath === '/'));
    $isPpdb = $active === 'ppdb' || ($active === null && request()->is('ppdb*'));
    $isTentangKami = $active === 'tentang-kami' || ($active === null && request()->is('tentang-kami*'));
    $isCareerCenter = $active === 'career-center' || ($active === null && request()->is('career-center*'));
    $isArtikel = $active === 'artikel' || ($active === null && (request()->is('artikel*') || $currentRouteName === 'articles.show'));
    $isKontak = $active === 'kontak' || ($active === null && request()->is('kontak*'));

    // Program dropdown sub-items definition (Figma specs: PKL, IDN Mengajar, Ekstrakurikuler, Edurace, Live In, Business Survival, Backpacker, IT Camp, MPLS, IDN Bersyukur)
    $programItems = [
        ['name' => 'PKL', 'slug' => 'pkl', 'url' => '/program/pkl'],
        ['name' => 'IDN Mengajar', 'slug' => 'idn-mengajar', 'url' => '/program/idn-mengajar'],
        ['name' => 'Ekstrakurikuler', 'slug' => 'ekstrakurikuler', 'url' => '/program/ekstrakurikuler'],
        ['name' => 'Edurace', 'slug' => 'edurace', 'url' => '/program/edurace'],
        ['name' => 'Live In', 'slug' => 'live-in', 'url' => '/program/live-in'],
        ['name' => 'Business Survival', 'slug' => 'business-survival', 'url' => '/program/business-survival'],
        ['name' => 'Backpacker', 'slug' => 'backpacker', 'url' => '/program/backpacker'],
        ['name' => 'IT Camp', 'slug' => 'it-camp', 'url' => '/program/it-camp'],
        ['name' => 'MPLS', 'slug' => 'mpls', 'url' => '/program/mpls'],
        ['name' => 'IDN Bersyukur', 'slug' => 'idn-bersyukur', 'url' => '/program/idn-bersyukur'],
    ];

    // Determine active sub-item
    $currentActiveSub = $activeSub;
    if ($currentActiveSub === null && request()->is('program/*')) {
        $currentActiveSub = request()->segment(2);
    }

    // Determine if parent "Program" menu is active
    $isProgram = $active === 'program' || $currentActiveSub !== null || ($active === null && request()->is('program*'));
@endphp

<!-- FIXED TOP BAR CONTAINER -->
<header class="fixed top-0 left-0 right-0 z-50 flex justify-center pt-6 pb-3.5 px-4 pointer-events-none backdrop-blur-md bg-white/30 border-b border-slate-200/20">
    
    <!-- NAVBAR CARD (Figma Spec: 1120px width, 60px height, rounded-full, drop-shadow 0px 4px 15px rgba(0,0,0,0.04)) -->
    <div class="pointer-events-auto w-full max-w-[1120px] bg-white h-[60px] flex items-center justify-between px-4 sm:px-6 rounded-full shadow-[0px_4px_15px_rgba(0,0,0,0.04)] border border-slate-100/80 relative">
        
        <!-- LOGO BRAND -->
        <a href="/" class="flex items-center shrink-0 pl-1">
            <img src="{{ asset('assets/logo_idn.png') }}" alt="Logo IDN Boarding School" class="h-8 w-auto block">
        </a>

        <!-- DESKTOP NAVIGATION MENU -->
        <nav class="hidden lg:flex items-center gap-8">
            
            <!-- Beranda -->
            <a href="/" 
               class="text-[16px] leading-[24px] font-semibold transition-colors duration-150 {{ $isBeranda ? 'text-[#0c61cf]' : 'text-[#717680] hover:text-[#0c61cf]' }}">
                Beranda
            </a>

            <!-- PPDB -->
            <a href="/ppdb" 
               class="text-[16px] leading-[24px] font-semibold transition-colors duration-150 {{ $isPpdb ? 'text-[#0c61cf]' : 'text-[#717680] hover:text-[#0c61cf]' }}">
                PPDB
            </a>

            <!-- Tentang Kami -->
            <a href="/tentang-kami" 
               class="text-[16px] leading-[24px] font-semibold transition-colors duration-150 {{ $isTentangKami ? 'text-[#0c61cf]' : 'text-[#717680] hover:text-[#0c61cf]' }}">
                Tentang Kami
            </a>

            <!-- Program (With Dropdown Menu) -->
            <div class="relative group" id="navbarProgramDropdown">
                <button type="button" 
                        class="flex items-center gap-1.5 text-[16px] leading-[24px] font-semibold transition-colors duration-150 cursor-pointer py-2 {{ $isProgram ? 'text-[#0c61cf]' : 'text-[#717680] hover:text-[#0c61cf]' }}">
                    <span>Program</span>
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180 group-focus-within:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- PROGRAM DROPDOWN MENU CARD (Figma Spec: 200px width, rounded-2xl, shadow 0px 4px 25px rgba(0,0,0,0.15)) -->
                <div class="absolute top-full left-1/2 -translate-x-1/2 pt-2 w-[200px] hidden group-hover:block group-focus-within:block transition-all duration-200 z-50">
                    <div class="bg-white rounded-[16px] shadow-[0px_4px_25px_0px_rgba(0,0,0,0.15)] overflow-hidden border border-slate-100 py-1.5">
                        @foreach($programItems as $item)
                            @php
                                $isSubActive = ($currentActiveSub === $item['slug']);
                            @endphp
                            <!-- 
                                Option States (Figma Spec):
                                - Normal: bg-white, border-l-2 border-transparent, text-[#181d27]
                                - Hover: bg-[#f5f5f5], border-l-2 border-transparent, text-[#181d27]
                                - Selected: bg-white, border-l-2 border-[#0c61cf], font-semibold text-[#181d27]
                                - Selected_Hover: bg-[#f5f5f5], border-l-2 border-[#0c61cf], font-semibold text-[#181d27]
                            -->
                            <a href="{{ $item['url'] }}" 
                               class="px-[20px] py-[12px] text-[14px] leading-[20px] text-[#181d27] block transition-all duration-150 {{ $isSubActive ? 'bg-white border-l-2 border-[#0c61cf] font-semibold hover:bg-[#f5f5f5]' : 'bg-white border-l-2 border-transparent font-medium hover:bg-[#f5f5f5]' }}">
                                {{ $item['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Career Center -->
            <a href="/career-center" 
               class="text-[16px] leading-[24px] font-semibold transition-colors duration-150 {{ $isCareerCenter ? 'text-[#0c61cf]' : 'text-[#717680] hover:text-[#0c61cf]' }}">
                Career Center
            </a>

            <!-- Artikel -->
            <a href="/artikel/idn-relawan-dan-markaz-bersama-as-sunnah-salurkan-bantuan-bencana-banjir-di-bali" 
               class="text-[16px] leading-[24px] font-semibold transition-colors duration-150 {{ $isArtikel ? 'text-[#0c61cf]' : 'text-[#717680] hover:text-[#0c61cf]' }}">
                Artikel
            </a>

            <!-- Kontak -->
            <a href="/kontak" 
               class="text-[16px] leading-[24px] font-semibold transition-colors duration-150 {{ $isKontak ? 'text-[#0c61cf]' : 'text-[#717680] hover:text-[#0c61cf]' }}">
                Kontak
            </a>
        </nav>

        <!-- CTA BUTTON & MOBILE TOGGLE -->
        <div class="flex items-center gap-3">
            <a href="/ppdb" 
               class="bg-[#0c61cf] text-white px-[16px] py-[10px] rounded-full text-[14px] leading-[20px] font-semibold shadow-[0px_2px_6px_rgba(12,97,207,0.32)] transition-all duration-200 hover:bg-[#094fa5] hover:shadow-md shrink-0">
                Daftar PPDB
            </a>

            <!-- Mobile Hamburger Button -->
            <button type="button" 
                    id="mobileNavbarToggleBtn" 
                    onclick="toggleMobileNavbarMenu()"
                    class="lg:hidden p-2 text-[#717680] hover:text-[#0c61cf] rounded-lg transition-colors focus:outline-none cursor-pointer"
                    aria-label="Toggle Navigation Menu">
                <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="closeNavIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- MOBILE MENU DRAWER -->
    <div id="mobileNavbarMenu" 
         class="pointer-events-auto fixed inset-x-4 top-[84px] max-w-[1120px] mx-auto bg-white rounded-[16px] shadow-[0px_8px_30px_rgba(0,0,0,0.12)] border border-slate-100 p-5 hidden flex-col gap-2 lg:hidden z-50 animate-fade-in max-h-[calc(100vh-100px)] overflow-y-auto">
        <a href="/" class="px-4 py-2.5 rounded-xl font-semibold text-base transition-colors {{ $isBeranda ? 'bg-blue-50 text-[#0c61cf]' : 'text-[#717680] hover:bg-slate-50' }}">
            Beranda
        </a>
        <a href="/ppdb" class="px-4 py-2.5 rounded-xl font-semibold text-base transition-colors {{ $isPpdb ? 'bg-blue-50 text-[#0c61cf]' : 'text-[#717680] hover:bg-slate-50' }}">
            PPDB
        </a>
        <a href="/tentang-kami" class="px-4 py-2.5 rounded-xl font-semibold text-base transition-colors {{ $isTentangKami ? 'bg-blue-50 text-[#0c61cf]' : 'text-[#717680] hover:bg-slate-50' }}">
            Tentang Kami
        </a>

        <!-- Mobile Program Accordion -->
        <div class="flex flex-col">
            <button type="button" 
                    onclick="toggleMobileProgramAccordion()" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl font-semibold text-base transition-colors {{ $isProgram ? 'bg-blue-50 text-[#0c61cf]' : 'text-[#717680] hover:bg-slate-50' }}">
                <span>Program</span>
                <svg id="mobileProgramAccordionArrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="mobileProgramAccordionMenu" class="hidden flex-col pl-4 mt-1 border-l-2 border-blue-100 gap-1">
                @foreach($programItems as $item)
                    @php
                        $isSubActive = ($currentActiveSub === $item['slug']);
                    @endphp
                    <a href="{{ $item['url'] }}" 
                       class="px-4 py-2 rounded-lg text-sm transition-all {{ $isSubActive ? 'text-[#0c61cf] font-semibold bg-blue-50/60 border-l-2 border-[#0c61cf]' : 'text-[#717680] font-medium hover:text-[#0c61cf] hover:bg-slate-50' }}">
                        {{ $item['name'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <a href="/career-center" class="px-4 py-2.5 rounded-xl font-semibold text-base transition-colors {{ $isCareerCenter ? 'bg-blue-50 text-[#0c61cf]' : 'text-[#717680] hover:bg-slate-50' }}">
            Career Center
        </a>
        <a href="/artikel/idn-relawan-dan-markaz-bersama-as-sunnah-salurkan-bantuan-bencana-banjir-di-bali" class="px-4 py-2.5 rounded-xl font-semibold text-base transition-colors {{ $isArtikel ? 'bg-blue-50 text-[#0c61cf]' : 'text-[#717680] hover:bg-slate-50' }}">
            Artikel
        </a>
        <a href="/kontak" class="px-4 py-2.5 rounded-xl font-semibold text-base transition-colors {{ $isKontak ? 'bg-blue-50 text-[#0c61cf]' : 'text-[#717680] hover:bg-slate-50' }}">
            Kontak
        </a>
    </div>
</header>

<script>
    function toggleMobileNavbarMenu() {
        const menu = document.getElementById('mobileNavbarMenu');
        const hamburger = document.getElementById('hamburgerIcon');
        const closeIcon = document.getElementById('closeNavIcon');
        if (menu) {
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
                hamburger?.classList.add('hidden');
                closeIcon?.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('flex');
                hamburger?.classList.remove('hidden');
                closeIcon?.classList.add('hidden');
            }
        }
    }

    function toggleMobileProgramAccordion() {
        const submenu = document.getElementById('mobileProgramAccordionMenu');
        const arrow = document.getElementById('mobileProgramAccordionArrow');
        if (submenu) {
            const isHidden = submenu.classList.contains('hidden');
            if (isHidden) {
                submenu.classList.remove('hidden');
                submenu.classList.add('flex');
                arrow?.classList.add('rotate-180');
            } else {
                submenu.classList.add('hidden');
                submenu.classList.remove('flex');
                arrow?.classList.remove('rotate-180');
            }
        }
    }
</script>
