<x-app-layout>
    <x-slot name="title">Detail Peminjaman - Perpustakaan Muhi</x-slot>

    <!-- Header Halaman -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('peminjaman.index') }}" class="p-2 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Peminjaman</h2>
        </div>
        <p class="text-slate-500 font-medium ml-12">Informasi lengkap mengenai peminjaman buku oleh siswa.</p>
    </div>

    <!-- Main Card -->
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Status & Aksi -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Status Peminjaman</p>
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
                    {{ $currentStatus }}
                </span>
            </div>

            @if(auth()->user()->role === 'petugas' && $currentStatus !== 'kembali')
            <form action="{{ route('peminjaman.kembali', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin buku-buku ini telah dikembalikan?')">
                @csrf
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-emerald-200 transition-all hover:-translate-y-0.5 active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
                    </svg>
                    Proses Pengembalian
                </button>
            </form>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Peminjaman & Siswa -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Info Siswa -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full opacity-50 z-0 pointer-events-none"></div>

                    <div class="relative z-10">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Peminjam
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Nama Siswa</p>
                                <p class="text-base font-bold text-slate-800">{{ $peminjaman->user->nama }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Jurusan & Kelas</p>
                                <p class="text-base font-bold text-slate-800">{{ $peminjaman->user->jurusan->nama_jurusan ?? '-' }} Kelas {{ $peminjaman->user->kelas ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">No. Telepon & Email</p>
                                <p class="text-sm font-bold text-slate-800">{{ $peminjaman->user->no_telp ?? '-' }}</p>
                                <p class="text-sm text-slate-500">{{ $peminjaman->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Waktu -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 relative overflow-hidden">
                        <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-amber-50 rounded-full opacity-50 z-0 pointer-events-none"></div>

                        <div class="relative z-10">
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Waktu Peminjaman
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Tanggal Pinjam</p>
                                    <p class="text-base font-bold text-slate-800">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('d F Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Tanggal Jatuh Tempo</p>
                                    <p class="text-base font-bold text-slate-800">{{ \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->translatedFormat('d F Y') }}</p>
                                </div>

                                @if($peminjaman->pengembalian)
                                <div class="pt-4 border-t border-slate-100">
                                    <p class="text-base font-bold text-emerald-700 uppercase">Dikembalikan Pada</p>
                                    <p class="text-base font-black text-emerald-700">{{ \Carbon\Carbon::parse($peminjaman->pengembalian->tgl_kembali)->translatedFormat('d F Y') }}</p>
                                </div>
                                @else

                                @php
                                $hariTerlambat = $jatuhTempo->diffInDays($now, false);
                                @endphp
                                @if($hariTerlambat > 0)
                                <div class="pt-4 border-t border-slate-100">
                                    <p class="text-xs font-bold text-rose-500 uppercase">Keterlambatan</p>
                                    <p class="text-base font-black text-rose-700">{{ floor($hariTerlambat) }} Hari</p>
                                </div>
                                @else
                                <div class="pt-4 border-t border-slate-100">
                                    <p class="text-xs font-bold text-slate-400 uppercase">Sisa Waktu Peminjaman</p>
                                    <p class="text-base font-black text-indigo-600">{{ abs(floor($hariTerlambat)) }} Hari lagi</p>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>

                        <!-- Denda -->
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 relative overflow-hidden">
                            <div class="relative z-10">
                                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Informasi Denda
                                </h3>

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
                                <div class="text-center p-4 bg-rose-50 border border-rose-100 rounded-2xl">
                                    <p class="text-xs font-bold text-rose-500 uppercase mb-1">Total Denda @if(!$peminjaman->pengembalian) (Estimasi) @endif</p>
                                    <p class="text-3xl font-black text-rose-600">Rp {{ number_format($denda, 0, ',', '.') }}</p>
                                    @if(!$peminjaman->pengembalian)
                                    <p class="text-xs font-medium text-rose-400 mt-2">* Bertambah Rp 1.000/hari</p>
                                    @endif
                                </div>
                                @else
                                <div class="text-center p-4 bg-emerald-50 border border-emerald-100 rounded-2xl">
                                    <svg class="w-8 h-8 text-emerald-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm font-black text-emerald-700">Tidak ada denda</p>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Daftar Buku -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 h-full">
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Buku yang Dipinjam
                            </h3>

                            <div class="space-y-4">
                                @foreach($peminjaman->detailPeminjaman as $detail)
                                @if($detail->buku)
                                <div class="flex items-start p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <div class="w-16 h-20 bg-slate-200 rounded-lg flex-shrink-0 flex items-center justify-center mr-4 shadow-inner overflow-hidden">
                                        @if($detail->buku->cover)
                                        <img src="{{ asset('storage/' . $detail->buku->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                        @else
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-slate-800 leading-tight mb-1">{{ $detail->buku->judul }}</h4>
                                        <p class="text-sm font-medium text-slate-500 mb-2">{{ $detail->buku->pengarang }} • {{ $detail->buku->penerbit }}</p>

                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center px-2 py-1 bg-indigo-50 border border-indigo-100 rounded-lg text-[10px] font-black uppercase tracking-widest text-indigo-600">
                                                {{ $detail->buku->kategori->nama_kategori ?? 'Kategori' }}
                                            </span>
                                            @if($detail->id_eksamplar)
                                            <span class="inline-flex items-center px-2 py-1 bg-emerald-50 border border-emerald-100 rounded-lg text-[10px] font-black uppercase tracking-widest text-emerald-600">
                                                ID Eksamplar: {{ $detail->id_eksamplar }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <span class="text-rose-700 font-bold text-sm">Data buku tidak ditemukan atau telah dihapus.</span>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
</x-app-layout>