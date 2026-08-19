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

    <!-- NAVBAR HEADER -->
    <div class="w-full flex justify-center pt-8 pb-3.5 px-5 fixed top-0 left-0 z-50 backdrop-blur-md bg-white/40 border-b border-border-custom/40">
        <div class="w-[1120px] bg-white flex justify-between items-center py-2.5 px-6 rounded-full shadow-[0px_4px_15px_rgba(0,0,0,0.04)]">
            <a href="/" class="h-8 block">
                <img src="{{ asset('assets/logo_idn.png') }}" alt="Logo IDN" class="h-8 block">
            </a>
            <div class="flex gap-8 items-center max-md:hidden">
                <a href="/" class="text-base font-semibold text-text-muted transition-colors duration-200 hover:text-brand-primary">Beranda</a>
                <a href="#" class="text-base font-semibold text-text-muted transition-colors duration-200 hover:text-brand-primary">PPDB</a>
                <a href="#" class="text-base font-semibold text-text-muted transition-colors duration-200 hover:text-brand-primary">Tentang Kami</a>
                <a href="#" class="text-base font-semibold text-text-muted transition-colors duration-200 hover:text-brand-primary">Program</a>
                <a href="#" class="text-base font-semibold text-text-muted transition-colors duration-200 hover:text-brand-primary">Career Center</a>
                <a href="/artikel/idn-relawan-dan-markaz-bersama-as-sunnah-salurkan-bantuan-bencana-banjir-di-bali" class="text-base font-semibold text-brand-primary transition-colors duration-200">Artikel</a>
                <a href="#" class="text-base font-semibold text-text-muted transition-colors duration-200 hover:text-brand-primary">Kontak</a>
            </div>
            <a href="#" class="bg-brand-primary text-white py-2.5 px-5 rounded-full text-sm font-semibold shadow-[0px_2px_6px_rgba(12,97,207,0.32)] transition-all duration-200 hover:bg-brand-hover hover:-translate-y-px">Daftar PPDB</a>
        </div>
    </div>

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
        <div class="w-full bg-white border-t border-border-custom flex flex-col items-center pt-20 pb-10 px-5">
            <div class="w-[1120px] flex justify-between gap-10 mb-16 max-[1160px]:w-[90%] max-md:flex-col max-md:gap-10">
                <div class="w-[253px] flex flex-col gap-6">
                    <div class="footer-logo">
                        <img src="{{ asset('assets/logo_idn_footer.png') }}" alt="Logo IDN footer" class="h-[60px] block">
                    </div>
                    <p class="text-sm text-text-muted leading-normal">Pesantren berbasis IT yang membentuk generasi muslim penghafal Al-Qur'an, berkarakter, dan unggul di dunia teknologi.</p>
                    <div class="text-sm font-semibold text-brand-primary italic flex flex-col gap-1">
                        <span>#Jagoan IT Pinter Ngaji</span>
                        <span>#Muda Mendunia</span>
                    </div>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-full border border-border-custom flex items-center justify-center transition-all duration-200 hover:border-brand-primary hover:bg-brand-primary/5 hover:-translate-y-px"><img src="{{ asset('assets/instagram.svg') }}" alt="Instagram" class="w-5 h-5"></a>
                        <a href="#" class="w-10 h-10 rounded-full border border-border-custom flex items-center justify-center transition-all duration-200 hover:border-brand-primary hover:bg-brand-primary/5 hover:-translate-y-px"><img src="{{ asset('assets/youtube.svg') }}" alt="Youtube" class="w-5 h-5"></a>
                        <a href="#" class="w-10 h-10 rounded-full border border-border-custom flex items-center justify-center transition-all duration-200 hover:border-brand-primary hover:bg-brand-primary/5 hover:-translate-y-px"><img src="{{ asset('assets/facebook.svg') }}" alt="Facebook" class="w-5 h-5"></a>
                        <a href="#" class="w-10 h-10 rounded-full border border-border-custom flex items-center justify-center transition-all duration-200 hover:border-brand-primary hover:bg-brand-primary/5 hover:-translate-y-px"><img src="{{ asset('assets/whatsapp.svg') }}" alt="Whatsapp" class="w-5 h-5"></a>
                    </div>
                </div>
                
                <div class="flex gap-14 max-md:flex-col max-md:gap-8">
                    <div class="flex flex-col gap-4">
                        <span class="text-sm font-bold text-text-title">Menu Utama</span>
                        <div class="flex flex-col gap-2.5 text-sm text-text-muted">
                            <a href="#" class="hover:text-brand-primary">Beranda</a>
                            <a href="#" class="hover:text-brand-primary">PPDB</a>
                            <a href="#" class="hover:text-brand-primary">Tentang Kami</a>
                            <a href="#" class="hover:text-brand-primary">Program</a>
                            <a href="#" class="hover:text-brand-primary">Career Center</a>
                            <a href="#" class="hover:text-brand-primary">Artikel</a>
                            <a href="#" class="hover:text-brand-primary">Kontak</a>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <span class="text-sm font-bold text-text-title">Program</span>
                        <div class="flex flex-col gap-2.5 text-sm text-text-muted">
                            <a href="#" class="hover:text-brand-primary">PKL</a>
                            <a href="#" class="hover:text-brand-primary">IDN Mengajar</a>
                            <a href="#" class="hover:text-brand-primary">Ekstrakurikuler</a>
                            <a href="#" class="hover:text-brand-primary">Edurace</a>
                            <a href="#" class="hover:text-brand-primary">Live In</a>
                            <a href="#" class="hover:text-brand-primary">Business Survival</a>
                            <a href="#" class="hover:text-brand-primary">Backpacker</a>
                            <a href="#" class="hover:text-brand-primary">IT Camp</a>
                            <a href="#" class="hover:text-brand-primary">MPLS</a>
                            <a href="#" class="hover:text-brand-primary">IDN Bersyukur</a>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <span class="text-sm font-bold text-text-title">Artikel</span>
                        <div class="flex flex-col gap-2.5 text-sm text-text-muted">
                            <a href="#" class="hover:text-brand-primary">Prestasi</a>
                            <a href="#" class="hover:text-brand-primary">News & Event</a>
                        </div>
                    </div>
                </div>
                
                <div class="w-[236px] flex flex-col gap-4">
                    <span class="text-sm font-bold text-text-title">Informasi Sekolah</span>
                    <div class="flex flex-col gap-2.5 text-sm text-text-muted">
                        <div class="flex gap-3 items-start text-sm text-text-muted leading-tight">
                            <img src="{{ asset('assets/location.svg') }}" alt="Location icon" class="w-5 h-5 shrink-0 mt-0.5">
                            <span>Jl. Raya Jonggol-Dayeuh, Sukanegara, Kec. Jonggol, Kabupaten Bogor, Jawa Barat 16830</span>
                        </div>
                        <div class="flex gap-3 items-start text-sm text-text-muted leading-tight">
                            <img src="{{ asset('assets/phone.svg') }}" alt="Phone icon" class="w-5 h-5 shrink-0 mt-0.5">
                            <span>+62 822-1010-2006</span>
                        </div>
                        <div class="flex gap-3 items-start text-sm text-text-muted leading-tight">
                            <img src="{{ asset('assets/gmail.svg') }}" alt="Email icon" class="w-5 h-5 shrink-0 mt-0.5">
                            <span>idnboardingschool@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w-[1120px] rounded-3xl border-8 border-black/5 overflow-hidden mb-12 h-[360px] max-[1160px]:w-[90%]">
                <img src="{{ asset('assets/map_frame.png') }}" alt="School map" class="w-full h-full object-cover block">
            </div>
            
            <div class="w-[1120px] border-t border-border-custom pt-8 flex justify-between items-center max-[1160px]:w-[90%] max-md:flex-col max-md:gap-4">
                <span class="text-sm text-text-muted">© Copyright | 2026 IDN Boarding School.</span>
                <div class="flex items-center gap-4">
                    <div class="partner-logo"><img src="{{ asset('assets/logo_jhic.png') }}" alt="Partner 1" class="h-6 object-contain block"></div>
                    <div class="w-px h-6 bg-border-custom"></div>
                    <div class="partner-logo"><img src="{{ asset('assets/logo_jagoanhosting.png') }}" alt="Partner 2" class="h-6 object-contain block"></div>
                    <div class="w-px h-6 bg-border-custom"></div>
                    <div class="partner-logo"><img src="{{ asset('assets/logo_komdigi.png') }}" alt="Partner 3" class="h-6 object-contain block"></div>
                    <div class="w-px h-6 bg-border-custom"></div>
                    <div class="partner-logo"><img src="{{ asset('assets/logo_garuda.png') }}" alt="Partner 4" class="h-6 object-contain block"></div>
                    <div class="w-px h-6 bg-border-custom"></div>
                    <div class="partner-logo"><img src="{{ asset('assets/logo_ngalup.png') }}" alt="Partner 5" class="h-6 object-contain block"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- FLOATING AI CS CHATBOT WIDGET -->
    <div class="fixed bottom-8 right-8 z-[9999] flex flex-col items-end max-md:bottom-4 max-md:right-4">
        
        <!-- Chat Window Card -->
        <div id="chatWindow" class="w-[380px] h-[560px] max-h-[calc(100vh-120px)] max-md:w-[calc(100vw-32px)] max-md:h-[520px] bg-white border border-[#e9eaeb] rounded-3xl shadow-[0_20px_50px_rgba(15,23,42,0.15),0_0_1px_rgba(15,23,42,0.1)] mb-4 flex flex-col overflow-hidden origin-bottom-right scale-0 opacity-0 pointer-events-none transition-all duration-350 ease-[cubic-bezier(0.16,1,0.3,1)] [&.active]:scale-100 [&.active]:opacity-100 [&.active]:pointer-events-auto">
            
            <!-- Header -->
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-500 text-white p-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-[42px] h-[42px] rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-2xl relative">
                        👩‍💼
                        <div class="absolute -bottom-0.5 -right-0.5 w-[11px] h-[11px] bg-emerald-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <h4 class="font-heading text-base font-bold mb-0.5 text-white">AI Customer Service</h4>
                        <span class="text-xs text-white/85 font-medium flex items-center gap-1">● Virtual Assistant Online</span>
                    </div>
                </div>
                <div>
                    <button class="bg-white/15 hover:bg-white/30 text-white w-8 h-8 rounded-lg cursor-pointer flex items-center justify-center text-sm transition-colors" title="Tutup Chat" onclick="toggleChat()">✕</button>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="chatMessages" class="flex-1 bg-slate-50 p-5 overflow-y-auto flex flex-col gap-4 [scrollbar-width:thin] [scrollbar-color:#cbd5e1_transparent]">
                <!-- Welcome Message -->
                <div class="flex gap-2.5 max-w-[85%] animate-fade-in self-start">
                    <div class="w-[30px] h-[30px] rounded-lg bg-white border border-[#e9eaeb] flex items-center justify-center text-sm shrink-0 shadow-sm">👩‍💼</div>
                    <div class="p-3 px-4 rounded-2xl rounded-tl-xs text-sm leading-relaxed break-words bg-white border border-[#e9eaeb] text-[#181d27] shadow-sm">
                        Halo, selamat datang! Saya adalah Asisten AI yang siap membantu menjawab pertanyaan dan memberikan informasi yang Anda butuhkan. Silakan tanyakan apa saja yang ingin Anda ketahui!
                    </div>
                </div>
            </div>

            <!-- Input Bar -->
            <div class="p-3.5 px-4 bg-white border-t border-[#e9eaeb] flex gap-2 items-center">
                <input type="text" id="userInput" class="flex-1 bg-slate-100 border border-transparent text-[#181d27] py-2.5 px-4 rounded-full text-sm outline-none transition-all focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 placeholder:text-[#717680] placeholder:text-xs" placeholder="Ketik pesan Anda di sini..." autocomplete="off">
                <button id="sendBtn" class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-indigo-500 text-white cursor-pointer flex items-center justify-center text-base transition-transform hover:scale-105 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed shrink-0" onclick="sendMessage()">➤</button>
            </div>
            
        </div>

        <!-- Floating Toggle Button -->
        <button class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-600 to-indigo-500 cursor-pointer shadow-[0_10px_25px_rgba(79,70,229,0.4)] flex items-center justify-center text-white text-3xl relative transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:scale-110 hover:rotate-6 hover:shadow-[0_14px_30px_rgba(79,70,229,0.6)] active:scale-95" onclick="toggleChat()" title="Buka Virtual Assistant">
            <span class="absolute -inset-1 rounded-full border-2 border-indigo-500/50 animate-ping pointer-events-none"></span>
            💬
            <span class="absolute -top-1 -right-1 bg-emerald-500 text-white text-[0.65rem] font-bold px-2 py-0.5 rounded-full border-2 border-white uppercase tracking-wider shadow-sm">AI</span>
        </button>

    </div>

    <!-- Javascript Logic for Chatbot -->
    <script>
        const BASE_URL = "{{ rtrim(env('FASTAPI_CHATBOT_URL', 'https://fast-api-g0de.onrender.com'), '/') }}";
        const API_KEY = "fastapichatbotbackend@2026";

        let isChatOpen = false;
        let activeConversationId = null;
        let activeResponseId = null;
        let isWaitingResponse = false;

        const chatWindow = document.getElementById("chatWindow");
        const chatMessages = document.getElementById("chatMessages");
        const userInput = document.getElementById("userInput");
        const sendBtn = document.getElementById("sendBtn");

        function toggleChat() {
            isChatOpen = !isChatOpen;
            if (isChatOpen) {
                chatWindow.classList.add("active");
                setTimeout(() => userInput.focus(), 300);
            } else {
                chatWindow.classList.remove("active");
            }
        }

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        userInput.addEventListener("keydown", function(e) {
            if (e.key === "Enter" && !isWaitingResponse) {
                sendMessage();
            }
        });

        async function sendMessage() {
            const text = userInput.value.trim();
            if (!text || isWaitingResponse) return;

            appendMessage("user", text);
            userInput.value = "";
            isWaitingResponse = true;
            sendBtn.disabled = true;

            const typingId = "typing-" + Date.now();
            appendTypingIndicator(typingId);
            scrollToBottom();

            try {
                if (!activeConversationId) {
                    try {
                        const initRes = await fetch('/api/chatbot/conversations', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            }
                        });
                        if (initRes.ok) {
                            const initData = await initRes.json();
                            activeConversationId = initData.conversation_id;
                        }
                    } catch (err) {
                        console.warn("Gagal inisialisasi sesi:", err);
                    }
                }

                const payload = { message: text };
                if (activeConversationId) payload.conversation_id = activeConversationId;
                if (activeResponseId) payload.previous_response_id = activeResponseId;

                const response = await fetch('/api/chatbot/chat', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(payload)
                });

                removeElement(typingId);

                if (!response.ok) {
                    let errDetail = "Terjadi kesalahan pada server.";
                    try {
                        const errJson = await response.json();
                        errDetail = errJson.detail || errDetail;
                    } catch (e) {}

                    if (response.status === 401) {
                        appendMessage("error", `<b>Akses Ditolak (401 Unauthorized):</b><br>API Key tidak cocok.`);
                    } else if (response.status === 429) {
                        appendMessage("error", `<b>Rate Limit Tercapai (429):</b><br>Anda mengirim pesan terlalu cepat.`);
                    } else {
                        appendMessage("error", `<b>Error (${response.status}):</b><br>${errDetail}`);
                    }
                } else {
                    const data = await response.json();
                    if (data.response_id) activeResponseId = data.response_id;
                    if (data.conversation_id) activeConversationId = data.conversation_id;

                    appendMessage("bot", formatText(data.response));
                }

            } catch (error) {
                console.error("Fetch error:", error);
                removeElement(typingId);
                appendMessage("error", `<b>Gagal Menghubungi Server:</b><br>Pastikan server backend online.`);
            } finally {
                isWaitingResponse = false;
                sendBtn.disabled = false;
                scrollToBottom();
                userInput.focus();
            }
        }

        function appendMessage(sender, htmlContent) {
            const msgDiv = document.createElement("div");
            const isUser = sender === 'user';
            const isError = sender === 'error';
            
            msgDiv.className = `flex gap-2.5 max-w-[85%] animate-fade-in ${isUser ? 'self-end flex-row-reverse' : 'self-start'}`;
            
            const avatar = isUser ? '👤' : (isError ? '⚠️' : '👩‍💼');
            const avatarBg = isUser ? 'bg-indigo-600 text-white border-none' : 'bg-white border border-[#e9eaeb]';
            const bubbleBg = isUser 
                ? 'bg-gradient-to-br from-indigo-600 to-indigo-500 text-white rounded-tr-xs shadow-md' 
                : (isError ? 'bg-red-50 border border-red-200 text-red-700 rounded-tl-xs' : 'bg-white border border-[#e9eaeb] text-[#181d27] rounded-tl-xs shadow-sm');
            
            msgDiv.innerHTML = `
                <div class="w-[30px] h-[30px] rounded-lg ${avatarBg} flex items-center justify-center text-sm shrink-0 shadow-sm">${avatar}</div>
                <div class="p-3 px-4 rounded-2xl text-sm leading-relaxed break-words ${bubbleBg}">${htmlContent}</div>
            `;
            chatMessages.appendChild(msgDiv);
        }

        function appendTypingIndicator(id) {
            const typingDiv = document.createElement("div");
            typingDiv.id = id;
            typingDiv.className = "flex gap-2.5 max-w-[85%] animate-fade-in self-start";
            typingDiv.innerHTML = `
                <div class="w-[30px] h-[30px] rounded-lg bg-white border border-[#e9eaeb] flex items-center justify-center text-sm shrink-0 shadow-sm">👩‍💼</div>
                <div class="flex gap-1 p-3.5 px-4 bg-white border border-[#e9eaeb] rounded-2xl rounded-tl-xs w-fit shadow-sm">
                    <div class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-chat-bounce [animation-delay:-0.32s]"></div>
                    <div class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-chat-bounce [animation-delay:-0.16s]"></div>
                    <div class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-chat-bounce"></div>
                </div>
            `;
            chatMessages.appendChild(typingDiv);
        }

        function removeElement(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        function formatText(text) {
            if (!text) return "";
            let formatted = text.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
            formatted = formatted.replace(/\*(.*?)\*/g, '<i>$1</i>');
            formatted = formatted.replace(/\n/g, '<br>');
            return formatted;
        }
    </script>

</body>
</html>
