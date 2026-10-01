@extends('admin.layouts.app')

@section('title', 'Tambah Lowongan Karir')
@section('page_title', 'Tambah Lowongan Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.career.index') }}" 
            class="inline-flex items-center gap-2 text-xs font-semibold text-[#64748b] hover:text-[#0c61cf] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Daftar Lowongan</span>
        </a>
        <span class="text-xs text-[#94a3b8]">Portal Career Center</span>
    </div>

    <!-- Error Alert -->
    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-3 text-xs text-rose-800">
            <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <span class="font-semibold block mb-1">Periksa kembali data yang dimasukkan:</span>
                <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form Box -->
    <form action="{{ route('admin.career.store') }}" method="POST" enctype="multipart/form-data" 
        x-data="{ 
            logoPreview: null,
            company_logo_url: '',
            fetchUrl: '',
            fetching: false,
            fetchSuccess: false,
            fetchMessage: '',
            title: '{{ old('title', '') }}',
            major: '{{ old('major', 'RPL') }}',
            company_name: '{{ old('company_name', '') }}',
            salary: '{{ old('salary', '') }}',
            work_type: '{{ old('work_type', 'Full-time') }}',
            work_location: '{{ old('work_location', 'Onsite') }}',
            location_group: '{{ old('location_group', 'Jabodetabek') }}',
            location: '{{ old('location', 'Greater Jakarta') }}',
            apply_url: '{{ old('apply_url', '') }}',
            source_platform: '{{ old('source_platform', 'Mitra Resmi IDN') }}',
            posted_at: '{{ old('posted_at', date('Y-m-d')) }}',
            expires_at: '{{ old('expires_at', '') }}',
            requirements: `{{ old('requirements', '') }}`,
            async autoFetch() {
                if (!this.fetchUrl) return;
                this.fetching = true;
                this.fetchSuccess = false;
                this.fetchMessage = '';
                try {
                    const res = await fetch('{{ route('admin.career.fetch-meta') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ url: this.fetchUrl })
                    });
                    const json = await res.json();
                    if (json.success && json.data) {
                        const d = json.data;
                        if (d.title) this.title = d.title;
                        if (d.company_name) this.company_name = d.company_name;
                        if (d.company_logo_url) {
                            this.company_logo_url = d.company_logo_url;
                            this.logoPreview = d.company_logo_url;
                            window.dispatchEvent(new CustomEvent('logo-fetched', { detail: { url: d.company_logo_url } }));
                        }
                        if (d.salary) this.salary = d.salary;
                        if (d.apply_url) this.apply_url = d.apply_url;
                        if (d.source_platform) this.source_platform = d.source_platform;
                        if (d.major) this.major = d.major;
                        if (d.work_type) this.work_type = d.work_type;
                        if (d.work_location) this.work_location = d.work_location;
                        if (d.location) this.location = d.location;
                        if (d.location_group) this.location_group = d.location_group;
                        if (d.requirements) this.requirements = d.requirements;
                        this.fetchSuccess = true;
                        this.fetchMessage = 'Alhamdulillah! Data berhasil ditarik otomatis dari ' + (d.source_platform || 'URL') + '.';
                    }
                } catch(e) {
                    this.fetchMessage = 'Gagal menarik metadata secara otomatis. Anda tetap dapat mengisi form secara manual.';
                } finally {
                    this.fetching = false;
                }
            }
        }" class="bg-white border border-[#e2e8f0] rounded-2xl shadow-sm p-6 md:p-8 space-y-6">
        @csrf

        <div class="border-b border-[#f1f5f9] pb-4">
            <h1 class="text-lg font-bold text-[#0f172a] font-['Funnel_Display',sans-serif]">
                Publikasikan Lowongan Baru
            </h1>
            <p class="text-xs text-[#64748b] mt-0.5">
                Lowongan ini akan langsung muncul dan dapat dicari di portal Career Center IDN.
            </p>
        </div>

        <!-- SMART AUTO-FETCH BAR -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/80 rounded-2xl p-4 md:p-5 space-y-3">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-[#0c61cf] text-white flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xs md:text-sm font-bold text-[#0f172a]">
                    Otomatisasi: Tarik Data dari URL Lowongan
                </h3>
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#0c61cf] text-white">
                    Auto-Fill
                </span>
            </div>
            <p class="text-xs text-[#475569]">
                Cukup tempel tautan lowongan dari <strong>Glints, Jobstreet, LinkedIn, Kalibrr</strong>, atau web karir perusahaan. Sistem akan otomatis mengisi posisi, perusahaan, jurusan, dan platform.
            </p>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                <input type="url" x-model="fetchUrl" @keydown.enter.prevent="autoFetch()"
                    placeholder="https://glints.com/... atau link Jobstreet / LinkedIn"
                    class="flex-1 px-4 py-2.5 bg-white border border-blue-200 rounded-xl text-xs md:text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
                <button type="button" @click="autoFetch()" :disabled="fetching || !fetchUrl"
                    class="px-5 py-2.5 bg-[#0c61cf] hover:bg-[#0b54b5] active:scale-[0.99] disabled:opacity-50 text-white text-xs md:text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer shrink-0">
                    <svg x-show="fetching" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg x-show="!fetching" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span x-text="fetching ? 'Mengambil Data...' : 'Tarik Data Otomatis'"></span>
                </button>
            </div>
            <div x-show="fetchMessage" x-cloak class="text-xs font-medium pt-1" 
                :class="fetchSuccess ? 'text-emerald-700' : 'text-amber-700'" x-text="fetchMessage"></div>
        </div>

        <!-- Row 1: Posisi & Jurusan -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
            <div class="md:col-span-8">
                <label for="title" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Posisi / Judul Pekerjaan <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="title" name="title" x-model="title" required
                    placeholder="Contoh: Cloud Engineer, Flutter Developer, UI/UX Designer"
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
            </div>

            <div class="md:col-span-4">
                <label for="major" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Jurusan IDN <span class="text-rose-500">*</span>
                </label>
                <select id="major" name="major" x-model="major" required
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all cursor-pointer font-semibold">
                    <option value="RPL">RPL (Software / Coding)</option>
                    <option value="TKJ">TKJ (Network & Cloud)</option>
                    <option value="DKV">DKV (Design & Creative)</option>
                </select>
            </div>
        </div>

        <!-- Row 2: Perusahaan & Gaji -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
            <div class="md:col-span-8">
                <label for="company_name" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Nama Perusahaan / Mitra Industri <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="company_name" name="company_name" x-model="company_name" required
                    placeholder="Contoh: PT Telkom Indonesia, Gojek, Bukalapak"
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
            </div>

            <div class="md:col-span-4">
                <label for="salary" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Gaji / Tunjangan (Opsional)
                </label>
                <input type="text" id="salary" name="salary" x-model="salary"
                    placeholder="Contoh: Rp 3.5 Juta atau Kompetitif"
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
            </div>
        </div>

        <!-- Row 3: Tipe Kerja, Mode Lokasi, Wilayah -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label for="work_type" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Tipe Pekerjaan <span class="text-rose-500">*</span>
                </label>
                <select id="work_type" name="work_type" x-model="work_type" required
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all cursor-pointer">
                    <option value="Full-time">Full-time</option>
                    <option value="Internship">Internship (Magang/PKL)</option>
                    <option value="Contract">Contract</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Freelance">Freelance</option>
                </select>
            </div>

            <div>
                <label for="work_location" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Sistem Kerja <span class="text-rose-500">*</span>
                </label>
                <select id="work_location" name="work_location" x-model="work_location" required
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all cursor-pointer">
                    <option value="Onsite">Onsite (Di Kantor)</option>
                    <option value="Hybrid">Hybrid (Fleksibel)</option>
                    <option value="Remote/WFH">Remote / WFH</option>
                </select>
            </div>

            <div>
                <label for="location_group" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Wilayah <span class="text-rose-500">*</span>
                </label>
                <select id="location_group" name="location_group" x-model="location_group" required
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all cursor-pointer">
                    <option value="Jabodetabek">Jabodetabek</option>
                    <option value="Jawa">Jawa</option>
                    <option value="Kalimantan">Kalimantan</option>
                    <option value="Sumatra">Sumatra</option>
                    <option value="Sulawesi">Sulawesi</option>
                    <option value="Papua">Papua</option>
                    <option value="Other">Lainnya</option>
                </select>
            </div>
        </div>

        <!-- Row 4: Kota Penempatan & Platform Sumber -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
            <div class="md:col-span-6">
                <label for="location" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Kota / Alamat Penempatan <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="location" name="location" x-model="location" required
                    placeholder="Contoh: Jakarta Selatan, DKI Jakarta"
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
            </div>

            <div class="md:col-span-6">
                <label for="source_platform" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Platform Sumber Lowongan <span class="text-rose-500">*</span>
                </label>
                <select id="source_platform" name="source_platform" x-model="source_platform" required
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all cursor-pointer">
                    <option value="Mitra Resmi IDN">Mitra Resmi IDN (Eksklusif)</option>
                    <option value="Glints">Glints</option>
                    <option value="Jobstreet">Jobstreet</option>
                    <option value="LinkedIn">LinkedIn</option>
                    <option value="Kalibrr">Kalibrr</option>
                    <option value="KitaLulus">KitaLulus</option>
                    <option value="Dealls">Dealls</option>
                    <option value="Website Resmi Perusahaan">Website Resmi Perusahaan</option>
                </select>
            </div>
        </div>

        <!-- Row 5: Link Lamar & Tanggal Deadline -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
            <div class="md:col-span-6">
                <label for="apply_url" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Tautan Pendaftaran (URL Website / Form Lamaran)
                </label>
                <input type="url" id="apply_url" name="apply_url" x-model="apply_url"
                    placeholder="https://glints.com/... atau https://karir.perusahaan.com/apply"
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
            </div>

            <div class="md:col-span-3">
                <label for="posted_at" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Tanggal Posting
                </label>
                <input type="date" id="posted_at" name="posted_at" x-model="posted_at"
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
            </div>

            <div class="md:col-span-3">
                <label for="expires_at" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Batas Akhir / Deadline
                </label>
                <input type="date" id="expires_at" name="expires_at" x-model="expires_at"
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
                <span class="text-[10px] text-[#94a3b8] mt-1 block">Kosongkan jika tanpa deadline</span>
            </div>
        </div>

        <!-- Row 6: Persyaratan Singkat / Kualifikasi -->
        <div>
            <label for="requirements" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                Persyaratan & Kualifikasi Singkat (Opsional)
            </label>
            <textarea id="requirements" name="requirements" x-model="requirements" rows="3"
                placeholder="Contoh: Menguasai HTML/CSS & dasar Flutter, Terbuka untuk santri aktif kelas 11-12, Disiplin dan berakhlak mulia."
                class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all"></textarea>
        </div>

        <!-- Row 7: Logo Perusahaan Upload with Interactive Cropper -->
        <div x-data="{
            logoCropModalOpen: false,
            rawLogoSource: '',
            originalRawLogoSource: '',
            logoCropper: null,
            selectedLogoFile: null,
            loadingProxy: false,

            init() {
                window.addEventListener('logo-fetched', (e) => {
                    this.originalRawLogoSource = e.detail.url;
                    this.selectedLogoFile = null;
                });
            },

            handleLogoSelect(event) {
                const file = event.target.files[0];
                if (!file) return;
                this.selectedLogoFile = file;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.originalRawLogoSource = e.target.result;
                    this.rawLogoSource = e.target.result;
                    this.openLogoCropModal();
                };
                reader.readAsDataURL(file);
            },

            async openCropForCurrentLogo() {
                let sourceToUse = this.originalRawLogoSource;

                if (!sourceToUse && logoPreview) {
                    sourceToUse = logoPreview;
                }

                if (!sourceToUse) return;

                if (sourceToUse.startsWith('http')) {
                    this.loadingProxy = true;
                    try {
                        const res = await fetch('{{ route('admin.career.proxy-logo') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ url: sourceToUse })
                        });
                        const json = await res.json();
                        if (json.success && json.dataUrl) {
                            this.originalRawLogoSource = json.dataUrl;
                            this.rawLogoSource = json.dataUrl;
                        } else {
                            this.rawLogoSource = sourceToUse;
                        }
                    } catch(e) {
                        this.rawLogoSource = sourceToUse;
                    } finally {
                        this.loadingProxy = false;
                    }
                } else {
                    this.rawLogoSource = sourceToUse;
                }

                this.openLogoCropModal();
            },

            openLogoCropModal() {
                this.logoCropModalOpen = true;
                this.$nextTick(() => {
                    const img = document.getElementById('logoCropperTarget');
                    if (!img) return;

                    const startCropper = () => {
                        if (this.logoCropper) this.logoCropper.destroy();
                        this.logoCropper = new Cropper(img, {
                            aspectRatio: 1, // 1:1 Square for company logos
                            viewMode: 0, // Allow free drag and move left/right/up/down
                            dragMode: 'crop',
                            autoCropArea: 0.95, // Cover 95% of image initially
                            responsive: true,
                            restore: true,
                            checkCrossOrigin: false,
                            modal: true,
                            guides: true,
                            center: true,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            toggleDragModeOnDblclick: false,
                        });
                    };

                    if (img.complete && img.naturalWidth !== 0) {
                        startCropper();
                    } else {
                        img.onload = startCropper;
                    }
                });
            },

            closeLogoCropModal() {
                this.logoCropModalOpen = false;
                if (this.logoCropper) {
                    this.logoCropper.destroy();
                    this.logoCropper = null;
                }
            },

            rotateLogoLeft() {
                if (this.logoCropper) this.logoCropper.rotate(-90);
            },

            rotateLogoRight() {
                if (this.logoCropper) this.logoCropper.rotate(90);
            },

            applyLogoCrop() {
                if (!this.logoCropper) return;
                try {
                    const canvas = this.logoCropper.getCroppedCanvas({
                        width: 400,
                        height: 400,
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high'
                    });

                    if (canvas) {
                        const croppedDataUrl = canvas.toDataURL('image/png');
                        logoPreview = croppedDataUrl;
                        
                        company_logo_url = '';
                        const hiddenInput = document.querySelector('input[name=\'company_logo_url\']');
                        if (hiddenInput) hiddenInput.value = '';

                        const croppedFile = dataURLtoFile(croppedDataUrl, this.selectedLogoFile ? this.selectedLogoFile.name : 'company_logo.png');
                        if (croppedFile) {
                            const input = document.getElementById('companyImgInput');
                            if (input) {
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(croppedFile);
                                input.files = dataTransfer.files;
                            }
                        }
                    }
                } catch (e) {
                    console.error('Crop error:', e);
                }
                this.closeLogoCropModal();
            }
        }">
            <input type="hidden" name="company_logo_url" x-model="company_logo_url">
            <label class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                Logo Mitra Perusahaan
            </label>
            <div class="border-2 border-dashed border-[#cbd5e1] hover:border-[#0c61cf] rounded-2xl p-5 text-center bg-[#f8fafc] transition-colors relative cursor-pointer group">
                <input type="file" id="companyImgInput" name="company_img" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                    @change="handleLogoSelect($event)">
                
                <div x-show="!logoPreview" class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-xl bg-white border border-[#e2e8f0] shadow-sm flex items-center justify-center text-[#64748b] group-hover:text-[#0c61cf] mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-[#0f172a]">Unggah Logo Perusahaan (Opsional)</span>
                    <span class="text-[11px] text-[#94a3b8] mt-0.5">Dapat dipotong presisi rasio 1:1 (Persegi). Jika kosong, ditarik dari URL atau inisial nama</span>
                </div>

                <div x-show="logoPreview" x-cloak class="flex flex-col items-center z-20 relative">
                    <div class="w-16 h-16 rounded-xl overflow-hidden border border-[#e2e8f0] shadow-sm p-1 bg-white mb-2 flex items-center justify-center">
                        <img :src="logoPreview" alt="Preview Logo" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] text-[#0c61cf] font-semibold">Logo Siap Dipakai</span>
                        <button type="button" @click.stop="openCropForCurrentLogo()" :disabled="loadingProxy"
                            class="text-[11px] bg-slate-200 hover:bg-slate-300 disabled:opacity-50 text-slate-700 px-2.5 py-1 rounded-lg font-medium transition-colors cursor-pointer flex items-center gap-1.5">
                            <svg x-show="loadingProxy" class="animate-spin w-3 h-3 text-slate-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="loadingProxy ? 'Memuat Gambar...' : 'Potong / Crop Logo Ini'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- INTERACTIVE LOGO CROP MODAL (Clean Light Background & Smooth Movement) -->
            <div x-show="logoCropModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="closeLogoCropModal()"></div>
                
                <div class="bg-white rounded-3xl border border-[#e2e8f0] shadow-2xl max-w-xl w-full overflow-hidden relative z-10 flex flex-col max-h-[92vh]">
                    <div class="p-4 px-6 border-b border-[#e2e8f0] flex items-center justify-between bg-white">
                        <div>
                            <h3 class="text-sm font-bold text-[#0f172a] font-['Funnel_Display',sans-serif]">
                                Sesuaikan Area Logo Perusahaan (1:1)
                            </h3>
                            <p class="text-[11px] text-[#64748b] mt-0.5">Geser atau tarik sudut kotak seleksi untuk menyesuaikan posisi logo.</p>
                        </div>
                        <button type="button" @click="closeLogoCropModal()" class="p-1.5 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Clean Light Grey Background Container -->
                    <div class="p-6 bg-[#f8fafc] border-y border-[#e2e8f0] flex items-center justify-center min-h-[350px] max-h-[480px] overflow-hidden relative">
                        <img id="logoCropperTarget" :src="rawLogoSource" class="max-w-full max-h-[420px] block">
                    </div>

                    <div class="p-4 px-6 bg-white flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <button type="button" @click="rotateLogoLeft()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-xs font-medium text-slate-700 transition-colors">
                                ↺ Rotasi -90°
                            </button>
                            <button type="button" @click="rotateLogoRight()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-xs font-medium text-slate-700 transition-colors">
                                ↻ Rotasi +90°
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="closeLogoCropModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-colors">
                                Batal
                            </button>
                            <button type="button" @click="applyLogoCrop()" class="px-5 py-2 bg-[#0c61cf] hover:bg-[#0b54b5] text-white rounded-xl text-xs font-semibold shadow-sm transition-all">
                                Potong & Gunakan Logo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Aktif Checkbox -->
        <div class="pt-2">
            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-[#0c61cf] focus:ring-[#0c61cf] border-[#cbd5e1]">
                <div>
                    <span class="text-xs font-bold text-[#0f172a] block">Langsung Aktifkan Lowongan</span>
                    <span class="text-[11px] text-[#64748b]">Jika dicentang, lowongan akan langsung tampil di halaman depan Career Center</span>
                </div>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#f1f5f9]">
            <a href="{{ route('admin.career.index') }}" 
                class="px-5 py-2.5 rounded-xl border border-[#e2e8f0] text-[#64748b] hover:bg-slate-100 text-xs md:text-sm font-semibold transition-colors">
                Batal
            </a>
            <button type="submit" 
                class="px-6 py-2.5 bg-[#0c61cf] hover:bg-[#0b54b5] active:scale-[0.99] text-white text-xs md:text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Simpan Lowongan</span>
            </button>
        </div>

    </form>

</div>
@endsection
