@extends('admin.layouts.app')

@section('title', 'Kelola Career Center')
@section('page_title', 'Kelola Lowongan Karir & Magang')

@section('content')
<div class="space-y-6" x-data="{ deleteModalOpen: false, deleteUrl: '', deleteTitle: '' }">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-[#e2e8f0] shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-[#0f172a] font-['Funnel_Display',sans-serif]">
                Daftar Lowongan Karir & Magang
            </h1>
            <p class="text-xs text-[#64748b] mt-0.5">
                Total {{ $jobs->total() }} lowongan terdaftar untuk santri dan alumni IDN Boarding School.
            </p>
        </div>

        <a href="{{ route('admin.career.create') }}" 
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0c61cf] hover:bg-[#0b54b5] active:scale-[0.99] text-white text-xs md:text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Lowongan Baru</span>
        </a>
    </div>

    <!-- Metric Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-[#e2e8f0] shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#0c61cf] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-[#64748b] block font-medium">Total Lowongan</span>
                <span class="text-xl font-bold text-[#0f172a]">{{ $totalCount }}</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-[#e2e8f0] shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-[#64748b] block font-medium">Lowongan Aktif</span>
                <span class="text-xl font-bold text-emerald-600">{{ $activeCount }}</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-[#e2e8f0] shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-[#64748b] block font-medium">Khusus Magang / PKL</span>
                <span class="text-xl font-bold text-purple-600">{{ $internCount }}</span>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-[#e2e8f0] shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-[#64748b] block font-medium">Kedaluwarsa (Expired)</span>
                <span class="text-xl font-bold {{ $expiredCount > 0 ? 'text-rose-600' : 'text-[#0f172a]' }}">{{ $expiredCount }}</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-[#e2e8f0] shadow-sm">
        <form method="GET" action="{{ route('admin.career.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <!-- Search Query Input -->
            <div class="sm:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#94a3b8]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari posisi, perusahaan, atau kota..."
                    class="w-full pl-10 pr-4 py-2 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-xs md:text-sm text-[#0f172a] placeholder-[#94a3b8] focus:outline-none focus:border-[#0c61cf] focus:ring-2 focus:ring-[#0c61cf]/10 transition-all">
            </div>

            <!-- Major Filter Dropdown -->
            <div class="sm:col-span-3">
                <select name="major" onchange="this.form.submit()"
                    class="w-full px-3 py-2 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-xs md:text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-2 focus:ring-[#0c61cf]/10 transition-all cursor-pointer">
                    <option value="">Semua Jurusan</option>
                    @foreach($majors as $m)
                        <option value="{{ $m }}" {{ $major === $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter Dropdown -->
            <div class="sm:col-span-2">
                <select name="status" onchange="this.form.submit()"
                    class="w-full px-3 py-2 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl text-xs md:text-sm text-[#0f172a] focus:outline-none focus:border-[#0c61cf] focus:ring-2 focus:ring-[#0c61cf]/10 transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>Aktif (Buka)</option>
                    <option value="expired" {{ $status === 'expired' ? 'selected' : '' }}>Kedaluwarsa (Expired)</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>Ditutup Manual</option>
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2 px-3 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition-colors cursor-pointer">
                    Filter
                </button>
                @if($search || $major || $status !== null && $status !== '')
                    <a href="{{ route('admin.career.index') }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-[#64748b] rounded-xl text-xs transition-colors shrink-0" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Career Jobs Table -->
    <div class="bg-white border border-[#e2e8f0] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#f8fafc] border-b border-[#e2e8f0] text-[#475569] font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 pl-6 w-12">Logo</th>
                        <th class="py-3.5 px-4 min-w-[220px]">Posisi & Perusahaan</th>
                        <th class="py-3.5 px-4">Platform Sumber</th>
                        <th class="py-3.5 px-4">Jurusan</th>
                        <th class="py-3.5 px-4">Tipe & Mode</th>
                        <th class="py-3.5 px-4">Waktu & Deadline</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 pr-6 text-right w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-[#f8fafc]/70 transition-colors group">
                            
                            <!-- Company Logo / Initials -->
                            <td class="py-3.5 pl-6">
                                <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-100 border border-[#e2e8f0] flex items-center justify-center font-bold text-xs shrink-0 {{ $job->company_img ? '' : ($job->company_bg ?: 'bg-[#0c61cf]') . ' text-white' }}">
                                    @if($job->company_img)
                                        <img src="{{ asset($job->company_img) }}" alt="{{ $job->company_name }}" class="w-full h-full object-cover object-left rounded-lg p-0.5">
                                    @else
                                        <span>{{ $job->company_logo_char ?: strtoupper(substr($job->company_name, 0, 1)) }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Title & Company -->
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-[#0f172a] block text-sm group-hover:text-[#0c61cf] transition-colors">
                                    {{ $job->title }}
                                </span>
                                <div class="flex items-center gap-2 text-[11px] text-[#64748b] mt-0.5">
                                    <span class="font-medium text-[#334155]">{{ $job->company_name }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $job->location }}</span>
                                </div>
                            </td>

                            <!-- Source Platform & Link -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $job->source_platform ?: 'Mitra IDN' }}
                                    </span>
                                    @if($job->apply_url)
                                        <a href="{{ $job->apply_url }}" target="_blank" rel="noopener noreferrer" 
                                            class="text-[#64748b] hover:text-[#0c61cf] transition-colors p-1" title="Buka URL Lowongan Asli">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <!-- Major Badge -->
                            <td class="py-3.5 px-4">
                                @if($job->major === 'RPL')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">RPL</span>
                                @elseif($job->major === 'TKJ')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">TKJ</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">DKV</span>
                                @endif
                            </td>

                            <!-- Type & Location Mode -->
                            <td class="py-3.5 px-4">
                                <span class="font-medium text-[#334155] block">{{ $job->work_type }}</span>
                                <span class="text-[11px] text-[#64748b] block mt-0.5">{{ $job->work_location }}</span>
                            </td>

                            <!-- Time & Expiration -->
                            <td class="py-3.5 px-4">
                                <span class="font-medium text-[#0f172a] block">{{ $job->posted_time_ago }}</span>
                                @if($job->expires_at)
                                    <span class="text-[10px] {{ $job->is_expired ? 'text-rose-600 font-bold' : 'text-[#64748b]' }} block mt-0.5">
                                        Exp: {{ $job->expires_at->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-[#94a3b8] block mt-0.5">Tanpa deadline</span>
                                @endif
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-3.5 px-4">
                                @if($job->is_expired)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200" title="Lowongan sudah melewati tanggal deadline">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Kedaluwarsa</span>
                                    </span>
                                @else
                                    <form action="{{ route('admin.career.toggle', $job->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold transition-all cursor-pointer {{ $job->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}"
                                            title="Klik untuk mengubah status">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $job->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $job->is_active ? 'Aktif' : 'Tutup' }}</span>
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 pr-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    
                                    <!-- Duplicate Button -->
                                    <form action="{{ route('admin.career.duplicate', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                            class="p-2 rounded-xl bg-slate-100 hover:bg-[#0c61cf] hover:text-white text-[#64748b] transition-colors cursor-pointer" 
                                            title="Duplikat Lowongan Ini">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </form>

                                    <!-- Edit Link -->
                                    <a href="{{ route('admin.career.edit', $job->id) }}" 
                                        class="p-2 rounded-xl bg-[#0c61cf]/10 hover:bg-[#0c61cf] hover:text-white text-[#0c61cf] transition-colors" title="Edit Lowongan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <button type="button" 
                                        @click="deleteModalOpen = true; deleteUrl = '{{ route('admin.career.destroy', $job->id) }}'; deleteTitle = '{{ addslashes($job->title) }} ({{ addslashes($job->company_name) }})'"
                                        class="p-2 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 transition-colors cursor-pointer" title="Hapus Lowongan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-[#94a3b8]">
                                Tidak ada data lowongan pekerjaan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jobs->hasPages())
            <div class="p-4 border-t border-[#e2e8f0] bg-[#fafafa]">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="deleteModalOpen = false"></div>
        <div class="bg-white rounded-2xl border border-[#e2e8f0] shadow-2xl max-w-md w-full p-6 relative z-10 space-y-4">
            <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-[#0f172a] font-['Funnel_Display',sans-serif]">
                    Konfirmasi Hapus Lowongan
                </h3>
                <p class="text-xs text-[#64748b] mt-1 leading-relaxed">
                    Hapus lowongan <span class="font-semibold text-[#0f172a]" x-text="'“' + deleteTitle + '”'"></span> dari portal Career Center?
                </p>
            </div>
            <form :action="deleteUrl" method="POST" class="flex items-center justify-end gap-2.5 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="deleteModalOpen = false" 
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-[#475569] rounded-xl text-xs font-semibold transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors cursor-pointer">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
