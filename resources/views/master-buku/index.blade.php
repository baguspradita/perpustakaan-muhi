<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Kelola Buku</h2>
                <p class="text-slate-500 font-medium">Tambah, edit, dan hapus data buku perpustakaan</p>
            </div>
            <a href="{{ route('master-buku.create') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg flex items-center gap-2 w-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Buku
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="mb-6 bg-white p-6 rounded-lg shadow-sm border border-slate-200">
        <form action="{{ route('master-buku.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau penerbit..." class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <select name="kategori_id" class="px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2.5 bg-indigo-100 text-indigo-600 font-medium rounded-lg hover:bg-indigo-200 transition-colors">
                    Cari
                </button>
                @if(request('search') || request('kategori_id'))
                    <a href="{{ route('master-buku.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $item)
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600">{{ ($buku->currentPage() - 1) * $buku->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $item->judul }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $item->penulis }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-medium rounded-full text-xs">
                                    {{ optional($item->kategori)->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-center {{ $item->jumlah > 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $item->jumlah }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('master-buku.show', $item->id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 font-medium rounded-lg hover:bg-blue-600 hover:text-white transition-colors inline-flex items-center gap-1.5" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <span class="text-xs">Lihat</span>
                                    </a>
                                    <a href="{{ route('master-buku.edit', $item->id) }}" class="px-3 py-1.5 bg-amber-50 text-amber-600 font-medium rounded-lg hover:bg-amber-600 hover:text-white transition-colors inline-flex items-center gap-1.5" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span class="text-xs">Edit</span>
                                    </a>
                                    <form action="{{ route('master-buku.destroy', $item->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-600 hover:text-white transition-colors inline-flex items-center gap-1.5" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="text-xs">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-slate-500 font-medium">Tidak ada data buku</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($buku->count() > 0)
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $buku->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
