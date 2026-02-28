<x-app-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Detail Buku</h2>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        <div class="grid grid-cols-1 gap-6">
            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1">Judul Buku</p>
                <p class="text-xl font-bold text-slate-800">{{ $buku->judul }}</p>
            </div>

            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1">Penulis</p>
                <p class="text-lg text-slate-800">{{ $buku->penulis }}</p>
            </div>

            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1">Penerbit</p>
                <p class="text-lg text-slate-800">{{ $buku->penerbit }}</p>
            </div>

            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1">Tahun Terbit</p>
                <p class="text-lg text-slate-800">{{ $buku->tahun_terbit }}</p>
            </div>

            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1">Kategori</p>
                <p class="text-lg text-slate-800">{{ optional($buku->kategori)->nama_kategori ?? '-' }}</p>
            </div>

            <div class="border-b border-slate-200 pb-4">
                <p class="text-sm text-slate-500 mb-1">Jumlah Stok</p>
                <p class="text-lg font-semibold {{ $buku->jumlah > 0 ? 'text-emerald-600' : 'text-red-600' }}">{{ $buku->jumlah }} eks</p>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <a href="{{ route('buku.index') }}" class="px-6 py-2 bg-slate-300 text-slate-800 font-medium rounded-lg hover:bg-slate-400 transition-colors inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Katalog
            </a>
        </div>
    </div>
</x-app-layout>
