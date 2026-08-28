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

<!-- FIXED TOP BAR CONTAINER (DESKTOP) -->
<div class="fixed top-0 left-0 right-0 z-50 flex justify-center pt-8 pb-3.5 px-4 pointer-events-none">
    
    <!-- NAVBAR CARD (Figma Spec: 1120px width, 60px height, rounded-full, drop-shadow 0px 4px 15px rgba(0,0,0,0.04)) -->
    <div class="pointer-events-auto w-[1120px] max-w-full bg-white h-[60px] flex items-center justify-between px-3 rounded-full shadow-[0px_4px_15px_rgba(0,0,0,0.04)] border border-slate-100 relative">
        
        <!-- LOGO BRAND -->
        <a href="/" class="flex items-center shrink-0">
            <img src="{{ asset('assets/logo_idn.png') }}" alt="Logo IDN Boarding School" class="h-8 w-auto block">
        </a>

        <!-- NAVIGATION MENU (DESKTOP) -->
        <nav class="flex items-center gap-8">
            
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
            <div class="relative group">
                <button type="button" 
                        class="flex items-center gap-1.5 text-[16px] leading-[24px] font-semibold transition-colors duration-150 cursor-pointer py-2 {{ $isProgram ? 'text-[#0c61cf]' : 'text-[#717680] hover:text-[#0c61cf]' }}">
                    <span>Program</span>
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- PROGRAM DROPDOWN MENU CARD (Figma Spec: 200px width, rounded-2xl, shadow 0px 4px 25px rgba(0,0,0,0.15)) -->
                <div class="absolute top-full left-1/2 -translate-x-1/2 pt-2 w-[200px] hidden group-hover:block transition-all duration-200 z-50">
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

        <!-- CTA BUTTON -->
        <a href="/ppdb" 
           class="bg-[#0c61cf] text-white px-[16px] py-[10px] rounded-full text-[14px] leading-[20px] font-semibold shadow-[0px_2px_6px_rgba(12,97,207,0.32)] transition-all duration-200 hover:bg-[#094fa5] hover:shadow-md shrink-0">
            Daftar PPDB
        </a>

    </div>
</div>
