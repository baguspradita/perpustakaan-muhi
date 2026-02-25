<x-app-layout>
    <x-slot name="title">Tambah Peminjaman - Perpustakaan Muhi</x-slot>

    <!-- Header Halaman -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('peminjaman.index') }}" class="p-2 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Catat Peminjaman</h2>
        </div>
        <p class="text-slate-500 font-medium ml-12">Silakan isi formulir di bawah untuk mencatat peminjaman baru.</p>
    </div>

    <!-- Main Card -->
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-8">
                
                @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Kiri: Data Siswa & Tanggal -->
                    <div class="space-y-6">
                        <div>
                            <label for="user_id" class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Pilih Siswa</label>
                            <select name="user_id" id="user_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800" required>
                                <option value="" disabled selected>Cari nama siswa...</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->jurusan->nama }})</option>
                                @endforeach
                            </select>
                            @error('user_id') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="tgl_pinjam" class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Tanggal Pinjam</label>
                            <input type="date" name="tgl_pinjam" id="tgl_pinjam" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800" required>
                            @error('tgl_pinjam') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="tgl_jatuh_tempo" class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Tanggal Jatuh Tempo</label>
                            <input type="date" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800" required>
                            @error('tgl_jatuh_tempo') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Kanan: Pilih Buku -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Pilih Buku (Maks. 3)</label>
                            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-4 max-h-80 overflow-y-auto space-y-2">
                                @forelse($buku as $b)
                                <label class="flex items-center p-3 bg-white rounded-2xl border border-slate-100 cursor-pointer hover:border-indigo-200 hover:bg-indigo-50/30 transition-all group">
                                    <input type="checkbox" name="buku_id[]" value="{{ $b->id }}" class="w-5 h-5 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 mr-3">
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-slate-800">{{ $b->judul }}</p>
                                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ $b->kategori->nama }} • Jumlah: <span class="text-indigo-600">{{ $b->jumlah }}</span></p>
                                    </div>
                                </label>
                                @empty
                                <p class="text-center py-4 text-slate-400 text-sm font-medium">Tidak ada buku tersedia.</p>
                                @endforelse
                            </div>
                            @error('buku_id') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>

                <div class="mt-10 flex items-center justify-end gap-3">
                    <a href="{{ route('peminjaman.index') }}" class="px-6 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 text-sm font-bold rounded-2xl transition-all">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-indigo-100 transition-all hover:-translate-y-0.5 active:scale-95">
                        Simpan Peminjaman
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
