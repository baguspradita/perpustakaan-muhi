<x-app-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Edit Buku</h2>
    </div>

    @if($errors->any())
        <div class="mb-4 text-red-700">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('buku.update', $buku->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @error('judul')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @error('penulis')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @error('penerbit')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @error('tahun_terbit')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                <select name="kategori_id" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id', $buku->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Stok</label>
                <input type="number" name="jumlah" value="{{ old('jumlah', $buku->jumlah) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" min="0" required>
                @error('jumlah')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">Perbarui</button>
                <a href="{{ route('buku.index') }}" class="px-6 py-2 bg-slate-300 text-slate-800 font-medium rounded-lg hover:bg-slate-400 transition-colors">Batal</a>
            </div>
        </div>
    </form>
</x-app-layout>
