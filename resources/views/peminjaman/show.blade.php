<x-app-layout>
    <x-slot name="title">Detail Peminjaman - Perpustakaan Muhi</x-slot>

    <!-- Header Halaman -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('peminjaman.index') }}" class="p-2 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Peminjaman</h2>
        </div>
        <p class="text-slate-500 font-medium ml-12">Informasi lengkap mengenai peminjaman buku oleh siswa.</p>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto">
        
        @php
            $statusClasses = [
                'dipinjam' => 'bg-amber-50 text-amber-600 border-amber-200',
                'kembali' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                'terlambat' => 'bg-rose-50 text-rose-600 border-rose-200',
            ];

            $now = \Carbon\Carbon::now()->startOfDay();
            $jatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->startOfDay();
            $currentStatus = $peminjaman->status;

            if ($currentStatus === 'dipinjam' && $now->greaterThan($jatuhTempo)) {
                $currentStatus = 'terlambat';
            }

            $class = $statusClasses[$currentStatus] ?? 'bg-slate-50 text-slate-600 border-slate-200';
        @endphp

        <!-- Main Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-md overflow-hidden">
            
            <!-- Header Card with Status -->
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-slate-100 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Peminjam Info -->
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-lg">
                            {{ substr($peminjaman->user->nama, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">{{ $peminjaman->user->nama }}</h3>
                            <p class="text-sm text-slate-500">{{ $peminjaman->user->jurusan->nama_jurusan ?? '-' }} • Kelas {{ $peminjaman->user->kelas ?? '-' }}</p>
                            <p class="text-xs text-slate-400 font-medium">{{ $peminjaman->user->email }}</p>
                        </div>
                    </div>
                    
                    <!-- Status Badge & Action -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <span class="inline-flex items-center px-4 py-2 border rounded-full text-sm font-black uppercase tracking-widest {{ $class }}">
                            @if($currentStatus == 'dipinjam')
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif($currentStatus == 'kembali')
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            @endif
                            {{ ucfirst($currentStatus) }}
                        </span>

                        @if(auth()->user()->role === 'petugas' && $currentStatus !== 'kembali')
                        <form id="returnForm{{ $peminjaman->id }}" action="{{ route('peminjaman.kembali', $peminjaman->id) }}" method="POST" onsubmit="return confirmReturn('returnForm{{ $peminjaman->id }}', 'buku-buku ini')">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-2xl shadow-lg shadow-emerald-100 transition-all hover:-translate-y-0.5 active:scale-95">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Kembalikan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detail Content -->
            <div class="p-6 sm:p-8">
                
                <!-- Data Peminjaman Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 mb-8 pb-8 border-b border-slate-100">
                    
                    <!-- Tanggal Pinjam -->
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Pinjam</p>
                        <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('d F Y') }}</p>
                    </div>

                    <!-- Tanggal Jatuh Tempo -->
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jatuh Tempo</p>
                        <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->translatedFormat('d F Y') }}</p>
                    </div>

                    <!-- Tanggal Kembali / Status -->
                    @if($peminjaman->pengembalian)
                    <div>
                        <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-2">Dikembalikan</p>
                        <p class="text-sm font-black text-emerald-700">{{ \Carbon\Carbon::parse($peminjaman->pengembalian->tgl_kembali)->translatedFormat('d F Y') }}</p>
                    </div>
                    @else
                        @php
                            $hariTerlambat = $jatuhTempo->diffInDays($now, false);
                        @endphp
                        @if($hariTerlambat > 0)
                        <div>
                            <p class="text-xs font-bold text-rose-500 uppercase tracking-wider mb-2">Keterlambatan</p>
                            <p class="text-sm font-black text-rose-700">{{ floor($hariTerlambat) }} Hari</p>
                        </div>
                        @else
                        <div>
                            <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-2">Sisa Waktu</p>
                            <p class="text-sm font-black text-indigo-700">{{ abs(floor($hariTerlambat)) }} Hari</p>
                        </div>
                        @endif
                    @endif

                    <!-- Total Buku -->
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Total Buku</p>
                        <p class="text-sm font-black text-indigo-600">{{ $peminjaman->detailPeminjaman->count() }} Buku</p>
                    </div>

                    <!-- Denda -->
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Denda</p>
                        @php
                            $denda = 0;
                            if ($peminjaman->pengembalian) {
                                $denda = $peminjaman->pengembalian->denda;
                            } elseif ($currentStatus === 'terlambat') {
                                $hariTerlambat = floor($jatuhTempo->diffInDays($now, false));
                                if ($hariTerlambat > 0) {
                                    $denda = $hariTerlambat * 1000;
                                }
                            }
                        @endphp
                        @if($denda > 0)
                            <p class="text-sm font-black text-rose-600">Rp {{ number_format($denda, 0, ',', '.') }}</p>
                        @else
                            <p class="text-sm font-black text-emerald-600">Rp 0</p>
                        @endif
                    </div>
                </div>

                <!-- Daftar Buku -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Buku yang Dipinjam
                    </h3>

                    @if($peminjaman->detailPeminjaman->count() > 0)
                        <div class="space-y-3">
                            @foreach($peminjaman->detailPeminjaman as $index => $detail)
                                @if($detail->buku)
                                <div class="flex items-start gap-4 p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:border-indigo-200 hover:shadow-md transition-all">
                                    <!-- No & Cover -->
                                    <div class="flex items-start gap-4 flex-1">
                                        <div class="w-12 h-16 bg-slate-200 rounded-lg flex-shrink-0 flex items-center justify-center shadow-inner overflow-hidden">
                                            @if($detail->buku->cover)
                                                <img src="{{ asset('storage/' . $detail->buku->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            @endif
                                        </div>

                                        <!-- Book Info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div>
                                                    <h4 class="text-sm font-bold text-slate-800 line-clamp-2">{{ $detail->buku->judul }}</h4>
                                                    <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $detail->buku->nama_penulis !== null ? $detail->buku->nama_penulis : '-' }}</p>
                                                </div>
                                                <span class="flex-shrink-0 px-2 py-1 bg-slate-200 text-slate-700 text-xs font-bold rounded-lg">{{ $index + 1 }}</span>
                                            </div>
                                            
                                            <!-- Tags -->
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <span class="inline-flex items-center px-2 py-1 bg-indigo-50 border border-indigo-100 rounded text-xs font-bold uppercase tracking-widest text-indigo-600">
                                                    {{ $detail->buku->kategori->nama_kategori ?? 'Kategori' }}
                                                </span>
                                                @if($detail->id_eksamplar)
                                                    <span class="inline-flex items-center px-2 py-1 bg-emerald-50 border border-emerald-100 rounded text-xs font-bold uppercase tracking-widest text-emerald-600">
                                                        Salinan: {{ $detail->id_eksamplar }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-3">
                                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <span class="text-rose-700 font-bold text-sm">Data buku tidak ditemukan atau telah dihapus.</span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="text-slate-500 text-sm font-medium">Tidak ada buku dalam peminjaman ini</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>

</x-app-layout>