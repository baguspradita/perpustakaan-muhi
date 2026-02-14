<x-app-layout>
    <!-- Header Halaman -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('buku.index') }}" class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></path></svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Buku</h2>
        </div>
        <p class="text-slate-500 font-medium ml-11">Perbarui data buku di bawah.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 max-w-3xl">
        <form action="{{ route('buku.update', $buku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Row 1: Judul -->
            <div class="mb-6">
                <label for="judul" class="block text-sm font-bold text-slate-700 mb-2">Judul Buku</label>
                <input type="text" class="w-full px-4 py-3 rounded-xl border @error('judul') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="judul" name="judul" value="{{ $buku->judul }}">
                @error('judul')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.169 12.476l-4.604-4.604a2 2 0 00-2.828 0l-4.604 4.604a2 2 0 002.828 2.828l4.604-4.604a2 2 0 012.828 0l4.604 4.604a2 2 0 01-2.828 2.828z" clip-rule="evenodd"/></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Row 2: Penulis & Penerbit -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="penulis" class="block text-sm font-bold text-slate-700 mb-2">Penulis</label>
                    <input type="text" class="w-full px-4 py-3 rounded-xl border @error('penulis') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="penulis" name="penulis" value="{{ $buku->penulis }}">
                    @error('penulis')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.169 12.476l-4.604-4.604a2 2 0 00-2.828 0l-4.604 4.604a2 2 0 002.828 2.828l4.604-4.604a2 2 0 012.828 0l4.604 4.604a2 2 0 01-2.828 2.828z" clip-rule="evenodd"/></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="penerbit" class="block text-sm font-bold text-slate-700 mb-2">Penerbit</label>
                    <input type="text" class="w-full px-4 py-3 rounded-xl border @error('penerbit') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="penerbit" name="penerbit" value="{{ $buku->penerbit }}">
                    @error('penerbit')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.169 12.476l-4.604-4.604a2 2 0 00-2.828 0l-4.604 4.604a2 2 0 002.828 2.828l4.604-4.604a2 2 0 012.828 0l4.604 4.604a2 2 0 01-2.828 2.828z" clip-rule="evenodd"/></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Row 3: Tahun Terbit & Kategori -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="tahun_terbit" class="block text-sm font-bold text-slate-700 mb-2">Tahun Terbit</label>
                    <input type="number" class="w-full px-4 py-3 rounded-xl border @error('tahun_terbit') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="tahun_terbit" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" min="1800" max="{{ date('Y') }}">
                    @error('tahun_terbit')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.169 12.476l-4.604-4.604a2 2 0 00-2.828 0l-4.604 4.604a2 2 0 002.828 2.828l4.604-4.604a2 2 0 012.828 0l4.604 4.604a2 2 0 01-2.828 2.828z" clip-rule="evenodd"/></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="kategori_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori Buku</label>
                    <select class="w-full px-4 py-3 rounded-xl border @error('kategori_id') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="kategori_id" name="kategori_id">
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ $buku->kategori_id == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.169 12.476l-4.604-4.604a2 2 0 00-2.828 0l-4.604 4.604a2 2 0 002.828 2.828l4.604-4.604a2 2 0 012.828 0l4.604 4.604a2 2 0 01-2.828 2.828z" clip-rule="evenodd"/></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Row 4: Jumlah -->
            <div class="mb-8">
                <label for="jumlah" class="block text-sm font-bold text-slate-700 mb-2">Jumlah Buku</label>
                <input type="number" class="w-full px-4 py-3 rounded-xl border @error('jumlah') border-red-300 bg-red-50 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" id="jumlah" name="jumlah" value="{{ $buku->jumlah }}" min="1">
                @error('jumlah')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.169 12.476l-4.604-4.604a2 2 0 00-2.828 0l-4.604 4.604a2 2 0 002.828 2.828l4.604-4.604a2 2 0 012.828 0l4.604 4.604a2 2 0 01-2.828 2.828z" clip-rule="evenodd"/></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 active:bg-indigo-800 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></path></svg>
                    Update Buku
                </button>
                <a href="{{ route('buku.index') }}" class="flex-1 px-6 py-3 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
