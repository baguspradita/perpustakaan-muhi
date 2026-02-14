<x-app-layout>
    <!-- Header Halaman Daftar Siswa -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Daftar Siswa</h2>
            <p class="text-slate-500 font-medium">Kelola dan lihat informasi seluruh siswa di perpustakaan.</p>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="flex items-center space-x-2">
            <form action="{{ route('siswa.index') }}" method="GET" class="flex items-center space-x-2 gap-2">
                <!-- Filter Jurusan -->
                <select name="jurusan_id" onchange="this.form.submit()" class="bg-white px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $jrs)
                        <option value="{{ $jrs->id }}" {{ request('jurusan_id') == $jrs->id ? 'selected' : '' }}>
                            {{ $jrs->nama_jurusan }}
                        </option>
                    @endforeach
                </select>

                <!-- Pencarian Nama -->
                <input type="text" name="cari" placeholder="Cari nama siswa..." value="{{ request('cari') }}"
                       class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">
                    Cari
                </button>

                @if(request('jurusan_id') || request('cari'))
                    <a href="{{ route('siswa.index') }}" class="p-2 text-slate-400 hover:text-red-500" title="Reset Filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- TABEL SISWA -->
    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <!-- Header Tabel -->
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 font-bold text-slate-800">No.</th>
                        <th class="px-6 py-4 font-bold text-slate-800">Nama</th>
                        <th class="px-6 py-4 font-bold text-slate-800">Email</th>
                        <th class="px-6 py-4 font-bold text-slate-800">Jurusan</th>
                        <th class="px-6 py-4 font-bold text-slate-800">Kelas</th>
                        <th class="px-6 py-4 font-bold text-slate-800">No. Telepon</th>
                        <th class="px-6 py-4 font-bold text-slate-800 text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Body Tabel -->
                <tbody>
                    @forelse($siswa as $item)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-600 font-medium">{{ ($siswa->currentPage() - 1) * $siswa->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $item->nama }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-sm">{{ $item->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg">
                                    {{ $item->jurusan->nama_jurusan ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-semibold">{{ $item->kelas ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600 text-sm">{{ $item->no_telp ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('siswa.show', $item->id) }}" class="inline-block px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-600 hover:text-white transition-colors" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <!-- Tampilan Jika Data Kosong -->
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="inline-flex p-6 bg-slate-50 rounded-full mb-4 text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 mt-4">Siswa tidak ditemukan</h3>
                                <p class="text-slate-500">Silakan coba pencarian atau filter lain.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($siswa->count() > 0)
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $siswa->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
