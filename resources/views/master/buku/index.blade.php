<x-app-layout>
    <!-- Header Halaman -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Master Katalog Buku</h2>
        <p class="text-slate-500 font-medium">Kelola koleksi buku di perpustakaan.</p>
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

    <!-- Card Tabel Buku -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- Header Card -->
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Daftar Katalog Buku</h3>
                <p class="text-sm text-slate-500">Total: {{ count($buku) }} buku</p>
            </div>
            <a href="{{ route('buku.create') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 active:bg-indigo-800 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></path></svg>
                Tambah Buku
            </a>
        </div>

        <!-- Tabel dengan scroll horizontal -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Judul</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Penulis</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Penerbit</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Tahun</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Stok</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($buku as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-8 py-4 text-sm font-semibold text-slate-800 whitespace-nowrap">{{ $item->judul }}</td>
                            <td class="px-8 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $item->penulis }}</td>
                            <td class="px-8 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $item->penerbit }}</td>
                            <td class="px-8 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $item->tahun_terbit }}</td>
                            <td class="px-8 py-4 text-sm">
                                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold whitespace-nowrap">
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-sm">
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold whitespace-nowrap">
                                    {{ $item->jumlah }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-sm flex gap-2 whitespace-nowrap">
                                <a href="{{ route('buku.edit', $item->id) }}" class="px-4 py-2 bg-amber-100 text-amber-700 font-semibold rounded-xl hover:bg-amber-200 transition-colors text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('buku.destroy', $item->id) }}" method="POST" style="display:inline;">
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
                            <td colspan="8" class="px-8 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></path></svg>
                                <p class="text-slate-500 font-medium">Tidak ada data buku</p>
                                <p class="text-slate-400 text-sm">Mulai dengan menambahkan buku baru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
