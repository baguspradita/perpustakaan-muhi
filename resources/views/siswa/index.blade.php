<x-app-layout>
    <!-- Header Halaman Daftar Siswa -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Daftar Siswa</h2>
        <p class="text-slate-500 font-medium">Kelola dan lihat informasi seluruh siswa di perpustakaan.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($stats['total']) }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Siswa Aktif</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($stats['aktif']) }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lulus</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($stats['lulus']) }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lainnya</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($stats['dikeluarkan']) }}</p>
            </div>
        </div>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="mb-8 bg-white p-2 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col md:flex-row items-center gap-2">
        <form action="{{ route('siswa.index') }}" method="GET" class="w-full flex flex-col md:flex-row items-center gap-2">
            <!-- Search Input -->
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="cari" placeholder="Cari nama siswa..." value="{{ request('cari') }}"
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 transition-all">
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <!-- Filter Jurusan -->
                <select name="jurusan_id" class="w-full md:w-48 px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 transition-all appearance-none cursor-pointer">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $jrs)
                    <option value="{{ $jrs->id }}" {{ request('jurusan_id') == $jrs->id ? 'selected' : '' }}>
                        {{ $jrs->nama_jurusan }}
                    </option>
                    @endforeach
                </select>

                <!-- Filter Status -->
                <select name="status" class="w-full md:w-40 px-4 py-3 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 transition-all appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="dikeluarkan" {{ request('status') == 'dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                    <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                </select>

                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                    Cari
                </button>

                @if(request('jurusan_id') || request('cari') || request('status'))
                <a href="{{ route('siswa.index') }}" class="p-3 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-100 transition-all" title="Reset Filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- TABEL SISWA -->
    <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <!-- Header Tabel -->
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Siswa</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Akademik</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kontak</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Body Tabel -->
                <tbody class="divide-y divide-slate-50">
                    @forelse($siswa as $item)
                    <tr class="group hover:bg-slate-50/80 transition-all">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-black text-sm uppercase">
                                    {{ substr($item->nama, 0, 1) }}{{ substr(strrchr($item->nama, " "), 1, 1) ?: substr($item->nama, 1, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors leading-none mb-1">{{ $item->nama }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $item->siswa->nisn ?? 'NISN TIDAK ADA' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-sm font-bold text-slate-700 mb-1">{{ $item->jurusan->nama_jurusan ?? '-' }}</p>
                            <p class="text-[11px] font-medium text-slate-500">Kelas: {{ $item->kelas ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-sm text-slate-700 font-medium mb-0.5">{{ $item->email }}</p>
                            <p class="text-xs text-slate-400">{{ $item->no_telp ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center">
                                <span class="px-3 py-1 bg-{{ $item->siswa->status_color }}-100 text-{{ $item->siswa->status_color }}-700 rounded-full text-[10px] font-black uppercase tracking-wider">
                                    {{ $item->siswa->status_label }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                <!-- View & Edit Buttons -->
                                <a href="{{ route('siswa.show', $item->id) }}" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-400 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('siswa.edit', $item->id) }}" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-400 rounded-lg hover:bg-amber-500 hover:text-white transition-all shadow-sm" title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <!-- Status Buttons -->
                                <div class="flex gap-1 flex-wrap justify-center border-l border-slate-100 pl-2">
                                    <!-- Aktif Button -->
                                    <form action="{{ route('siswa.quick-change-status', $item->id) }}" method="POST" class="inline group">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="aktif">
                                        <button type="submit" class="flex items-center gap-1 px-3 py-1.5 {{ $item->siswa->status == 'aktif' ? 'bg-emerald-600 text-white cursor-default' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white cursor-pointer' }} rounded-lg transition-all font-semibold text-[9px] uppercase tracking-tight shadow-sm hover:shadow-md group-hover:scale-105" {{ $item->siswa->status == 'aktif' ? 'disabled' : '' }} title="Ubah status siswa menjadi Aktif">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Aktif
                                        </button>
                                    </form>

                                    <!-- Lulus Button -->
                                    <form action="{{ route('siswa.quick-change-status', $item->id) }}" method="POST" class="inline group">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="lulus">
                                        <button type="submit" class="flex items-center gap-1 px-3 py-1.5 {{ $item->siswa->status == 'lulus' ? 'bg-blue-600 text-white cursor-default' : 'bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white cursor-pointer' }} rounded-lg transition-all font-semibold text-[9px] uppercase tracking-tight shadow-sm hover:shadow-md group-hover:scale-105" {{ $item->siswa->status == 'lulus' ? 'disabled' : '' }} title="Ubah status siswa menjadi Lulus">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M6 5a1 1 0 011-1h6a1 1 0 011 1v12a1 1 0 11-2 0v-3H8v3a1 1 0 11-2 0V5zm3 4a1 1 0 000 2h.01a1 1 0 000-2H9zm3 0a1 1 0 000 2h.01a1 1 0 000-2h-.01z"/></svg>
                                            Lulus
                                        </button>
                                    </form>

                                    <!-- Dikeluarkan Button -->
                                    <form action="{{ route('siswa.quick-change-status', $item->id) }}" method="POST" class="inline group">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="dikeluarkan">
                                        <button type="submit" class="flex items-center gap-1 px-3 py-1.5 {{ $item->siswa->status == 'dikeluarkan' ? 'bg-rose-600 text-white cursor-default' : 'bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white cursor-pointer' }} rounded-lg transition-all font-semibold text-[9px] uppercase tracking-tight shadow-sm hover:shadow-md group-hover:scale-105" {{ $item->siswa->status == 'dikeluarkan' ? 'disabled' : '' }} title="Ubah status siswa menjadi Dikeluarkan">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                            Keluar
                                        </button>
                                    </form>

                                    <!-- Pindah Button -->
                                    <form action="{{ route('siswa.quick-change-status', $item->id) }}" method="POST" class="inline group">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="pindah">
                                        <button type="submit" class="flex items-center gap-1 px-3 py-1.5 {{ $item->siswa->status == 'pindah' ? 'bg-amber-600 text-white cursor-default' : 'bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white cursor-pointer' }} rounded-lg transition-all font-semibold text-[9px] uppercase tracking-tight shadow-sm hover:shadow-md group-hover:scale-105" {{ $item->siswa->status == 'pindah' ? 'disabled' : '' }} title="Ubah status siswa menjadi Pindah">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                            Pindah
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-32 text-center">
                            <div class="inline-flex p-8 bg-slate-50 rounded-[2.5rem] mb-6 text-slate-200">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0"></path></svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-800 mb-2">Siswa tidak ditemukan</h3>
                            <p class="text-slate-400 font-medium">Coba gunakan filter atau kata kunci pencarian lain.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($siswa->total() > $siswa->perPage())
        <div class="px-8 py-6 bg-slate-50/30 border-t border-slate-50">
            {{ $siswa->links() }}
        </div>
        @endif
    </div>
</x-app-layout>