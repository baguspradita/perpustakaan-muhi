<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Kelola Subjek Buku</h2>
        <p class="text-slate-500 font-medium">Tambah, edit, dan hapus data subjek/DDC perpustakaan</p>
        <div class="mt-4 flex gap-3 justify-end">
            <a href="{{ route('subjek-buku.create') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-md flex items-center gap-2 w-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Subjek
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

    <!-- Error Message -->
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="mb-6 bg-white p-6 rounded-lg shadow-md border border-slate-200">
        <form action="{{ route('subjek-buku.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode DDC atau nama subjek..." class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2.5 bg-indigo-100 text-indigo-600 font-medium rounded-lg hover:bg-indigo-200 transition-colors">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('subjek-buku.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-600 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Kode DDC</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama Subjek</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">📚 Buku</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjek as $item)
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600">{{ ($subjek->currentPage() - 1) * $subjek->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-indigo-600">{{ $item->kode_ddc }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $item->nama_subjek }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ \Illuminate\Support\Str::limit($item->deskripsi, 50, '...') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $bukuCount = $item->buku()->count();
                                @endphp
                                @if($bukuCount > 0)
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-full text-sm">
                                        {{ $bukuCount }} buku
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 font-medium rounded-full text-sm">
                                        0
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('subjek-buku.show', $item->id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 font-medium rounded-lg hover:bg-blue-600 hover:text-white transition-colors inline-flex items-center gap-1.5" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <span class="text-xs">Lihat</span>
                                    </a>
                                    <a href="{{ route('subjek-buku.edit', $item->id) }}" class="px-3 py-1.5 bg-amber-50 text-amber-600 font-medium rounded-lg hover:bg-amber-600 hover:text-white transition-colors inline-flex items-center gap-1.5" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span class="text-xs">Edit</span>
                                    </a>
                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-medium">Tidak ada data subjek</p>
                                <p class="text-sm">Mulai dengan menambahkan subjek baru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $subjek->links() }}
    </div>
</x-app-layout>
