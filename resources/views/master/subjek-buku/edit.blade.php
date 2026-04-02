<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Subjek Buku</h2>
        <p class="text-slate-500 font-medium mt-1">Perbarui informasi subjek di bawah</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
            <h3 class="font-bold mb-3">Ada kesalahan dalam form:</h3>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('subjek-buku.update', $subjek->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kode DDC <span class="text-red-500">*</span></label>
                <input type="text" name="kode_ddc" value="{{ old('kode_ddc', $subjek->kode_ddc) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g., 510, 820, 900" required>
                <p class="text-xs text-slate-500 mt-1">Gunakan format Dewey Decimal Classification (DDC)</p>
                @error('kode_ddc')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Subjek <span class="text-red-500">*</span></label>
                <input type="text" name="nama_subjek" value="{{ old('nama_subjek', $subjek->nama_subjek) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g., Matematika, Sastra Inggris" required>
                @error('nama_subjek')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Penjelasan singkat tentang subjek ini (opsional)">{{ old('deskripsi', $subjek->deskripsi) }}</textarea>
                @error('deskripsi')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <!-- Statistik Buku -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm font-medium text-blue-900">📊 Total Buku dengan Subjek Ini:</p>
                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $subjek->buku()->count() }} buku</p>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <button type="submit" class="px-6 py-2.5 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Perbarui Subjek
                </button>
                <a href="{{ route('subjek-buku.index') }}" class="px-6 py-2.5 bg-slate-300 text-slate-800 font-semibold rounded-lg hover:bg-slate-400 transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Batal
                </a>
            </div>
        </div>
    </form>
</x-app-layout>
