<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        @if(file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @elseif(file_exists(public_path('css/tailwind.css')))
            <style>
                {!! file_get_contents(public_path('css/tailwind.css')) !!}
            </style>
        @else
            <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
        @endif
    </head>
    <body class="bg-white text-slate-800 min-h-screen w-screen overflow-x-hidden font-sans">

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

    <!-- Javascript Logic -->
    <script>
        // Konfigurasi API tetap
        const BASE_URL = "https://fast-api-g0de.onrender.com";
        const API_KEY = "fastapichatbotbackend@2026";

        // State management
        let isChatOpen = false;
        let activeConversationId = null;
        let activeResponseId = null;
        let isWaitingResponse = false;

        const chatWindow = document.getElementById("chatWindow");
        const chatMessages = document.getElementById("chatMessages");
        const userInput = document.getElementById("userInput");
        const sendBtn = document.getElementById("sendBtn");

        // Toggle Chat Window
        function toggleChat() {
            isChatOpen = !isChatOpen;
            if (isChatOpen) {
                chatWindow.classList.add("active");
                setTimeout(() => userInput.focus(), 300);
            } else {
                chatWindow.classList.remove("active");
            }
        }

        // Scroll to bottom of messages
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Handle Enter key press
        userInput.addEventListener("keydown", function(e) {
            if (e.key === "Enter" && !isWaitingResponse) {
                sendMessage();
            }
        });

        // Send Message to FastAPI Backend
        async function sendMessage() {
            const text = userInput.value.trim();
            if (!text || isWaitingResponse) return;

            // 1. Display User Message
            appendMessage("user", text);
            userInput.value = "";
            isWaitingResponse = true;
            sendBtn.disabled = true;

            // 2. Display Typing Indicator
            const typingId = "typing-" + Date.now();
            appendTypingIndicator(typingId);
            scrollToBottom();

            try {
                // Step 1 (Opsional): Jika belum ada activeConversationId, inisialisasi sesi ke /api/v1/conversations
                if (!activeConversationId) {
                    try {
                        const initRes = await fetch(`${BASE_URL}/api/v1/conversations`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-API-Key": API_KEY
                            }
                        });
                        if (initRes.ok) {
                            const initData = await initRes.json();
                            activeConversationId = initData.conversation_id;
                        }
                    } catch (err) {
                        console.warn("Gagal inisialisasi sesi, melanjutkan dengan response chaining standar:", err);
                    }
                }

                // Step 2: Kirim obrolan ke /api/v1/chat
                const payload = {
                    message: text
                };
                if (activeConversationId) {
                    payload.conversation_id = activeConversationId;
                }
                if (activeResponseId) {
                    payload.previous_response_id = activeResponseId;
                }

                const response = await fetch(`${BASE_URL}/api/v1/chat`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-API-Key": API_KEY
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
                        appendMessage("error", `<b>Akses Ditolak (401 Unauthorized):</b><br>API Key tidak cocok. Pastikan konfigurasi <code>INTERNAL_API_KEY</code> di file .env Anda sama dengan kunci di frontend.`);
                    } else if (response.status === 429) {
                        appendMessage("error", `<b>Rate Limit Tercapai (429):</b><br>Anda mengirim pesan terlalu cepat. Silakan tunggu beberapa detik sebelum mencoba lagi.`);
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
                appendMessage("error", `<b>Gagal Menghubungi Server:</b><br>Pastikan server Uvicorn sedang berjalan di <code>${BASE_URL}</code> dan tidak ada pemblokiran jaringan.`);
            } finally {
                isWaitingResponse = false;
                sendBtn.disabled = false;
                scrollToBottom();
                userInput.focus();
            }
        }

        // Append Message Box to Chat Area
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

        // Append Typing Dots Indicator
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

        // Remove element by ID
        function removeElement(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        // Simple text formatter (convert newlines to <br> and bold text)
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
