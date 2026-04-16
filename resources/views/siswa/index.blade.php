<x-app-layout>
    <!-- Header Halaman Daftar Siswa -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Daftar Siswa</h2>
        <p class="text-slate-500 font-medium">Kelola dan lihat informasi seluruh siswa di perpustakaan.</p>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="mb-6 bg-white p-6 rounded-lg shadow-md border border-slate-200">
        <form action="{{ route('siswa.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Filter Jurusan -->
            <select name="jurusan_id" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                <option value="">Semua Jurusan</option>
                @foreach($jurusan as $jrs)
                    <option value="{{ $jrs->id }}" {{ request('jurusan_id') == $jrs->id ? 'selected' : '' }}>
                        {{ $jrs->nama_jurusan }}
                    </option>
                @endforeach
            </select>

            <!-- Pencarian Nama -->
            <input type="text" name="cari" placeholder="Cari nama siswa..." value="{{ request('cari') }}"
                   class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2.5 bg-indigo-100 text-indigo-600 font-medium rounded-lg hover:bg-indigo-200 transition-colors">
                    Cari
                </button>

                @if(request('jurusan_id') || request('cari'))
                    <a href="{{ route('siswa.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- TABEL SISWA -->
    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-md">
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
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('siswa.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-600 font-medium rounded-lg hover:bg-indigo-600 hover:text-white transition-colors gap-1.5" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <span class="text-xs">Detail</span>
                                    </a>
                                    <a href="{{ route('siswa.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-600 font-medium rounded-lg hover:bg-amber-600 hover:text-white transition-colors gap-1.5" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span class="text-xs">Edit</span>
                                    </a>
                                    <form id="deleteFormSiswa{{ $item->id }}" action="{{ route('siswa.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirmDelete('deleteFormSiswa{{ $item->id }}', '{{ $item->nama }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-600 hover:text-white transition-colors gap-1.5" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="text-xs">Hapus</span>
                                        </button>
                                    </form>
                                </div>
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
