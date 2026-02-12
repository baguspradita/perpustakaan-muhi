<x-app-layout>
    <!-- Header Halaman Katalog -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Katalog Buku</h2>
            <p class="text-slate-500 font-medium">Jelajahi dan temukan buku favoritmu di sini.</p>
        </div>

        <!-- Filter Sederhana -->
        <div class="flex items-center space-x-2">
            <form action="{{ route('buku.index') }}" method="GET" class="flex items-center space-x-2">
                <select name="kategori_id" onchange="this.form.submit()" class="bg-white px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @if(request('kategori_id'))
                    <a href="{{ route('buku.index') }}" class="p-2 text-slate-400 hover:text-red-500" title="Reset Filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- GRID BUKU -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($buku as $item)
            <!-- Card Buku Individu -->
            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group">
                <!-- Cover Placeholder (Warna Gradasi) -->
                <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 p-6 flex flex-col justify-end">
                    <span class="inline-block px-2.5 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-lg mb-2">
                        {{ $item->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                    <h3 class="text-white font-bold text-lg leading-tight line-clamp-2">{{ $item->judul }}</h3>
                </div>

                <!-- Info Buku -->
                <div class="p-6">
                    <p class="text-sm text-slate-400 font-medium mb-1">Penulis</p>
                    <p class="text-slate-800 font-bold mb-4">{{ $item->penulis }}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                        <div class="text-xs">
                            <span class="text-slate-400">Stok:</span>
                            <span class="font-bold {{ $item->jumlah > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $item->jumlah }} eks
                            </span>
                        </div>
                        <button class="px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                            Detail
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <!-- Tampilan Jika Data Kosong -->
            <div class="col-span-full py-20 text-center">
                <div class="inline-flex p-6 bg-slate-50 rounded-full mb-4 text-slate-300">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Buku tidak ditemukan</h3>
                <p class="text-slate-500">Silakan coba kata kunci atau kategori lain.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination (Jika Ada) -->
    <div class="mt-12">
        {{ $buku->links() }}
    </div>
</x-app-layout>
