<x-app-layout>
    <x-slot name="title">{{ $buku->judul }} - Perpustakaan Muhi</x-slot>

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('buku.index') }}" class="p-2 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Buku</h2>
        </div>
        <p class="text-slate-500 font-medium ml-12">Informasi lengkap dan daftar salinan buku.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Info Buku -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Card Info Buku -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-8">
                <div class="space-y-6">
                    <!-- Judul -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Judul Buku</label>
                        <p class="text-2xl font-bold text-slate-800">{{ $buku->judul }}</p>
                    </div>

                    <!-- Penulis -->
                    <div class="border-t border-slate-100 pt-6">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Penulis</label>
                        <p class="text-lg text-slate-800">{{ $buku->nama_penulis }}</p>
                    </div>

                    <!-- Penerbit & Tahun -->
                    <div class="border-t border-slate-100 pt-6 grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Penerbit</label>
                            <p class="text-base text-slate-800">{{ $buku->penerbit }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tahun Terbit</label>
                            <p class="text-base text-slate-800">{{ $buku->tahun_terbit }}</p>
                        </div>
                    </div>

                    <!-- Kategori & Subjek -->
                    <div class="border-t border-slate-100 pt-6 grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                            <span class="inline-flex items-center px-3 py-1 bg-indigo-50 border border-indigo-100 rounded-full text-sm font-bold text-indigo-600">
                                {{ optional($buku->kategori)->nama_kategori ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Subjek (DDC)</label>
                            @if($buku->subjek)
                            <span class="inline-flex items-center px-3 py-1 bg-blue-50 border border-blue-100 rounded-full text-sm font-bold">
                                <span class="text-blue-600">{{ $buku->subjek->kode_ddc }}</span>
                            </span>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Salinan -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Daftar Salinan ({{ $salinan->count() }} Exemplar)
                </h3>

                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($salinan as $exemplar)
                    <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-xl hover:bg-slate-100 transition-colors">
                        <div class="flex-1">
                            <p class="text-sm font-bold text-slate-800">
                                ID Eksamplar: <span class="text-indigo-600">{{ str_pad($exemplar->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </p>
                            <p class="text-xs text-slate-500">
                                Nomor Salinan: {{ $exemplar->nomor_salinan ?? '-' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $exemplar->jumlah > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                {{ $exemplar->jumlah > 0 ? '✓ Tersedia' : '✗ Dipinjam' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-8 text-slate-400">Tidak ada salinan buku</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Ringkasan Stok -->
        <div class="lg:col-span-1">
            <!-- Card Ringkasan Stok -->
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl border border-indigo-100 shadow-md p-6 sticky top-20">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6">Informasi Stok</h3>

                <div class="space-y-4">
                    <!-- Total Salinan -->
                    <div class="text-center p-4 bg-white rounded-xl border border-indigo-100">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Total Salinan</p>
                        <p class="text-3xl font-black text-indigo-600">{{ $salinan->count() }}</p>
                        <p class="text-xs text-slate-500 mt-1">Exemplar</p>
                    </div>

                    <!-- Stok Tersedia -->
                    <div class="text-center p-4 bg-white rounded-xl border border-emerald-100">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Tersedia</p>
                        <p class="text-3xl font-black text-emerald-600">{{ $salinan->sum('jumlah') }}</p>
                        <p class="text-xs text-slate-500 mt-1">Siap Dipinjam</p>
                    </div>

                    <!-- Sedang Dipinjam -->
                    <div class="text-center p-4 bg-white rounded-xl border border-orange-100">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Dipinjam</p>
                        <p class="text-3xl font-black text-orange-600">{{ $salinan->count() - $salinan->sum('jumlah') }}</p>
                        <p class="text-xs text-slate-500 mt-1">Dalam Peminjaman</p>
                    </div>

                    <!-- Status -->
                    <div class="text-center p-4 bg-white rounded-xl border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-2">Status</p>
                        @if($salinan->sum('jumlah') > 0)
                        <p class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 font-bold text-sm rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Tersedia
                        </p>
                        @else
                        <p class="inline-flex items-center px-3 py-1 bg-red-50 text-red-600 font-bold text-sm rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path></svg>
                            Habis
                        </p>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('buku.index') }}" class="w-full px-6 py-2.5 bg-slate-700 hover:bg-slate-800 text-white font-bold rounded-xl transition-colors text-center">
                        Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
