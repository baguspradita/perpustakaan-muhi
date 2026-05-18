<x-app-layout>
    <!-- Header Halaman Master Lokasi -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Lokasi Buku</h2>
        <p class="text-slate-500 font-medium">Kelola data rak dan lemari penyimpanan buku.</p>
    </div>

    <!-- Alert Sukses -->
    @if($message = Session::get('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3">
        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <div>
            <p class="font-semibold text-emerald-900">Berhasil!</p>
            <p class="text-sm text-emerald-700">{{ $message }}</p>
        </div>
        <button onclick="this.parentElement.style.display='none'" class="ml-auto text-emerald-400 hover:text-emerald-600">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif

    <!-- Alert Error -->
    @if($message = Session::get('error'))
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-3">
        <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
        <div>
            <p class="font-semibold text-rose-900">Gagal!</p>
            <p class="text-sm text-rose-700">{{ $message }}</p>
        </div>
    </div>
    @endif

    <!-- Card Tabel Lokasi -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-md overflow-hidden">
        <div class="px-8 py-8 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800 leading-snug">Daftar Lokasi</h3>
                <p class="text-sm text-slate-500">Total: {{ $lokasi->total() }} lokasi</p>
            </div>
            <a href="{{ route('lokasi.create') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 active:bg-indigo-800 transition-colors flex items-center gap-2 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Lokasi
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama Lokasi</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Keterangan</th>
                        <th class="px-8 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Status</th>
                        <th class="px-8 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($lokasi as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-4 text-sm text-slate-600">{{ ($lokasi->currentPage() - 1) * $lokasi->perPage() + $loop->iteration }}</td>
                        <td class="px-8 py-4 text-sm font-semibold text-slate-800">
                            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                                {{ $item->nama_lokasi }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-sm text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                        <td class="px-8 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $item->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-sm flex gap-2">
                            <a href="{{ route('lokasi.edit', $item->id) }}" class="px-3 py-1.5 bg-amber-50 text-amber-600 font-medium rounded-lg hover:bg-amber-600 hover:text-white transition-colors inline-flex items-center gap-1.5" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="text-xs">Edit</span>
                            </a>
                            <form action="{{ route('lokasi.update-status', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $item->status === 'aktif' ? 'nonaktif' : 'aktif' }}">
                                <button type="submit" class="px-3 py-1.5 {{ $item->status === 'aktif' ? 'bg-red-50 text-red-600 hover:bg-red-600' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600' }} font-medium rounded-lg hover:text-white transition-colors inline-flex items-center gap-1.5" title="{{ $item->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span class="text-xs">{{ $item->status === 'aktif' ? 'Nonaktif' : 'Aktif' }}</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-slate-500 font-medium">Tidak ada data lokasi</p>
                            <p class="text-slate-400 text-sm">Mulai dengan menambahkan lokasi baru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-4 border-t border-slate-100">
            {{ $lokasi->links() }}
        </div>
    </div>
</x-app-layout>
