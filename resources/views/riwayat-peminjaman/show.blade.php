<x-app-layout>
    <!-- Header & Back Button -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('riwayat-peminjaman.index') }}" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Riwayat Peminjaman</h2>
                <p class="text-slate-500 font-medium">ID: #{{ $peminjaman->id }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Utama -->
        <div class="lg:col-span-2">
            <!-- Info Peminjaman -->
            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 mb-6">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Informasi Peminjaman</h3>
                
                <div class="grid grid-cols-2 gap-6">
                    <!-- Tanggal Peminjaman -->
                    <div>
                        <label class="text-sm font-semibold text-slate-600 block mb-2">Tanggal Peminjaman</label>
                        <p class="text-lg font-medium text-slate-800">
                            {{ $peminjaman->tgl_pinjam->format('d M Y') }}
                        </p>
                    </div>

                    <!-- Tanggal Jatuh Tempo -->
                    <div>
                        <label class="text-sm font-semibold text-slate-600 block mb-2">Jatuh Tempo</label>
                        <p class="text-lg font-medium {{ $peminjaman->status === 'dipinjam' && $peminjaman->tgl_jatuh_tempo < now()->toDateString() ? 'text-red-600' : 'text-slate-800' }}">
                            {{ $peminjaman->tgl_jatuh_tempo->format('d M Y') }}
                            @if($peminjaman->status === 'dipinjam' && $peminjaman->tgl_jatuh_tempo < now()->toDateString())
                                <span class="text-xs font-semibold text-red-600 block mt-1">
                                    ⚠️ Terlambat
                                </span>
                            @endif
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="text-sm font-semibold text-slate-600 block mb-2">Status</label>
                        <div>
                            @if($peminjaman->status === 'dipinjam')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-amber-50 text-amber-700">
                                    <span class="w-2 h-2 bg-amber-600 rounded-full mr-2"></span>
                                    Sedang Dipinjam
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700">
                                    <span class="w-2 h-2 bg-emerald-600 rounded-full mr-2"></span>
                                    Dikembalikan
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Nama Peminjam -->
                    <div>
                        <label class="text-sm font-semibold text-slate-600 block mb-2">Nama Peminjam</label>
                        <p class="text-lg font-medium text-slate-800">{{ $peminjaman->user->nama }}</p>
                    </div>
                </div>
            </div>

            <!-- Daftar Buku yang Dipinjam -->
            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 mb-6">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Daftar Buku Dipinjam ({{ $peminjaman->detailPeminjaman->count() }})</h3>

                <div class="space-y-4">
                    @forelse($peminjaman->detailPeminjaman as $detail)
                        @if($detail->buku)
                        <div class="border border-slate-200 rounded-lg p-4 hover:border-indigo-300 transition-colors">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-slate-800">{{ $detail->buku->judul }}</h4>
                                    <p class="text-sm text-slate-600 mt-1">
                                        <span class="font-semibold">Penulis:</span> {{ $detail->buku->nama_penulis }}
                                    </p>
                                    <p class="text-sm text-slate-600">
                                        <span class="font-semibold">Penerbit:</span> {{ $detail->buku->penerbit }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                                        ID Eksamplar: {{ str_pad($detail->buku->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-slate-600"><span class="font-semibold">Kategori:</span> {{ $detail->buku->kategori->nama_kategori ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-600"><span class="font-semibold">Tahun:</span> {{ $detail->buku->tahun_terbit }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-600"><span class="font-semibold">DDC:</span> {{ $detail->buku->subjek->kode_ddc ?? '-' }} - {{ $detail->buku->subjek->nama_subjek ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-600"><span class="font-semibold">Lokasi:</span> {{ $detail->buku->lokasi->nama_lokasi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="border border-red-200 bg-red-50 rounded-lg p-4">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-red-700">Data Buku Tidak Ditemukan</p>
                                    <p class="text-sm text-red-600">Buku dengan ID #{{ $detail->buku_id }} telah dihapus dari sistem.</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <p class="text-slate-500 text-center py-8">Tidak ada buku dalam peminjaman ini</p>
                    @endforelse
                </div>
            </div>

            <!-- Info Pengembalian (Jika Sudah Dikembalikan) -->
            @if($peminjaman->pengembalian)
                <div class="bg-white rounded-xl shadow-md border border-emerald-200 p-6 mb-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Pengembalian
                    </h3>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Tanggal Pengembalian -->
                        <div>
                            <label class="text-sm font-semibold text-slate-600 block mb-2">Tanggal Pengembalian</label>
                            <p class="text-lg font-medium text-slate-800">
                                {{ $peminjaman->pengembalian->tgl_kembali->format('d M Y') }}
                            </p>
                        </div>

                        <!-- Keterlambatan -->
                        @if($keterlambatan !== null)
                            <div>
                                <label class="text-sm font-semibold text-slate-600 block mb-2">Keterlambatan</label>
                                <p class="text-lg font-bold {{ $keterlambatan > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    @if($keterlambatan > 0)
                                        {{ $keterlambatan }} hari
                                    @else
                                        Tepat Waktu
                                    @endif
                                </p>
                            </div>
                        @endif

                        <!-- Denda -->
                        <div>
                            <label class="text-sm font-semibold text-slate-600 block mb-2">Denda</label>
                            <p class="text-lg font-bold {{ $peminjaman->pengembalian->denda > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md border border-amber-200 p-6 mb-6">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-amber-900">Buku Masih Dipinjam</p>
                            <p class="text-sm text-amber-700">Belum ada informasi pengembalian untuk peminjaman ini</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Card Ringkasan -->
            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 sticky top-6">
                <h4 class="font-bold text-slate-800 text-lg mb-6">Ringkasan</h4>

                <div class="space-y-4">
                    <!-- Jumlah Buku -->
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <div>
                            <p class="text-sm text-slate-600">Jumlah Buku</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $peminjaman->detailPeminjaman->count() }}</p>
                        </div>
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>

                    <!-- Durasi Peminjaman -->
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <div>
                            <p class="text-sm text-slate-600">Durasi Peminjaman</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $peminjaman->tgl_pinjam->diffInDays($peminjaman->tgl_jatuh_tempo) }} hari</p>
                        </div>
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>

                    <!-- Status Badge -->
                    <div class="p-4 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600 mb-3">Status Peminjaman</p>
                        @if($peminjaman->status === 'dipinjam')
                            <div class="space-y-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-amber-50 text-amber-700 w-full justify-center">
                                    <span class="w-2 h-2 bg-amber-600 rounded-full mr-2"></span>
                                    Sedang Dipinjam
                                </span>
                                @if($peminjaman->tgl_jatuh_tempo < now()->toDateString())
                                    <div class="mt-2 bg-red-50 border border-red-200 rounded-lg p-3">
                                        <p class="text-xs font-semibold text-red-700">
                                            ⚠️ Terlambat {{ now()->diffInDays($peminjaman->tgl_jatuh_tempo) }} hari
                                        </p>
                                    </div>
                                @else
                                    <p class="text-xs text-slate-600 mt-2">
                                        Sisa waktu: <span class="font-semibold">{{ now()->diffInDays($peminjaman->tgl_jatuh_tempo) }} hari</span>
                                    </p>
                                @endif
                            </div>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700 w-full justify-center">
                                <span class="w-2 h-2 bg-emerald-600 rounded-full mr-2"></span>
                                Sudah Dikembalikan
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Action Button -->
                <a href="{{ route('riwayat-peminjaman.index') }}"
                   class="w-full mt-6 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors text-center">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

</x-app-layout>
