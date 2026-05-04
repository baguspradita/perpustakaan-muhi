<x-app-layout>
    <!-- Header with Back Button -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('riwayat-peminjaman.index-all') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800">Detail Peminjaman</h2>
            <p class="text-slate-500 font-medium">Data peminjaman untuk {{ $peminjaman->user->nama }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Informasi Anggota & Buku -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Informasi Anggota -->
            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Anggota
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-slate-500 font-semibold">Nama Anggota</p>
                        <p class="text-slate-800 font-semibold mt-1">{{ $peminjaman->user->nama }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-semibold">Role</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold mt-1 {{ $peminjaman->user->role === 'siswa' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                            {{ ucfirst($peminjaman->user->role) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-semibold">Email</p>
                        <p class="text-slate-800 mt-1">{{ $peminjaman->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-semibold">No HP</p>
                        <p class="text-slate-800 mt-1">{{ $peminjaman->user->no_telp ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Peminjaman -->
            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Peminjaman
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-slate-500 font-semibold">Tanggal Peminjaman</p>
                        <p class="text-slate-800 font-semibold mt-1">{{ $peminjaman->tgl_pinjam->format('d F Y') }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $peminjaman->tgl_pinjam->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-semibold">Jatuh Tempo</p>
                        <p class="text-slate-800 font-semibold mt-1">{{ $peminjaman->tgl_jatuh_tempo->format('d F Y') }}</p>
                        @if($peminjaman->status === 'dipinjam' && $peminjaman->tgl_jatuh_tempo < now()->toDateString())
                            <span class="inline-block mt-2 px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded">⚠️ TERLAMBAT</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-semibold">Durasi Peminjaman</p>
                        <p class="text-slate-800 font-semibold mt-1">{{ $peminjaman->tgl_pinjam->diffInDays($peminjaman->tgl_jatuh_tempo) }} Hari</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-semibold">Status</p>
                        <div class="mt-1">
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
                </div>
            </div>

            <!-- Daftar Buku Dipinjam -->
            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Daftar Buku Dipinjam ({{ $peminjaman->detailPeminjaman->count() }} Buku)
                </h3>

                <div class="space-y-4">
                    @forelse($peminjaman->detailPeminjaman as $detail)
                        <div class="border border-slate-200 rounded-lg p-5 hover:border-indigo-300 hover:bg-indigo-50 transition-all">
                            @if($detail->buku)
                            <div class="flex items-start gap-4">
                                <!-- Thumbnail Placeholder -->
                                <div class="bg-slate-100 rounded-lg p-3 flex-shrink-0">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>

                                <!-- Informasi Buku -->
                                <div class="flex-1">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Judul Buku</p>
                                            <p class="text-slate-800 font-bold mt-1 line-clamp-2">{{ $detail->buku->judul }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">ID Eksamplar</p>
                                            <p class="text-slate-800 font-mono font-bold mt-1 text-lg tracking-wider">{{ $detail->id_eksamplar ?? str_pad($detail->buku->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Pengarang</p>
                                            <p class="text-slate-600 mt-1">{{ $detail->buku->nama_penulis ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Penerbit</p>
                                            <p class="text-slate-600 mt-1">{{ $detail->buku->penerbit ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <!-- Status Return for each book -->
                                    @if($peminjaman->pengembalian && $peminjaman->pengembalian->tgl_kembali)
                                        <div class="mt-4 pt-4 border-t border-slate-200">
                                            <div>
                                                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Tanggal Dikembalikan</p>
                                                <p class="text-slate-800 font-semibold mt-1">{{ $peminjaman->pengembalian->tgl_kembali->format('d F Y') }}</p>
                                                @if($peminjaman->pengembalian->denda > 0)
                                                    <div class="mt-2 pt-2 border-t border-slate-100">
                                                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Denda</p>
                                                        <p class="text-red-700 font-bold text-lg mt-1">Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="flex items-center gap-4">
                                <div class="bg-red-100 rounded-lg p-3 flex-shrink-0">
                                    <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-red-700 font-semibold">Data Buku Tidak Ditemukan</p>
                                    <p class="text-sm text-red-600 mt-1">Buku dengan ID #{{ $detail->buku_id }} telah dihapus dari sistem.</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-slate-500 font-medium">Tidak ada detail buku</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Informasi Pengembalian -->
            @if($peminjaman->pengembalian && $peminjaman->pengembalian->tgl_kembali)
                <div class="bg-white rounded-xl shadow-md border border-emerald-200 p-6 bg-emerald-50">
                    <h3 class="text-lg font-bold text-emerald-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Pengembalian
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-emerald-700 font-semibold">Tanggal Dikembalikan</p>
                            <p class="text-emerald-900 font-bold mt-1">{{ $peminjaman->pengembalian->tgl_kembali->format('d F Y') }}</p>
                            <p class="text-xs text-emerald-600 mt-1">{{ $peminjaman->pengembalian->tgl_kembali->format('H:i') }}</p>
                        </div>
                
                        <div>
                            <p class="text-sm text-emerald-700 font-semibold">Keterlambatan</p>
                            @php
                                $keterlambatan = $peminjaman->tgl_jatuh_tempo->diffInDays($peminjaman->pengembalian->tgl_kembali);
                            @endphp
                            <p class="text-emerald-900 font-bold mt-1">
                                @if($keterlambatan > 0)
                                    <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-sm">{{ $keterlambatan }} Hari Terlambat</span>
                                @else
                                    <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-sm">✓ Tepat Waktu</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Column: Summary -->
        <div class="lg:col-span-1">
            <!-- Summary Card -->
            <div class="sticky top-6 space-y-6">
                <!-- Status Summary -->
                <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6">
                    <h4 class="font-bold text-slate-800 mb-4">Ringkasan Peminjaman</h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-slate-200">
                            <span class="text-slate-600 font-medium">Total Buku</span>
                            <span class="text-2xl font-bold text-indigo-600">{{ $peminjaman->detailPeminjaman->count() }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-slate-200">
                            <span class="text-slate-600 font-medium">Durasi Peminjaman</span>
                            <span class="text-lg font-bold text-slate-800">{{ $peminjaman->tgl_pinjam->diffInDays($peminjaman->tgl_jatuh_tempo) }} Hari</span>
                        </div>

                        @if($peminjaman->status === 'dipinjam')
                            <div class="flex items-center justify-between py-3">
                                <span class="text-slate-600 font-medium">Sisa Waktu</span>
                                <span class="text-lg font-bold {{ now()->toDateString() > $peminjaman->tgl_jatuh_tempo ? 'text-red-600' : 'text-emerald-600' }}">
                                    @php
                                        $sisaHari = now()->diffInDays($peminjaman->tgl_jatuh_tempo);
                                        if(now()->toDateString() > $peminjaman->tgl_jatuh_tempo) {
                                            echo 'Terlambat ' . abs($sisaHari) . ' Hari';
                                        } else {
                                            echo $sisaHari . ' Hari';
                                        }
                                    @endphp
                                </span>
                            </div>
                        @else
                            <div class="flex items-center justify-between py-3">
                                <span class="text-slate-600 font-medium">Keterlambatan</span>
                                @php
                                    $keterlambatan = $peminjaman->tgl_jatuh_tempo->diffInDays($peminjaman->pengembalian->tgl_kembali);
                                @endphp
                                <span class="text-lg font-bold {{ $keterlambatan > 0 ? 'text-orange-600' : 'text-emerald-600' }}">
                                    {{ $keterlambatan > 0 ? $keterlambatan . ' Hari' : 'Tepat Waktu' }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>


</x-app-layout>
