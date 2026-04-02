<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Subjek Buku</h2>
        <p class="text-slate-500 font-medium mt-1">Informasi lengkap subjek yang dipilih</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Detail Card -->
        <div class="lg:col-span-2 bg-white p-8 rounded-lg shadow-md">
            <div class="grid grid-cols-1 gap-6">
                <div class="border-b border-slate-200 pb-4">
                    <p class="text-sm text-slate-500 mb-1 font-medium">Kode DDC</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $subjek->kode_ddc }}</p>
                </div>

                <div class="border-b border-slate-200 pb-4">
                    <p class="text-sm text-slate-500 mb-1 font-medium">Nama Subjek</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $subjek->nama_subjek }}</p>
                </div>

                <div class="border-b border-slate-200 pb-4">
                    <p class="text-sm text-slate-500 mb-1 font-medium">Deskripsi</p>
                    <p class="text-lg text-slate-800">{{ $subjek->deskripsi ?? '—' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600 font-medium">Dibuat pada</p>
                        <p class="text-sm text-slate-800 mt-1">{{ $subjek->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-lg">
                        <p class="text-sm text-slate-600 font-medium">Diperbarui</p>
                        <p class="text-sm text-slate-800 mt-1">{{ $subjek->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('subjek-buku.edit', $subjek->id) }}" class="px-6 py-2.5 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                    <a href="{{ route('subjek-buku.index') }}" class="px-6 py-2.5 bg-slate-300 text-slate-800 font-semibold rounded-lg hover:bg-slate-400 transition-colors inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar: Buku dengan Subjek Ini -->
        <div class="bg-white p-6 rounded-lg shadow-md h-fit">
            <div class="mb-6">
                <p class="text-sm text-slate-600 font-medium uppercase tracking-wider">📚 Buku</p>
                <p class="text-3xl font-bold text-indigo-600 mt-1">{{ $subjek->buku()->count() }}</p>
                <p class="text-xs text-slate-500 mt-1">Buku dengan subjek ini</p>
            </div>

            @if($subjek->buku()->count() > 0)
                <div class="border-t border-slate-200 pt-4">
                    <p class="text-xs font-bold text-slate-600 uppercase mb-3">Daftar Buku:</p>
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach($subjek->buku()->limit(10)->get() as $buku)
                            <div class="text-xs p-2 bg-slate-50 rounded">
                                <a href="{{ route('master-buku.show', $buku->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium line-clamp-2">
                                    {{ $buku->judul }}
                                </a>
                                <p class="text-slate-600 mt-1">{{ $buku->nama_depan_penulis }}</p>
                            </div>
                        @endforeach
                        @if($subjek->buku()->count() > 10)
                            <p class="text-xs text-slate-500 italic mt-2">... dan {{ $subjek->buku()->count() - 10 }} buku lainnya</p>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-sm text-slate-500 italic border-t border-slate-200 pt-4">Belum ada buku dengan subjek ini</p>
            @endif
        </div>
    </div>
</x-app-layout>
