@extends('admin.layouts.app')

@section('title', 'Tambah Artikel Baru')
@section('page_title', 'Tambah Artikel')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back & Header Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.articles.index') }}" 
            class="inline-flex items-center gap-2 text-xs font-semibold text-[#64748b] hover:text-[#0c61cf] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Daftar Artikel</span>
        </a>

        <span class="text-xs text-[#94a3b8]">Mode: Penerbitan Baru</span>
    </div>

    <!-- Error Validation Alert -->
    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-3 text-xs text-rose-800">
            <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <span class="font-semibold block mb-1">Mohon periksa formulir Anda:</span>
                <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form Container -->
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" 
        x-data="articleCropHandler()" 
        class="bg-white border border-[#e2e8f0] rounded-2xl shadow-sm p-6 md:p-8 space-y-6">
        @csrf

        <div class="border-b border-[#f1f5f9] pb-4">
            <h1 class="text-lg font-bold text-[#0f172a] font-['Funnel_Display',sans-serif]">
                Publikasikan Artikel Baru
            </h1>
            <p class="text-xs text-[#64748b] mt-0.5">
                Isi data dan konten lengkap artikel yang akan ditampilkan di website publik.
            </p>
        </div>

        <!-- Judul Artikel -->
        <div>
            <label for="title" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                Judul Artikel <span class="text-rose-500">*</span>
            </label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                placeholder="Contoh: Siswa SMK IDN Juara 1 Nasional Lomba Robotik 2026"
                class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
        </div>

        <!-- 3 Columns Meta Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            <!-- Kategori -->
            <div>
                <label for="category" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Kategori <span class="text-rose-500">*</span>
                </label>
                <input list="category-options" id="category" name="category" value="{{ old('category') }}" required
                    placeholder="Pilih atau ketik kategori..."
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
                <datalist id="category-options">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                    <option value="Prestasi">
                    <option value="Kegiatan">
                    <option value="Teknologi">
                    <option value="Berita">
                </datalist>
            </div>

            <!-- Estimasi Waktu Baca -->
            <div>
                <label for="read_time" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Waktu Baca <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="read_time" name="read_time" value="{{ old('read_time', '5 Menit Baca') }}" required
                    placeholder="Contoh: 3 Menit Baca"
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all">
            </div>

            <!-- Tanggal Publikasi -->
            <div>
                <label for="published_at" class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                    Tanggal Rilis <span class="text-rose-500">*</span>
                </label>
                <input type="date" id="published_at" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}" required
                    class="w-full px-4 py-2.5 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-4 focus:ring-[#0c61cf]/10 transition-all cursor-pointer">
            </div>

        </div>

        <!-- Banner Image Upload with Interactive Cropper -->
        <div>
            <label class="block text-xs font-bold text-[#334155] uppercase tracking-wider mb-2">
                Banner / Cover Gambar
            </label>
            
            <div class="border-2 border-dashed border-[#cbd5e1] hover:border-[#0c61cf] rounded-2xl p-6 text-center bg-[#f8fafc] transition-colors relative cursor-pointer group">
                <input type="file" id="articleImageInput" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    @change="handleFileSelect($event)">
                
                <!-- Placeholder State -->
                <div x-show="!imagePreview" class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-xl bg-white border border-[#e2e8f0] shadow-sm flex items-center justify-center text-[#64748b] group-hover:text-[#0c61cf] group-hover:scale-105 transition-all mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-[#0f172a]">Klik untuk memilih gambar & sesuaikan area potong (*crop*)</span>
                    <span class="text-[11px] text-[#94a3b8] mt-1">Format: JPG, PNG, WEBP, AVIF (Dilengkapi Pemotong Interaktif)</span>
                </div>

                <!-- Preview State -->
                <div x-show="imagePreview" x-cloak class="flex flex-col items-center">
                    <div class="max-h-56 max-w-md rounded-xl overflow-hidden border border-[#e2e8f0] shadow-md mb-3">
                        <img :src="imagePreview" alt="Preview Hasil Crop" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-[#0c61cf] font-semibold">Gambar berhasil dipotong & siap diunggah</span>
                        <button type="button" @click.stop="openCropAgain()" class="text-xs bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-1 rounded-lg transition-colors font-medium">
                            Sesuaikan Area Potong
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konten Artikel (Textarea + Formatting Help) -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="content" class="text-xs font-bold text-[#334155] uppercase tracking-wider">
                    Isi Konten Artikel <span class="text-rose-500">*</span>
                </label>
                <span class="text-[11px] text-[#94a3b8]">Mendukung tag HTML standar</span>
            </div>

            <!-- Formatting Quick Helper Toolbar -->
            <div class="p-2.5 bg-[#f1f5f9] border border-[#e2e8f0] rounded-t-xl flex flex-wrap items-center gap-1.5 text-xs text-[#475569]">
                <span class="text-[11px] font-semibold text-[#64748b] mr-1">Helper tag:</span>
                <code class="px-1.5 py-0.5 bg-white border border-[#cbd5e1] rounded text-[11px]">&lt;p&gt;...&lt;/p&gt;</code>
                <code class="px-1.5 py-0.5 bg-white border border-[#cbd5e1] rounded text-[11px]">&lt;h3&gt;...&lt;/h3&gt;</code>
                <code class="px-1.5 py-0.5 bg-white border border-[#cbd5e1] rounded text-[11px]">&lt;strong&gt;...&lt;/strong&gt;</code>
                <code class="px-1.5 py-0.5 bg-white border border-[#cbd5e1] rounded text-[11px]">&lt;ul&gt;&lt;li&gt;...&lt;/li&gt;&lt;/ul&gt;</code>
                <code class="px-1.5 py-0.5 bg-white border border-[#cbd5e1] rounded text-[11px]">&lt;blockquote&gt;...&lt;/blockquote&gt;</code>
            </div>

            <textarea id="content" name="content" rows="12" required
                placeholder="Tuliskan isi artikel Anda di sini. Anda dapat menggunakan format paragraf <p>...</p> atau teks biasa."
                class="w-full p-4 bg-[#f8fafc] border border-t-0 border-[#e2e8f0] rounded-b-xl text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-2 focus:ring-[#0c61cf]/10 font-mono text-xs leading-relaxed transition-all">{{ old('content') }}</textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#f1f5f9]">
            <a href="{{ route('admin.articles.index') }}" 
                class="px-5 py-2.5 rounded-xl border border-[#e2e8f0] text-[#64748b] hover:bg-slate-100 text-xs md:text-sm font-semibold transition-colors">
                Batal
            </a>
            <button type="submit" 
                class="px-6 py-2.5 bg-[#0c61cf] hover:bg-[#0b54b5] active:scale-[0.99] text-white text-xs md:text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Simpan & Terbitkan</span>
            </button>
        </div>

        <!-- INTERACTIVE CROP MODAL -->
        <div x-show="cropModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-md transition-opacity" @click="closeCropModal()"></div>
            
            <div class="bg-white rounded-3xl border border-[#e2e8f0] shadow-2xl max-w-2xl w-full overflow-hidden relative z-10 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="p-5 border-b border-[#e2e8f0] flex items-center justify-between bg-[#f8fafc]">
                    <div>
                        <h3 class="text-base font-bold text-[#0f172a] font-['Funnel_Display',sans-serif]">
                            Sesuaikan Area Gambar (Crop)
                        </h3>
                        <p class="text-xs text-[#64748b] mt-0.5">Geser & ubah ukuran kotak fokus untuk menentukan area gambar yang akan ditampilkan.</p>
                    </div>
                    <button type="button" @click="closeCropModal()" class="p-2 rounded-xl hover:bg-slate-200 text-slate-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Cropper Canvas Container -->
                <div class="p-6 bg-slate-950 flex-grow flex items-center justify-center min-h-[320px] max-h-[500px] overflow-hidden relative">
                    <img id="cropperTargetImage" :src="rawImageSource" class="max-w-full max-h-[460px] block">
                </div>

                <!-- Modal Controls & Footer -->
                <div class="p-5 border-t border-[#e2e8f0] bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Tools Toolbar -->
                    <div class="flex items-center gap-2">
                        <button type="button" @click="rotateLeft()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-xs font-medium text-slate-700 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                            <span>Rotasi -90°</span>
                        </button>
                        <button type="button" @click="rotateRight()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-xs font-medium text-slate-700 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a8 8 0 00-8 8v2m18-10l-6 6m6-6l-6-6"/></svg>
                            <span>Rotasi +90°</span>
                        </button>
                        <button type="button" @click="setAspectRatio(16/9)" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl text-xs font-medium">
                            Rasio 16:9
                        </button>
                        <button type="button" @click="setAspectRatio(NaN)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-medium">
                            Bebas
                        </button>
                    </div>

                    <!-- Action Submit -->
                    <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                        <button type="button" @click="closeCropModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold">
                            Batal
                        </button>
                        <button type="button" @click="applyCrop()" class="px-5 py-2 bg-[#0c61cf] hover:bg-[#0b54b5] text-white rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Potong & Gunakan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>

<script>
function articleCropHandler() {
    return {
        imagePreview: null,
        rawImageSource: '',
        cropModalOpen: false,
        cropper: null,
        selectedFile: null,

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.selectedFile = file;

            const reader = new FileReader();
            reader.onload = (e) => {
                this.rawImageSource = e.target.result;
                this.cropModalOpen = true;
                this.$nextTick(() => {
                    this.initCropper();
                });
            };
            reader.readAsDataURL(file);
        },

        openCropAgain() {
            if (this.rawImageSource) {
                this.cropModalOpen = true;
                this.$nextTick(() => {
                    this.initCropper();
                });
            }
        },

        initCropper() {
            const img = document.getElementById('cropperTargetImage');
            if (!img) return;

            if (this.cropper) {
                this.cropper.destroy();
            }

            this.cropper = new Cropper(img, {
                aspectRatio: 16 / 9,
                viewMode: 1,
                autoCropArea: 0.9,
                responsive: true,
                background: true,
                zoomable: true,
            });
        },

        rotateLeft() {
            if (this.cropper) this.cropper.rotate(-90);
        },

        rotateRight() {
            if (this.cropper) this.cropper.rotate(90);
        },

        setAspectRatio(ratio) {
            if (this.cropper) this.cropper.setAspectRatio(ratio);
        },

        closeCropModal() {
            this.cropModalOpen = false;
            if (this.cropper) {
                this.cropper.destroy();
                this.cropper = null;
            }
        },

        applyCrop() {
            if (!this.cropper) return;

            const canvas = this.cropper.getCroppedCanvas({
                width: 1200,
                height: 675,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (canvas) {
                this.imagePreview = canvas.toDataURL('image/jpeg', 0.9);

                canvas.toBlob((blob) => {
                    if (blob) {
                        const fileInput = document.getElementById('articleImageInput');
                        const croppedFile = new File([blob], this.selectedFile ? this.selectedFile.name : 'article_banner.jpg', {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(croppedFile);
                        fileInput.files = dataTransfer.files;
                    }
                }, 'image/jpeg', 0.9);
            }

            this.closeCropModal();
        }
    }
}
</script>
@endsection
