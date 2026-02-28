<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Buku</h2>
        <p class="text-slate-500 font-medium mt-1">Informasi lengkap buku yang dipilih</p>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        <div class="grid grid-cols-1 gap-6">
            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1 font-medium">Judul Buku</p>
                <p class="text-2xl font-bold text-slate-900">{{ $buku->judul }}</p>
            </div>

            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1 font-medium">Penulis</p>
                <p class="text-lg text-slate-800">{{ $buku->penulis }}</p>
            </div>

            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1 font-medium">Penerbit</p>
                <p class="text-lg text-slate-800">{{ $buku->penerbit }}</p>
            </div>

            <div class="grid grid-cols-2 gap-6 border-b border-slate-200 pb-4">
                <div>
                    <p class="text-sm text-slate-500 mb-1 font-medium">Tahun Terbit</p>
                    <p class="text-lg font-semibold text-slate-800">{{ $buku->tahun_terbit }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1 font-medium">Jumlah Stok</p>
                    <p class="text-lg font-semibold {{ $buku->jumlah > 0 ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $buku->jumlah }} eksemplar
                    </p>
                </div>
            </div>

            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1 font-medium">Kategori</p>
                <div class="flex items-center gap-2">
                    <span class="px-4 py-2 bg-indigo-50 text-indigo-700 font-semibold rounded-full text-sm">
                        {{ optional($buku->kategori)->nama_kategori ?? 'Tidak ada kategori' }}
                    </span>
                </div>
            </div>

            <div>
                <p class="text-sm text-slate-500 mb-3 font-medium">Data Sistem</p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="p-3 bg-slate-50 rounded-lg">
                        <p class="text-xs text-slate-500 mb-1">ID Buku</p>
                        <p class="font-mono font-bold text-slate-700">#{{ $buku->id }}</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-lg">
                        <p class="text-xs text-slate-500 mb-1">Terakhir Diperbarui</p>
                        <p class="font-bold text-slate-700">{{ $buku->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-8 pt-6 border-t border-slate-200">
            <a href="{{ route('master-buku.index') }}" class="px-6 py-2.5 bg-slate-300 text-slate-800 font-semibold rounded-lg hover:bg-slate-400 transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <a href="{{ route('master-buku.edit', $buku->id) }}" class="px-6 py-2.5 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
            <form action="{{ route('master-buku.destroy', $buku->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
