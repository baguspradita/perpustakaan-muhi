<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Riwayat Peminjaman</h2>
                <p class="text-slate-500 font-medium">Daftar semua peminjaman Anda</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card: Total Peminjaman -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-semibold">Total Peminjaman</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $riwayat->total() }}</p>
                </div>
                <div class="bg-indigo-50 p-4 rounded-full">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card: Sedang Dipinjam -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-semibold">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">
                        {{ $riwayat->filter(fn($r) => $r->status === 'dipinjam')->count() }}
                    </p>
                </div>
                <div class="bg-amber-50 p-4 rounded-full">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card: Sudah Dikembalikan -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-semibold">Sudah Dikembalikan</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $riwayat->filter(fn($r) => $r->status === 'dikembalikan')->count() }}
                    </p>
                </div>
                <div class="bg-emerald-50 p-4 rounded-full">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Peminjaman -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-slate-700">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-700">Tanggal Peminjaman</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-700">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-700">Jumlah Buku</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-700">Status</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($riwayat as $peminjaman)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ ($riwayat->currentPage() - 1) * 10 + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <span class="font-medium">{{ $peminjaman->tgl_pinjam->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-slate-600">{{ $peminjaman->tgl_jatuh_tempo->format('d/m/Y') }}</span>
                                @if($peminjaman->status === 'dipinjam' && $peminjaman->tgl_jatuh_tempo < now()->toDateString())
                                    <span class="inline-block ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                        Terlambat
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-50 text-indigo-700">
                                    {{ $peminjaman->detailPeminjaman->count() }} Buku
                                </span>
                            </td>
                            <td class="px-6 py-4">
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
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('riwayat-peminjaman.show', $peminjaman->id) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="text-slate-500 font-medium">Belum ada riwayat peminjaman</p>
                                    <a href="{{ route('buku.index') }}"
                                       class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">
                                        Jelajahi Katalog Buku
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $riwayat->links() }}
        </div>
    </div>

</x-app-layout>
