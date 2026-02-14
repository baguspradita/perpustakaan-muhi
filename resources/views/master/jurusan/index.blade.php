<x-app-layout>
    <!-- Header Halaman Master Jurusan -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Master Jurusan</h2>
        <p class="text-slate-500 font-medium">Kelola data jurusan yang tersedia di sekolah.</p>
    </div>

    <!-- Alert Sukses -->
    @if($message = Session::get('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></path></svg>
            <div>
                <p class="font-semibold text-emerald-900">Berhasil!</p>
                <p class="text-sm text-emerald-700">{{ $message }}</p>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="ml-auto text-emerald-400 hover:text-emerald-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></path></svg>
            </button>
        </div>
    @endif

    <!-- Card Tabel Jurusan -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- Header Card dengan Tombol Tambah (padding diperbesar agar teks tidak terpotong) -->
        <div class="px-8 py-8 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800 leading-snug">Daftar Jurusan</h3>
                <p class="text-sm text-slate-500">Total: {{ count($jurusan) }} jurusan</p>
            </div>
            <a href="{{ route('jurusan.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 active:bg-indigo-800 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></path></svg>
                Tambah Jurusan
            </a>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama Jurusan</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jurusan as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-4 text-sm text-slate-600">{{ $loop->iteration }}</td>
                            <td class="px-8 py-4 text-sm font-semibold text-slate-800">
                                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">
                                    {{ $item->nama_jurusan }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-sm text-slate-600">{{ $item->deskripsi ?? '-' }}</td>
                            <td class="px-8 py-4 text-sm flex gap-2">
                                <a href="{{ route('jurusan.edit', $item->id) }}" class="px-4 py-2 bg-amber-100 text-amber-700 font-semibold rounded-xl hover:bg-amber-200 transition-colors text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('jurusan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 font-semibold rounded-xl hover:bg-red-200 transition-colors text-xs" onclick="return confirm('Yakin ingin menghapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></path></svg>
                                <p class="text-slate-500 font-medium">Tidak ada data jurusan</p>
                                <p class="text-slate-400 text-sm">Mulai dengan menambahkan jurusan baru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
