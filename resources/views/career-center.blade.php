<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <x-seo-head 
        title="Career Center - IDN Boarding School"
        description="Pusat Karir & Alumni IDN Boarding School. Temukan rekomendasi lowongan kerja, mitra industri IT (TKJ, RPL, UI/UX), dan penyaluran kerja lulusan."
        keywords="Career Center IDN, Lowongan Kerja IT, Penyaluran Kerja Lulusan IDN, Karir Alumni IDN"
    />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Funnel+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS Vite Import -->
    @vite(['resources/css/app.css'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#fafafa] text-[#181d27] font-['Geist',sans-serif] antialiased min-h-screen flex flex-col justify-between selection:bg-[#0c61cf] selection:text-white"
      x-data="careerCenterData()">

    <!-- Header Navigation -->
    <x-navbar active="career-center" />

    <main class="flex-1 w-full">
        <!-- Hero Header Section -->
        <section class="w-full bg-[#fafafa] pt-[130px] md:pt-[160px] pb-12 lg:pb-[72px] border-b border-[#e9eaeb]">
            <div class="max-w-[1440px] mx-auto px-6 md:px-12 lg:px-[160px] text-center space-y-4">
                <span class="text-[#717680] text-sm md:text-base font-normal tracking-wide">Career Center</span>
                
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[56px] font-semibold text-[#0b0d12] tracking-[-2.24px] leading-tight lg:leading-[68px] font-['Funnel_Display',sans-serif] max-w-3xl mx-auto">
                    Mulai perjalanan baru<br>dalam <span class="text-[#0c61cf]">karier anda.</span>
                </h1>
                
                <p class="text-[#717680] text-sm md:text-base leading-relaxed font-normal max-w-[674px] mx-auto">
                    Temukan ribuan lowongan kerja impian berbasis jurusan TKJ, RPL, dan DKV. Dapatkan rekomendasi karir terbaik dan kembangkan jaringan profesional Anda bersama IDN.
                </p>

                <!-- Search & Major Filter Bar -->
                <div class="pt-6 max-w-[674px] mx-auto">
                    <div class="bg-white p-2.5 sm:p-2 sm:pl-5 sm:pr-2.5 rounded-2xl sm:rounded-full border border-[#e9eaeb] shadow-[0px_4px_20px_rgba(0,0,0,0.06)] hover:border-[#c2d8f5] hover:shadow-[0px_6px_28px_rgba(12,97,207,0.1)] transition-all duration-200 flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 relative">
                        
                        <!-- Search Keyword Input -->
                        <div class="flex-1 flex items-center gap-3 px-3.5 sm:px-0 py-2 sm:py-1 bg-[#f8fafc] sm:bg-transparent rounded-xl sm:rounded-none border border-[#e2e8f0] sm:border-none w-full">
                            <svg class="w-5 h-5 text-[#0c61cf] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" 
                                   x-model="searchQuery" 
                                   placeholder="Pilih posisi atau kata kunci pekerjaan..." 
                                   class="w-full bg-transparent text-sm md:text-base text-[#181d27] placeholder-[#717680] focus:outline-none">
                            <button x-show="searchQuery && searchQuery.length > 0" 
                                    @click="searchQuery = ''" 
                                    type="button" 
                                    x-cloak
                                    class="text-[#717680] hover:text-[#181d27] p-1 shrink-0 transition-colors cursor-pointer"
                                    title="Hapus pencarian">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Divider -->
                        <div class="hidden sm:block w-px h-8 bg-[#e9eaeb] shrink-0"></div>

                        <!-- Jurusan Selection Dropdown -->
                        <div class="relative w-full sm:w-auto shrink-0" @click.outside="majorDropdownOpen = false">
                            <button @click="majorDropdownOpen = !majorDropdownOpen" 
                                    type="button" 
                                    class="w-full sm:w-auto px-4 py-2.5 rounded-xl sm:rounded-full text-sm font-medium text-[#414651] bg-[#f8fafc] hover:bg-[#f1f5f9] flex items-center justify-between sm:justify-start gap-2.5 border border-[#e2e8f0] transition-all duration-200 cursor-pointer">
                                <span class="text-[#717680] text-xs font-normal hidden sm:inline">Jurusan:</span>
                                <span x-text="selectedMajor === 'Semua' ? 'Pilih Jurusan' : selectedMajor" class="font-semibold text-[#0c61cf]"></span>
                                <svg class="w-4 h-4 text-[#717680] transition-transform duration-200 shrink-0" :class="{'rotate-180': majorDropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Popup Menu -->
                            <div x-show="majorDropdownOpen" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                 x-cloak
                                 class="absolute left-0 sm:left-auto sm:right-0 mt-2 w-full sm:w-52 bg-white rounded-2xl shadow-xl border border-[#e9eaeb] py-2 z-50 text-left overflow-hidden">
                                
                                <!-- Dropdown Header / All -->
                                <div @click="selectMajor('Semua')" 
                                     :class="selectedMajor === 'Semua' ? 'border-l-4 border-[#0c61cf] bg-[#f8fafc] font-semibold text-[#0c61cf]' : 'text-[#414651] hover:bg-[#f8fafc]'"
                                     class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between">
                                    <span>Semua Jurusan</span>
                                    <template x-if="selectedMajor === 'Semua'">
                                        <svg class="w-4 h-4 text-[#0c61cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                </div>

                                <!-- TKJ -->
                                <div @click="selectMajor('TKJ')" 
                                     :class="selectedMajor === 'TKJ' ? 'border-l-4 border-[#0c61cf] bg-[#f8fafc] font-semibold text-[#0c61cf]' : 'text-[#414651] hover:bg-[#f8fafc]'"
                                     class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between">
                                    <span>TKJ</span>
                                    <template x-if="selectedMajor === 'TKJ'">
                                        <svg class="w-4 h-4 text-[#0c61cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                </div>

                                <!-- RPL -->
                                <div @click="selectMajor('RPL')" 
                                     :class="selectedMajor === 'RPL' ? 'border-l-4 border-[#0c61cf] bg-[#f8fafc] font-semibold text-[#0c61cf]' : 'text-[#414651] hover:bg-[#f8fafc]'"
                                     class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between">
                                    <span>RPL</span>
                                    <template x-if="selectedMajor === 'RPL'">
                                        <svg class="w-4 h-4 text-[#0c61cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                </div>

                                <!-- DKV -->
                                <div @click="selectMajor('DKV')" 
                                     :class="selectedMajor === 'DKV' ? 'border-l-4 border-[#0c61cf] bg-[#f8fafc] font-semibold text-[#0c61cf]' : 'text-[#414651] hover:bg-[#f8fafc]'"
                                     class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between">
                                    <span>DKV</span>
                                    <template x-if="selectedMajor === 'DKV'">
                                        <svg class="w-4 h-4 text-[#0c61cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- Main Filtered Content Section -->
        <section class="w-full py-10 md:py-16">
            <div class="max-w-[1440px] mx-auto px-6 md:px-12 lg:px-[160px] grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Sidebar Filters Container -->
                <aside class="lg:col-span-3 bg-white p-6 rounded-[24px] border border-[#e9eaeb] shadow-sm space-y-6 shrink-0 sticky top-28">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-[#e9eaeb]">
                        <h3 class="font-semibold text-lg text-[#181d27]">Filter Pencarian</h3>
                        <button @click="resetFilters()" class="text-xs font-semibold text-[#0c61cf] hover:underline">
                            Reset All
                        </button>
                    </div>

                    <!-- Filter Group 1: Lokasi -->
                    <div class="space-y-3">
                        <div @click="toggleAccordion('location')" class="flex items-center justify-between cursor-pointer group">
                            <span class="font-semibold text-base text-[#181d27]">Lokasi</span>
                            <svg class="w-4 h-4 text-[#717680] transition-transform duration-200" :class="{'rotate-180': accordionOpen.location}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="accordionOpen.location" class="space-y-2 pt-1">
                            <template x-for="loc in locationOptions" :key="loc">
                                <label class="flex items-center gap-3 cursor-pointer text-sm text-[#414651] hover:text-[#181d27] select-none">
                                    <input type="checkbox" 
                                           :value="loc" 
                                           x-model="filterLocation" 
                                           @change="onCheckboxChange('filterLocation', loc)"
                                           class="w-4 h-4 rounded border-[#d0d5dd] text-[#0c61cf] focus:ring-[#0c61cf] accent-[#0c61cf]">
                                    <span x-text="loc"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="w-full h-px bg-[#e9eaeb]"></div>

                    <!-- Filter Group 2: Lokasi Kerja -->
                    <div class="space-y-3">
                        <div @click="toggleAccordion('workLocation')" class="flex items-center justify-between cursor-pointer group">
                            <span class="font-semibold text-base text-[#181d27]">Lokasi Kerja</span>
                            <svg class="w-4 h-4 text-[#717680] transition-transform duration-200" :class="{'rotate-180': accordionOpen.workLocation}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="accordionOpen.workLocation" class="space-y-2 pt-1">
                            <template x-for="wl in workLocationOptions" :key="wl">
                                <label class="flex items-center gap-3 cursor-pointer text-sm text-[#414651] hover:text-[#181d27] select-none">
                                    <input type="checkbox" 
                                           :value="wl" 
                                           x-model="filterWorkLocation" 
                                           @change="onCheckboxChange('filterWorkLocation', wl)"
                                           class="w-4 h-4 rounded border-[#d0d5dd] text-[#0c61cf] focus:ring-[#0c61cf] accent-[#0c61cf]">
                                    <span x-text="wl"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="w-full h-px bg-[#e9eaeb]"></div>

                    <!-- Filter Group 3: Tipe Kerja -->
                    <div class="space-y-3">
                        <div @click="toggleAccordion('workType')" class="flex items-center justify-between cursor-pointer group">
                            <span class="font-semibold text-base text-[#181d27]">Tipe Kerja</span>
                            <svg class="w-4 h-4 text-[#717680] transition-transform duration-200" :class="{'rotate-180': accordionOpen.workType}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="accordionOpen.workType" class="space-y-2 pt-1">
                            <template x-for="wt in workTypeOptions" :key="wt">
                                <label class="flex items-center gap-3 cursor-pointer text-sm text-[#414651] hover:text-[#181d27] select-none">
                                    <input type="checkbox" 
                                           :value="wt" 
                                           x-model="filterWorkType" 
                                           @change="onCheckboxChange('filterWorkType', wt)"
                                           class="w-4 h-4 rounded border-[#d0d5dd] text-[#0c61cf] focus:ring-[#0c61cf] accent-[#0c61cf]">
                                    <span x-text="wt"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="w-full h-px bg-[#e9eaeb]"></div>

                    <!-- Filter Group 4: Waktu Post -->
                    <div class="space-y-3">
                        <div @click="toggleAccordion('postTime')" class="flex items-center justify-between cursor-pointer group">
                            <span class="font-semibold text-base text-[#181d27]">Waktu Post</span>
                            <svg class="w-4 h-4 text-[#717680] transition-transform duration-200" :class="{'rotate-180': accordionOpen.postTime}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div x-show="accordionOpen.postTime" class="space-y-2 pt-1">
                            <template x-for="pt in postTimeOptions" :key="pt">
                                <label class="flex items-center gap-3 cursor-pointer text-sm text-[#414651] hover:text-[#181d27] select-none">
                                    <input type="checkbox" 
                                           :value="pt" 
                                           x-model="filterPostTime" 
                                           @change="onCheckboxChange('filterPostTime', pt)"
                                           class="w-4 h-4 rounded border-[#d0d5dd] text-[#0c61cf] focus:ring-[#0c61cf] accent-[#0c61cf]">
                                    <span x-text="pt"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                </aside>

                <!-- Right Job Cards Container -->
                <div class="lg:col-span-9 space-y-6">
                    
                    <!-- Result Summary Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-[#e9eaeb]">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-[#181d27]" x-text="`Menampilkan ${filteredJobs.length} dari 21 Lowongan Kerja`"></span>
                            <template x-if="selectedMajor !== 'Semua'">
                                <span class="bg-[#0c61cf]/10 text-[#0c61cf] text-xs font-semibold px-2.5 py-1 rounded-full" x-text="`Jurusan: ${selectedMajor}`"></span>
                            </template>
                        </div>

                        <!-- Active Filter Pills Summary -->
                        <div class="flex flex-wrap items-center gap-2">
                            <template x-for="loc in filterLocation.filter(l => l !== 'Semua')" :key="loc">
                                <span class="bg-slate-100 text-[#414651] text-xs font-medium px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <span x-text="loc"></span>
                                    <button @click="removeFilter('location', loc)" class="hover:text-red-500">&times;</button>
                                </span>
                            </template>
                            <template x-for="wl in filterWorkLocation.filter(w => w !== 'Semua')" :key="wl">
                                <span class="bg-blue-50 text-[#0c61cf] text-xs font-medium px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <span x-text="wl"></span>
                                    <button @click="removeFilter('workLocation', wl)" class="hover:text-red-500">&times;</button>
                                </span>
                            </template>
                            <template x-for="wt in filterWorkType.filter(t => t !== 'Semua')" :key="wt">
                                <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <span x-text="wt"></span>
                                    <button @click="removeFilter('workType', wt)" class="hover:text-red-500">&times;</button>
                                </span>
                            </template>
                            <template x-for="pt in filterPostTime.filter(p => p !== 'Semua')" :key="pt">
                                <span class="bg-emerald-50 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <span x-text="pt"></span>
                                    <button @click="removeFilter('postTime', pt)" class="hover:text-red-500">&times;</button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Job Cards Grid (3 Columns) - Exactly 21 Cards Matching Figma -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        <template x-for="job in filteredJobs" :key="job.id">
                            <div class="bg-white rounded-[20px] p-5 border border-[#e9eaeb] shadow-sm hover:shadow-md hover:border-[#0c61cf] transition-all duration-300 flex flex-col justify-between group min-h-[236px] cursor-pointer"
                                 @click="openJobDetail(job)">
                                
                                <div>
                                    <!-- Job Title & Salary -->
                                    <div class="space-y-1">
                                        <h3 class="text-base lg:text-lg font-bold text-[#181d27] group-hover:text-[#0c61cf] transition-colors line-clamp-1" x-text="job.title"></h3>
                                        <p class="text-[#0c61cf] font-semibold text-sm lg:text-base" x-text="job.salary"></p>
                                    </div>

                                    <!-- Job Tags & Source Platform -->
                                    <div class="flex flex-wrap items-center gap-2 my-3">
                                        <span class="bg-[#f8fafc] border border-[#e2e8f0] text-[#475569] text-xs font-medium px-2.5 py-1 rounded-md" x-text="job.workLocation"></span>
                                        <span class="bg-[#f8fafc] border border-[#e2e8f0] text-[#475569] text-xs font-medium px-2.5 py-1 rounded-md" x-text="job.workType"></span>
                                        <span class="bg-blue-50 border border-blue-200 text-[#0c61cf] text-xs font-semibold px-2.5 py-1 rounded-md" x-text="job.sourcePlatform || 'Mitra IDN'"></span>
                                    </div>

                                    <!-- Company Info -->
                                    <div class="flex items-center gap-3 pt-2">
                                        <div class="w-10 h-10 rounded-xl overflow-hidden flex items-center justify-center bg-white border border-[#e9eaeb] shrink-0 shadow-sm p-1">
                                            <template x-if="job.companyImg">
                                                <img :src="job.companyImg" :alt="job.companyName" class="w-full h-full object-cover object-left rounded-lg">
                                            </template>
                                            <template x-if="!job.companyImg">
                                                <div class="w-full h-full rounded-lg flex items-center justify-center text-white font-bold text-sm" :class="job.companyBg">
                                                    <span x-text="job.companyLogo"></span>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-sm font-semibold text-[#181d27] truncate" x-text="job.companyName"></p>
                                            <p class="text-xs text-[#717680] truncate" x-text="job.location"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Posted Time Footer -->
                                <div class="pt-3 mt-4 border-t border-[#f1f5f9] flex items-center justify-between text-xs text-[#717680]">
                                    <span x-text="job.postedTime"></span>
                                    <span class="text-[#0c61cf] font-semibold group-hover:underline flex items-center gap-1">
                                        Detail
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                </div>

                            </div>
                        </template>
                    </div>

                    <!-- Empty State -->
                    <template x-if="filteredJobs.length === 0">
                        <div class="text-center py-16 bg-white rounded-[20px] border border-[#e9eaeb] space-y-3">
                            <svg class="w-12 h-12 mx-auto text-[#717680]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m46 0v2m-6 0a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V10a2 2 0 00-2-2h-2m-4-3H9"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-[#181d27]">Lowongan Kerja Tidak Ditemukan</h3>
                            <p class="text-sm text-[#717680]">Coba atur ulang filter pencarian Anda atau pilih jurusan lain.</p>
                            <button @click="resetFilters()" class="inline-block mt-2 text-[#0c61cf] font-semibold text-sm hover:underline">Reset Semua Filter</button>
                        </div>
                    </template>

                </div>

            </div>
        </section>

        <!-- Job Detail Modal Dialog -->
        <div x-show="selectedJobModal !== null" 
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 md:p-6 bg-slate-900/60 backdrop-blur-md overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="closeJobModal()">
            
            <div class="bg-white rounded-[24px] sm:rounded-[28px] max-w-2xl w-full max-h-[92vh] flex flex-col shadow-[0_25px_70px_rgba(15,23,42,0.25)] relative border border-slate-100 overflow-hidden"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-3"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-3"
                 @click.outside="closeJobModal()">
                
                <!-- Top Brand Decorative Accent Bar -->
                <div class="h-1.5 w-full bg-gradient-to-r from-[#0c61cf] via-[#38bdf8] to-[#6366f1] shrink-0"></div>

                <template x-if="selectedJobModal">
                    <div class="flex flex-col flex-1 min-h-0 overflow-hidden">
                        
                        <!-- MODAL HEADER -->
                        <div class="p-6 md:p-7 pb-5 border-b border-slate-100 shrink-0 relative bg-white">
                            <!-- Close Button -->
                            <button @click="closeJobModal()" 
                                    class="absolute right-5 top-5 w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-all duration-200 cursor-pointer shadow-xs"
                                    title="Tutup Modal (Esc)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>

                            <div class="flex items-start gap-4 pr-10">
                                <!-- Company Logo Container -->
                                <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl overflow-hidden flex items-center justify-center bg-white border border-slate-100 shadow-md shrink-0 p-1.5 ring-1 ring-slate-900/5">
                                    <template x-if="selectedJobModal.companyImg">
                                        <img :src="selectedJobModal.companyImg" :alt="selectedJobModal.companyName" class="w-full h-full object-contain rounded-xl">
                                    </template>
                                    <template x-if="!selectedJobModal.companyImg">
                                        <div class="w-full h-full rounded-xl flex items-center justify-center text-white font-extrabold text-xl shadow-inner" :class="selectedJobModal.companyBg">
                                            <span x-text="selectedJobModal.companyLogo"></span>
                                        </div>
                                    </template>
                                </div>

                                <!-- Job Title & Company Information -->
                                <div class="space-y-1.5 flex-1 min-w-0">
                                    <!-- Badges Row -->
                                    <div class="flex flex-wrap items-center gap-2">
                                        <!-- Major Badge -->
                                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full"
                                              :class="{
                                                  'bg-blue-50 text-blue-700 border border-blue-200/80': selectedJobModal.major === 'RPL',
                                                  'bg-emerald-50 text-emerald-700 border border-emerald-200/80': selectedJobModal.major === 'TKJ',
                                                  'bg-purple-50 text-purple-700 border border-purple-200/80': selectedJobModal.major === 'DKV',
                                                  'bg-slate-100 text-slate-700 border border-slate-200/80': selectedJobModal.major !== 'RPL' && selectedJobModal.major !== 'TKJ' && selectedJobModal.major !== 'DKV'
                                              }"
                                              x-text="`Jurusan: ${selectedJobModal.major}`">
                                        </span>

                                        <!-- Status Badge -->
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Lowongan Aktif</span>
                                        </span>

                                        <!-- Source Platform -->
                                        <span class="hidden sm:inline-flex items-center gap-1 text-xs text-slate-500 font-medium bg-slate-50 border border-slate-200/70 px-2 py-0.5 rounded-full">
                                            <svg class="w-3 h-3 text-[#0c61cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            <span x-text="selectedJobModal.sourcePlatform || 'Mitra Resmi IDN'"></span>
                                        </span>
                                    </div>

                                    <!-- Job Title -->
                                    <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-[#0f172a] leading-tight tracking-tight break-words" x-text="selectedJobModal.title"></h2>

                                    <!-- Company Name & Verified Badge -->
                                    <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-slate-600">
                                        <span class="font-semibold text-[#0c61cf] hover:underline" x-text="selectedJobModal.companyName"></span>
                                        <span class="inline-flex items-center gap-0.5 text-blue-600" title="Mitra Industri Terverifikasi">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </span>
                                        <span class="text-slate-300">·</span>
                                        <span class="flex items-center gap-1 text-slate-500">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span x-text="selectedJobModal.location"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL SCROLLABLE BODY -->
                        <div class="p-6 md:p-7 space-y-6 overflow-y-auto flex-1 custom-scrollbar bg-white">
                            
                            <!-- Highlight Salary & Work Mode Box -->
                            <div class="bg-gradient-to-br from-blue-50/70 via-indigo-50/40 to-slate-50 border border-blue-100 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
                                <div>
                                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-[#0c61cf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Estimasi Gaji Bulanan
                                    </span>
                                    <p class="text-xl sm:text-2xl font-black text-[#0c61cf] mt-0.5 tracking-tight" x-text="selectedJobModal.salary"></p>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-200/80 shadow-xs flex items-center gap-1.5 text-xs font-semibold text-[#181d27]">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m46 0v2m-6 0a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V10a2 2 0 00-2-2h-2m-4-3H9"/></svg>
                                        <span x-text="selectedJobModal.workType"></span>
                                    </div>
                                    <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-200/80 shadow-xs flex items-center gap-1.5 text-xs font-semibold text-[#181d27]">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                                        <span x-text="selectedJobModal.workLocation"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- 4 Key Specs Quick Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                                <div class="p-3 bg-slate-50/80 rounded-xl border border-slate-100 flex flex-col gap-1">
                                    <span class="text-slate-400 font-medium">Tipe Pekerjaan</span>
                                    <span class="font-bold text-slate-800 text-sm truncate" x-text="selectedJobModal.workType"></span>
                                </div>
                                <div class="p-3 bg-slate-50/80 rounded-xl border border-slate-100 flex flex-col gap-1">
                                    <span class="text-slate-400 font-medium">Sistem Kerja</span>
                                    <span class="font-bold text-slate-800 text-sm truncate" x-text="selectedJobModal.workLocation"></span>
                                </div>
                                <div class="p-3 bg-slate-50/80 rounded-xl border border-slate-100 flex flex-col gap-1">
                                    <span class="text-slate-400 font-medium">Rekomendasi</span>
                                    <span class="font-bold text-slate-800 text-sm truncate" x-text="`SMK ${selectedJobModal.major}`"></span>
                                </div>
                                <div class="p-3 bg-slate-50/80 rounded-xl border border-slate-100 flex flex-col gap-1">
                                    <span class="text-slate-400 font-medium">Waktu Posting</span>
                                    <span class="font-bold text-slate-800 text-sm truncate" x-text="selectedJobModal.postedTime"></span>
                                </div>
                            </div>

                            <!-- Requirements & Qualifications -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-[#0c61cf] flex items-center justify-center font-bold text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <h4 class="font-bold text-base text-[#0f172a]">Kualifikasi & Persyaratan</h4>
                                </div>

                                <div class="bg-[#f8fafc] p-4 sm:p-5 rounded-2xl border border-slate-200/80 text-sm text-slate-700 leading-relaxed">
                                    <template x-if="selectedJobModal.requirements">
                                        <div class="space-y-2 text-xs sm:text-sm text-slate-700">
                                            <template x-for="(req, idx) in selectedJobModal.requirements.split('\n').filter(r => r.trim() !== '')" :key="idx">
                                                <div class="flex items-start gap-2.5">
                                                    <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    <span class="flex-1" x-text="req.replace(/^[-*•]\s*/, '')"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="!selectedJobModal.requirements">
                                        <div class="space-y-2.5 text-xs sm:text-sm text-slate-700">
                                            <div class="flex items-start gap-2.5">
                                                <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <span>Lulusan atau santri aktif SMK IDN Boarding School jurusan terkait (<span x-text="selectedJobModal.major"></span>).</span>
                                            </div>
                                            <div class="flex items-start gap-2.5">
                                                <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <span>Memiliki portofolio karya nyata atau sertifikasi internasional pendukung.</span>
                                            </div>
                                            <div class="flex items-start gap-2.5">
                                                <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <span>Memiliki etos kerja tinggi, disiplin, berakhlak mulia, dan siap berkembang di industri.</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Career Center Trust Banner -->
                            <div class="bg-blue-50/60 border border-blue-200/60 rounded-2xl p-3.5 flex items-start gap-3 text-xs text-blue-900 leading-relaxed">
                                <svg class="w-5 h-5 text-[#0c61cf] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <div>
                                    <span class="font-bold">Fasilitas Penyaluran Kerja Resmi:</span>
                                    <span> Lowongan ini diverifikasi dan dikurasi oleh tim Career Center IDN untuk mempermudah santri dan alumni mendapatkan karir impian di industri teknologi.</span>
                                </div>
                            </div>

                        </div>

                        <!-- MODAL STICKY FOOTER -->
                        <div class="p-4 sm:p-5 md:px-7 border-t border-slate-100 bg-slate-50/90 flex flex-col-reverse sm:flex-row items-center justify-between gap-3 shrink-0">
                            <button @click="closeJobModal()" 
                                    type="button"
                                    class="w-full sm:w-auto px-6 py-2.5 rounded-full border border-slate-200 bg-white text-slate-600 hover:text-slate-900 hover:border-slate-300 font-semibold text-sm transition-all duration-150 cursor-pointer shadow-xs text-center">
                                Tutup
                            </button>

                            <div class="w-full sm:w-auto flex items-center gap-3">
                                <template x-if="selectedJobModal.applyUrl">
                                    <a :href="selectedJobModal.applyUrl" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#0c61cf] to-[#094fa5] hover:from-[#094fa5] hover:to-[#073d82] text-white py-2.5 px-6 rounded-full font-semibold text-sm shadow-md shadow-blue-500/20 hover:shadow-lg transition-all duration-200 group">
                                        <span>Lamar di <span x-text="selectedJobModal.sourcePlatform || 'Portal Resmi'"></span></span>
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </template>
                                <template x-if="!selectedJobModal.applyUrl">
                                    <a :href="`https://wa.me/6282210102006?text=${encodeURIComponent('Halo Admin Career Center IDN, saya ingin melamar posisi ' + selectedJobModal.title + ' di ' + selectedJobModal.companyName + ' (ID Lowongan #' + selectedJobModal.id + ')')}`" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#0c61cf] to-[#094fa5] hover:from-[#094fa5] hover:to-[#073d82] text-white py-2.5 px-6 rounded-full font-semibold text-sm shadow-md shadow-blue-500/20 hover:shadow-lg transition-all duration-200 group">
                                        <span>Lamar via Admin Career Center</span>
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </template>
                            </div>
                        </div>

                    </div>
                </template>
            </div>
        </div>
    </main>

    <!-- Footer Component -->
    <x-footer />

    <!-- Chatbot Component -->
    <x-chatbot />

    <!-- Alpine.js Application Logic -->
    <script>
        function careerCenterData() {
            return {
                selectedMajor: 'Semua',
                searchQuery: '',
                majorDropdownOpen: false,
                selectedJobModal: null,

                // Accordions state
                accordionOpen: {
                    location: true,
                    workLocation: true,
                    workType: true,
                    postTime: true
                },

                // Active Filters (default to 'Semua' checked on page load)
                filterLocation: ['Semua'],
                filterWorkLocation: ['Semua'],
                filterWorkType: ['Semua'],
                filterPostTime: ['Semua'],

                // Filter options matching Figma UI
                locationOptions: ['Semua', 'Jabodetabek', 'Jawa', 'Kalimantan', 'Sumatra', 'Sulawesi', 'Papua', 'Other'],
                workLocationOptions: ['Semua', 'Onsite', 'Hybrid', 'Remote/WFH'],
                workTypeOptions: ['Semua', 'Full-time', 'Part-time', 'Contract', 'Internship', 'Freelance'],
                postTimeOptions: ['Semua', 'Hari ini', 'Minggu ini', 'Bulan ini', 'Tahun ini'],
                // Dynamic Jobs injected from Database (managed via Super Admin Panel)
                jobs: @json($jobs ?? []),

                init() {
                    // Lock background body & html scroll whenever a modal is open
                    this.$watch('selectedJobModal', (val) => {
                        if (val) {
                            document.body.style.overflow = 'hidden';
                            document.documentElement.style.overflow = 'hidden';
                        } else {
                            document.body.style.overflow = '';
                            document.documentElement.style.overflow = '';
                        }
                    });
                },

                selectMajor(major) {
                    this.selectedMajor = major;
                    this.majorDropdownOpen = false;
                },

                applySearch() {
                    this.majorDropdownOpen = false;
                },

                toggleAccordion(key) {
                    this.accordionOpen[key] = !this.accordionOpen[key];
                },

                onCheckboxChange(filterKey, clickedVal) {
                    let list = this[filterKey];
                    if (clickedVal === 'Semua') {
                        if (list.includes('Semua')) {
                            // If 'Semua' is checked, clear specific options and keep 'Semua'
                            this[filterKey] = ['Semua'];
                        } else if (list.length === 0) {
                            // If user unchecks 'Semua' and nothing else is selected, revert back to 'Semua'
                            this[filterKey] = ['Semua'];
                        }
                    } else {
                        if (list.includes(clickedVal)) {
                            // When specific option is checked, remove 'Semua'
                            this[filterKey] = list.filter(item => item !== 'Semua');
                        } else if (list.length === 0) {
                            // If user unchecks specific option and list becomes empty, revert back to 'Semua'
                            this[filterKey] = ['Semua'];
                        }
                    }
                },

                resetFilters() {
                    this.selectedMajor = 'Semua';
                    this.searchQuery = '';
                    this.filterLocation = ['Semua'];
                    this.filterWorkLocation = ['Semua'];
                    this.filterWorkType = ['Semua'];
                    this.filterPostTime = ['Semua'];
                },

                removeFilter(type, value) {
                    if (type === 'location') {
                        this.filterLocation = this.filterLocation.filter(item => item !== value);
                        if (this.filterLocation.length === 0) this.filterLocation = ['Semua'];
                    } else if (type === 'workLocation') {
                        this.filterWorkLocation = this.filterWorkLocation.filter(item => item !== value);
                        if (this.filterWorkLocation.length === 0) this.filterWorkLocation = ['Semua'];
                    } else if (type === 'workType') {
                        this.filterWorkType = this.filterWorkType.filter(item => item !== value);
                        if (this.filterWorkType.length === 0) this.filterWorkType = ['Semua'];
                    } else if (type === 'postTime') {
                        this.filterPostTime = this.filterPostTime.filter(item => item !== value);
                        if (this.filterPostTime.length === 0) this.filterPostTime = ['Semua'];
                    }
                },

                openJobDetail(job) {
                    this.selectedJobModal = job;
                    document.body.style.overflow = 'hidden';
                    document.documentElement.style.overflow = 'hidden';
                },

                closeJobModal() {
                    this.selectedJobModal = null;
                    document.body.style.overflow = '';
                    document.documentElement.style.overflow = '';
                },

                get filteredJobs() {
                    return this.jobs.filter(job => {
                        // 1. Filter Major
                        if (this.selectedMajor !== 'Semua' && job.major !== this.selectedMajor) {
                            return false;
                        }

                        // 2. Filter Search Query
                        if (this.searchQuery.trim() !== '') {
                            const q = this.searchQuery.toLowerCase();
                            const matchTitle = job.title.toLowerCase().includes(q);
                            const matchCompany = job.companyName.toLowerCase().includes(q);
                            const matchLocation = job.location.toLowerCase().includes(q);
                            if (!matchTitle && !matchCompany && !matchLocation) {
                                return false;
                            }
                        }

                        // 3. Filter Lokasi (Region / City Filter)
                        if (this.filterLocation.length > 0 && !this.filterLocation.includes('Semua')) {
                            const matchGroup = this.filterLocation.includes(job.locationGroup);
                            const matchText = this.filterLocation.some(loc => 
                                job.location.toLowerCase().includes(loc.toLowerCase())
                            );
                            if (!matchGroup && !matchText) {
                                return false;
                            }
                        }

                        // 4. Filter Lokasi Kerja (Onsite, Hybrid, Remote/WFH)
                        if (this.filterWorkLocation.length > 0 && !this.filterWorkLocation.includes('Semua')) {
                            const normWorkLoc = this.filterWorkLocation.map(w => w.toLowerCase());
                            const jobWl = job.workLocation.toLowerCase();
                            const matchWl = normWorkLoc.includes(jobWl) || normWorkLoc.some(w => jobWl.includes(w));
                            if (!matchWl) {
                                return false;
                            }
                        }

                        // 5. Filter Tipe Kerja (Full-time, Contract, Internship, Freelance, Part-time)
                        if (this.filterWorkType.length > 0 && !this.filterWorkType.includes('Semua')) {
                            const normTypes = this.filterWorkType.map(t => t.toLowerCase().replace(/[\s-]/g, ''));
                            const jobType = job.workType.toLowerCase().replace(/[\s-]/g, '');
                            if (!normTypes.includes(jobType)) {
                                return false;
                            }
                        }

                        // 6. Filter Waktu Post (Hari ini, Minggu ini, Bulan ini, Tahun ini)
                        if (this.filterPostTime.length > 0 && !this.filterPostTime.includes('Semua')) {
                            const selectedPt = this.filterPostTime;
                            let matchPost = false;
                            
                            if (selectedPt.includes(job.postTimeCategory)) {
                                matchPost = true;
                            } else if (selectedPt.includes('Tahun ini')) {
                                matchPost = true; // All 21 jobs are within this year
                            } else if (selectedPt.includes('Bulan ini') && (job.postTimeCategory === 'Hari ini' || job.postTimeCategory === 'Minggu ini' || job.postTimeCategory === 'Bulan ini')) {
                                matchPost = true;
                            } else if (selectedPt.includes('Minggu ini') && (job.postTimeCategory === 'Hari ini' || job.postTimeCategory === 'Minggu ini')) {
                                matchPost = true;
                            }

                            if (!matchPost) {
                                return false;
                            }
                        }

                        return true;
                    });
                }
            }
        }
    </script>
</body>
</html>
