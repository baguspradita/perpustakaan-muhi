<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('master-buku.index') }}" class="p-2 bg-white border border-slate-100 rounded-lg text-slate-400 hover:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tempat Sampah</h2>
                </div>
                <p class="text-slate-500 font-medium ml-12">Kelola buku yang sudah dihapus (soft delete)</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama Penulis</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Subjek (DDC)</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Total Salinan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Tanggal Dihapus</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukuDeleted as $item)
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600">{{ ($bukuDeleted->currentPage() - 1) * $bukuDeleted->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                {{ $item->judul }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $item->buku->nama_depan_penulis }} {{ $item->buku->nama_belakang_penulis }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-medium rounded-full text-xs">
                                    {{ optional($item->buku->kategori)->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($item->buku->subjek)
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-bold rounded text-xs">
                                            {{ $item->buku->subjek->kode_ddc }}
                                        </span>
                                        <span class="text-slate-600 text-xs line-clamp-1">
                                            {{ $item->buku->subjek->nama_subjek }}
                                        </span>
                                    </div>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 font-medium rounded text-xs">
                                        Belum set
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-center text-orange-600">
                                {{ $item->total_salinan }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ \Carbon\Carbon::parse($item->buku->deleted_at)->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2 justify-center flex-wrap">
                                    <form action="{{ route('master-buku.restore', $item->first_id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 font-medium rounded-lg hover:bg-emerald-600 hover:text-white transition-colors inline-flex items-center gap-1.5" title="Restore" onclick="return confirm('Restore buku ini ({{ $item->total_salinan }} salinan)?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            <span class="text-xs">Restore</span>
                                        </button>
                                    </form>
                                    <!-- <form action="{{ route('master-buku.permanent-delete', $item->first_id) }}" method="POST" style="display:inline" onsubmit="return confirm('⚠️ PERHATIAN: Menghapus permanen akan menghilangkan semua data buku ini (' + {{ $item->total_salinan }} + ' salinan) dari database dan referensi ID Eksamplar akan rusak!\n\nApakah Anda yakin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-600 hover:text-white transition-colors inline-flex items-center gap-1.5" title="Hapus Permanen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="text-xs">Hapus Permanen</span>
                                        </button>
                                    </form> -->
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-slate-500 font-medium">Tempat sampah kosong - Tidak ada buku yang dihapus</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($bukuDeleted->hasPages())
        <div class="mt-6">
            {{ $bukuDeleted->links() }}
        </div>
    @endif

    <!-- Info Box -->
    <div class="mt-8 p-4 bg-orange-50 border border-orange-200 rounded-lg">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <div>
                <p class="font-bold text-orange-800 mb-1">⚠️ Perhatian:</p>
                <p class="text-orange-700 text-sm">Buku yang di-soft delete akan disimpan selamanya. Gunakan "Restore" untuk mengembalikan buku ke daftar aktif. Gunakan "Hapus Permanen" hanya jika data buku benar-benar tidak diperlukan lagi (akan merusak referensi ID Eksamplar).</p>
            </div>
        </div>
    </div>
</x-app-layout>
