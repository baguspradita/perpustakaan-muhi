<x-app-layout>
    <x-slot name="title">Daftar Peminjaman - Perpustakaan Muhi</x-slot>

    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Peminjaman Buku</h2>
            <p class="text-slate-500 font-medium">Kelola transaksi peminjaman buku siswa di sini.</p>
        </div>
        <div>
            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-indigo-100 transition-all hover:-translate-y-0.5 active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Peminjaman
            </a>
        </div>
    </div>

    <!-- Alert Success/Error -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Table Section -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Denda</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($peminjaman as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold mr-3">
                                    {{ substr($p->user->nama, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $p->user->nama }}</p>
                                    <p class="text-xs text-slate-500 font-medium">{{ $p->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                @foreach($p->detailPeminjaman as $detail)
                                <span class="inline-block px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-lg">{{ $detail->buku->judul }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                            {{ \Carbon\Carbon::parse($p->tgl_pinjam)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                            {{ \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = [
                                    'dipinjam' => 'bg-amber-50 text-amber-600',
                                    'kembali' => 'bg-emerald-50 text-emerald-600',
                                    'terlambat' => 'bg-rose-50 text-rose-600',
                                ];

                                // Update status secara dinamis jika terlambat
                                $now = \Carbon\Carbon::now()->startOfDay();
                                $jatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->startOfDay();
                                $currentStatus = $p->status;
                                
                                if ($currentStatus === 'dipinjam' && $now->greaterThan($jatuhTempo)) {
                                    $currentStatus = 'terlambat';
                                }

                                $class = $statusClasses[$currentStatus] ?? 'bg-slate-50 text-slate-600';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest {{ $class }}">
                                {{ $currentStatus }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @php
                                $denda = 0;
                                if ($p->pengembalian) {
                                    $denda = $p->pengembalian->denda;
                                } elseif ($currentStatus === 'terlambat') {
                                    // Hitung dari jatuhTempo → sekarang agar hasilnya positif
                                    $hariTerlambat = $jatuhTempo->diffInDays($now);
                                    $denda = $hariTerlambat * 1000;
                                }
                            @endphp
                            
                            @if($p->pengembalian)
                                {{-- Denda permanen dari DB setelah dikembalikan --}}
                                @if($p->pengembalian->denda > 0)
                                    <span class="text-sm font-black text-rose-600">Rp {{ number_format($p->pengembalian->denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-sm font-bold text-emerald-500">Rp 0</span>
                                @endif
                            @elseif($currentStatus === 'terlambat')
                                {{-- Denda dinamis (estimasi) selama belum dikembalikan --}}
                                <span class="text-sm font-black text-rose-600" title="Estimasi denda, belum final">
                                    Rp {{ number_format($denda, 0, ',', '.') }}
                                    <span class="text-xs font-normal text-rose-400">*</span>
                                </span>
                            @else
                                <span class="text-sm font-bold text-slate-400">Rp 0</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            @if($currentStatus !== 'kembali')
                            <form action="{{ route('peminjaman.kembali', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin buku-buku ini telah dikembalikan?')">
                                @csrf
                                <button type="submit" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors" title="Kembalikan Buku">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                                </button>
                            </form>
                            @endif

                            <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors" title="Detail Peminjaman">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-4 bg-slate-50 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800">Belum ada peminjaman</h3>
                                <p class="text-slate-500">Mulai catat peminjaman buku hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($peminjaman->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $peminjaman->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
