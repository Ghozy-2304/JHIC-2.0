<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} | IDN Boarding School</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Funnel+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Vite Import -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fafafa] text-text-main font-sans min-height-screen overflow-x-hidden leading-normal">

    <!-- REUSABLE NAVBAR COMPONENT -->
    <x-navbar active="artikel" />


    <!-- MAIN BODY -->
    <div class="mt-[106px] w-full flex flex-col items-center">
        
        <!-- HEADER SECTION -->
        <div class="w-[1120px] pt-[60px] pb-5 flex flex-col gap-6 max-[1160px]:w-[90%] px-5">
            <a href="/" class="flex items-center gap-2 text-text-muted text-base font-medium cursor-pointer transition-colors duration-200 hover:text-brand-primary self-start">
                <img src="{{ asset('assets/arrow_left.svg') }}" alt="Back icon" class="w-5 h-5 ">
                Kembali ke artikel
            </a>
            
            <h1 class="font-heading text-5xl font-bold leading-tight text-text-title tracking-[-1.5px] max-md:text-3xl">
                @php
                    // Dynamically style the last part of the title if it contains specific text (as in Figma)
                    $title = $article->title;
                    if (str_contains($title, 'Bantuan Bencana Banjir di Bali')) {
                        $parts = explode('Bantuan Bencana Banjir di Bali', $title);
                        echo $parts[0] . '<span class="text-brand-primary">Bantuan Bencana Banjir di Bali</span>' . ($parts[1] ?? '');
                    } else {
                        echo htmlspecialchars($title);
                    }
                @endphp
            </h1>
            
            <div class="flex items-center gap-3 text-sm text-text-muted">
                <div class="flex items-center gap-1.5">
                    <img src="{{ asset('assets/calendar.svg') }}" alt="Calendar icon" class="w-4 h-4">
                    <span>{{ date('d F Y', strtotime($article->published_at)) }}</span>
                </div>
                <div class="w-px h-3.5 bg-border-custom"></div>
                <div class="flex items-center gap-1.5">
                    <span>{{ $article->category }}</span>
                </div>
                <div class="w-px h-3.5 bg-border-custom"></div>
                <div class="flex items-center gap-1.5">
                    <span>Waktu baca: {{ $article->read_time }}</span>
                </div>
            </div>
        </div>

        <!-- MAIN LAYOUT GRID -->
        <div class="w-[1120px] grid grid-cols-[745px_350px] gap-[25px] pb-[60px] max-[1160px]:w-[90%] max-[1160px]:grid-cols-1 max-[1160px]:gap-10">
            
            <!-- LEFT COLUMN (Main Content) -->
            <div class="flex flex-col gap-10">
                    <img src="{{ asset('assets/' . $article->image) }}" alt="{{ $article->title }}" class="w-full block h-[482px] max-md:h-[300px] shrink-0 object-cover object-top">
                
                <div class="text-text-muted text-base font-medium leading-[1.625] text-justify flex flex-col gap-5">
                    {!! $article->content !!}
                </div>
                
                <!-- CTA & Inquiry Box -->
                <div class="border-t border-border-custom pt-6 flex flex-col gap-4">
                    <h2 class="text-2xl font-semibold text-text-main leading-tight">Mau jadi langganan juara kompetisi dan dibimbing di Boarding School Islami terbaik?</h2>
                    <div class="text-text-muted text-base leading-[1.625] flex flex-col gap-3">
                        <p>Baca juga artikel lain tentang prestasi siswa SMK IDN <a href="https://idn.sch.id/blog" target="_blank" class="text-brand-primary underline font-semibold hover:text-brand-hover">di sini</a>.</p>
                        <p>Semoga bermanfaat.</p>
                        <p>Kunjungi youtube kami: <a href="https://www.youtube.com/@IDNTV2022" target="_blank" class="text-brand-primary underline font-semibold hover:text-brand-hover">https://www.youtube.com/@IDNTV2022</a></p>
                        
                        <p class="mt-2.5">Ada yang ingin ditanyakan? Silahkan konsultasikan dengan Admin Kami.</p>
                        <p>Hubungi Kami (Admin): <strong>0822 – 1010 – 2006</strong></p>
                        
                        <p class="mt-2.5">Klik link di bawah ini untuk melihat semua cabang sekolah kami Ikhwan & Akhwat:<br>
                        – Pamijahan<br>
                        – Solo<br>
                        – Sentul<br>
                        – Jonggol<br>
                        – Akhwat<br>
                        – Malang</p>
                        
                        <p class="mt-2.5"><strong>Kita Sharing Bareng Yuk</strong><br>
                        Like, Comment & Share<br>
                        Mau Tau Lebih Banyak Edukasi Bermanfaat? Follow sosial media kami:<br>
                        Jonggol: <a href="https://www.instagram.com/idnboardingschool/" target="_blank" class="text-brand-primary underline font-semibold hover:text-brand-hover">@idnboardingschool</a><br>
                        Solo: <a href="https://www.instagram.com/idnboardingschoolsolo/" target="_blank" class="text-brand-primary underline font-semibold hover:text-brand-hover">@idnboardingschoolsolo</a><br>
                        Pamijahan: <a href="https://www.instagram.com/idnboardingschoolpmjbogor/" target="_blank" class="text-brand-primary underline font-semibold hover:text-brand-hover">@idnboardingschoolpmjbogor</a><br>
                        Sentul: <a href="https://www.instagram.com/idnboardingschoolsentul/" target="_blank" class="text-brand-primary underline font-semibold hover:text-brand-hover">@idnboardingschoolsentul</a><br>
                        IDN Akhwat: <a href="https://www.instagram.com/smpsmk.idnakhwat/" target="_blank" class="text-brand-primary underline font-semibold hover:text-brand-hover">@smpsmk.idnakhwat</a></p>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN (Sidebar Related Articles) -->
            <div class="flex flex-col gap-5">
                @foreach($relatedArticles as $related)
                    <a href="{{ route('articles.show', $related->slug) }}" class="bg-white rounded-xl border border-border-custom p-4 flex gap-4 items-center shadow-[0px_2px_6px_rgba(0,0,0,0.02)] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0px_8px_20px_rgba(0,0,0,0.05)]">
                        <div class="w-[100px] h-[100px] rounded-lg overflow-hidden shrink-0">
                            <img src="{{ asset('assets/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2">
                            <h3 class="text-sm font-semibold text-text-main leading-snug line-clamp-3">{{ $related->title }}</h3>
                            <div class="flex items-center gap-1.5 text-xs text-text-muted">
                                <div class="flex items-center gap-1">
                                    <img src="{{ asset('assets/calendar_alt.svg') }}" alt="Calendar small" class="w-3.5 h-3.5">
                                    <span>{{ date('d F', strtotime($related->published_at)) }}</span>
                                </div>
                                <div class="w-px h-2.5 bg-border-custom"></div>
                                <span>{{ $related->category }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
        </div>

        <!-- PPDB BANNER SECTION -->
        <div class="w-[1120px] mb-20 max-[1160px]:w-[90%]">
            <div class="bg-brand-primary rounded-[20px] p-10 relative overflow-hidden flex flex-col gap-8 shadow-[0px_10px_30px_rgba(12,97,207,0.2)] after:content-[''] after:absolute after:w-[390px] after:h-[423px] after:bg-white/12 after:blur-[64px] after:rounded-full after:-top-[203px] after:-right-[100px] after:pointer-events-none">
                <div class="max-w-[672px] flex flex-col gap-4 z-10">
                    <span class="text-white/80 text-sm font-medium">PPDB 2027/2028</span>
                    <h2 class="font-heading text-5xl font-bold text-white leading-tight tracking-[-1px] max-md:text-3xl"><span class="text-brand-orange">Kuota terbatas.</span> Ambil langkahmu hari ini.</h2>
                    <p class="text-white/85 text-base leading-normal">Gelombang 1 dibuka hingga kuota per jurusan terpenuhi. Daftar sekarang untuk mengamankan tempat dan mendapatkan potongan uang masuk.</p>
                </div>
                <div class="flex gap-4 items-center z-10">
                    <a href="#" class="bg-white text-brand-primary py-3 px-6 rounded-full text-base font-semibold transition-all duration-200 hover:scale-[1.01] hover:shadow-[0px_4px_15px_rgba(255,255,255,0.2)]">Mulai Pendaftaran</a>
                    <a href="#" class="bg-transparent text-white border border-border-custom py-3 px-6 rounded-full text-base font-semibold transition-all duration-200 hover:bg-white/10 hover:scale-[1.01]">Tanya Via WhatsApp</a>
                </div>
            </div>
        </div>

        <!-- FOOTER SECTION -->
        <x-footer />

    <!-- REUSABLE CHATBOT COMPONENT -->
    <x-chatbot />

</body>
</html>
