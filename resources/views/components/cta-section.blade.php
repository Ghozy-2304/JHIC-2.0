@props([
    'subtitle' => 'PPDB 2027/2028',
    'titlePrefix' => 'Kuota terbatas.',
    'titleSuffix' => 'Ambil langkahmu hari ini.',
    'description' => 'Gelombang 1 dibuka hingga kuota per jurusan terpenuhi. Daftar sekarang untuk mengamankan tempat dan mendapatkan potongan uang masuk.',
    'primaryBtnText' => 'Mulai Pendaftaran',
    'primaryBtnUrl' => 'https://psb.idn.sch.id/',
    'secondaryBtnText' => 'Tanya Via WhatsApp',
    'secondaryBtnUrl' => 'https://wa.me/6282210102006',
    'bgClass' => 'bg-[#fafafa]',
    'paddingClass' => 'py-12 md:py-[90px] px-6 md:px-[64px]',
])

<section class="w-full max-w-full overflow-hidden flex flex-col items-center {{ $paddingClass }} {{ $bgClass }}">
    <div class="w-full max-w-[1120px] xl:max-w-[1280px] 2xl:max-w-[1360px] mx-auto bg-[#0c61cf] rounded-[20px] p-6 sm:p-[40px] min-h-[364px] text-white flex flex-col justify-between gap-6 md:gap-8 relative overflow-hidden shadow-lg">
        <div class="w-[390px] h-[423px] rounded-full bg-white/20 blur-[64px] absolute -right-20 -top-40 pointer-events-none"></div>

        <div class="flex flex-col gap-4 z-10 max-w-[672px]">
            @if($subtitle)
                <span class="text-[#d5d7da] text-[14px]">{{ $subtitle }}</span>
            @endif
            <h2 class="font-heading font-bold text-[28px] sm:text-[36px] md:text-[48px] leading-[36px] sm:leading-[46px] md:leading-[60px] tracking-[-1.5px] md:tracking-[-1.92px]">
                <span class="text-[#ff7a29]">{{ $titlePrefix }}</span> {{ $titleSuffix }}
            </h2>
            @if($description)
                <p class="text-[#d5d7da] text-[15px] md:text-[16px] leading-[24px]">
                    {{ $description }}
                </p>
            @endif
        </div>

        <!-- BUTTONS CONTAINER -->
        <div class="flex flex-wrap items-center gap-4 z-10">
            @if($primaryBtnText)
                <a href="{{ $primaryBtnUrl }}" class="group bg-white text-[#0c61cf] px-6 py-3 rounded-full font-semibold text-[15px] md:text-[16px] leading-none h-[48px] flex items-center justify-center gap-2 shadow-sm transition-all duration-200 hover:bg-slate-100 hover:shadow-md">
                    <span>{{ $primaryBtnText }}</span>
                    <svg class="w-4 h-4 transition-transform duration-200 ease-out group-hover:translate-x-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            @endif
            @if($secondaryBtnText)
                <a href="{{ $secondaryBtnUrl }}" target="_blank" class="group bg-[#0c61cf] border border-[#d5d7da] text-white px-6 py-3 rounded-full font-semibold text-[15px] md:text-[16px] leading-none h-[48px] flex items-center justify-center gap-2 transition-all duration-200 hover:bg-[#094fa5] hover:border-white">
                    <span>{{ $secondaryBtnText }}</span>
                    <svg class="w-4 h-4 transition-transform duration-200 ease-out group-hover:translate-x-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</section>
