@extends('admin.layouts.app')

@section('title', 'Tempat Sampah Artikel')
@section('page_title', 'Tempat Sampah - Artikel & Berita')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-[#e2e8f0] shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.articles.index') }}" class="text-[#64748b] hover:text-[#0c61cf] text-xs font-semibold flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Artikel
                </a>
            </div>
            <h1 class="text-xl font-bold text-[#0f172a] font-['Funnel_Display',sans-serif] mt-1">
                Tempat Sampah Artikel
            </h1>
            <p class="text-xs text-[#64748b] mt-0.5">
                Daftar artikel yang telah dihapus sementara (Soft Delete). Anda dapat memulihkan atau menghapusnya secara permanen.
            </p>
        </div>
    </div>

    <!-- Articles Trash Table -->
    <div class="bg-white rounded-2xl border border-[#e2e8f0] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8fafc] border-b border-[#e2e8f0] text-[11px] font-bold text-[#64748b] uppercase tracking-wider">
                        <th class="py-3.5 px-4">Artikel</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Dihapus Pada</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e2e8f0] text-xs font-medium text-[#334155]">
                    @forelse($articles as $article)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/' . $article->image) }}" alt="" class="w-12 h-10 object-cover rounded-lg border border-slate-200 shrink-0">
                                <div>
                                    <div class="font-bold text-[#0f172a] text-sm line-clamp-1">{{ $article->title }}</div>
                                    <div class="text-[11px] text-[#64748b]">{{ $article->read_time }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 whitespace-nowrap">
                                {{ $article->category }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-[#64748b]">
                            {{ $article->deleted_at ? $article->deleted_at->translatedFormat('d M Y H:i') : '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Restore Form -->
                                <form action="{{ route('admin.articles.restore', $article->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Pulihkan artikel ini kembali ke daftar publikasi?')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-lg border border-emerald-200 transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Pulihkan
                                    </button>
                                </form>

                                <!-- Force Delete Form -->
                                <form action="{{ route('admin.articles.force-delete', $article->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('PERINGATAN: Artikel akan dihapus secara PERMANEN dari database. Lanjutkan?')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg border border-rose-200 transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-500 text-xs">
                            Tidak ada artikel di tempat sampah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
        <div class="p-4 border-t border-[#e2e8f0]">
            {{ $articles->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
