<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Buku</h2>
        <p class="text-slate-500 font-medium mt-1">Perbarui informasi buku di bawah</p>
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

    <form action="{{ route('master-buku.update', $buku->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan judul buku" required>
                @error('judul')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Depan Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_depan_penulis" value="{{ old('nama_depan_penulis', $buku->nama_depan_penulis) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Nama depan" required>
                    @error('nama_depan_penulis')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Belakang Penulis</label>
                    <input type="text" name="nama_belakang_penulis" value="{{ old('nama_belakang_penulis', $buku->nama_belakang_penulis) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Nama belakang (opsional)">
                    @error('nama_belakang_penulis')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Penerbit <span class="text-red-500">*</span></label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Nama penerbit" required>
                @error('penerbit')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Terbit <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2024" min="1900" max="2099" required>
                    @error('tahun_terbit')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Total Salinan Saat Ini</label>
                    <div class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-slate-50 text-slate-700 font-semibold">
                        {{ $allCopies->count() }} salinan
                    </div>
                </div>
            </div>

            <div class="p-4 bg-emerald-50 border-2 border-emerald-200 rounded-lg">
                <label class="block text-sm font-medium text-emerald-900 mb-2">➕ Tambah Stok (Jumlah Salinan Baru)</label>
                <div class="flex items-center gap-2">
                    <input 
                        type="number" 
                        name="tambah_stok" 
                        id="tambah_stok"
                        value="{{ old('tambah_stok', 0) }}" 
                        class="flex-1 px-4 py-3 border-2 border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" 
                        placeholder="0" 
                        min="0"
                        inputmode="numeric">
                    <span class="text-emerald-900 font-medium text-sm whitespace-nowrap">salinan</span>
                    <span id="tambah_stok_status" class="text-sm font-medium px-3 py-1 rounded bg-emerald-200 text-emerald-800 hidden">✓</span>
                </div>
                
                <div id="stok_preview" class="mt-3 p-3 bg-emerald-100 rounded-lg text-sm text-emerald-900 font-medium hidden">
                    <span id="preview_text">Akan menambah <strong>0</strong> salinan</span> → Total akan menjadi <strong id="preview_total">{{ $allCopies->count() }}</strong> salinan
                </div>
                
                <p class="text-xs text-emerald-700 mt-3 font-medium bg-emerald-100 p-2 rounded">
                    📝 <span class="font-bold">Contoh:</span> Saat ini ada <span class="font-bold text-emerald-800">{{ $allCopies->count() }}</span> salinan<br>
                    ➕ Input <span class="font-bold text-emerald-800">1</span> → tambah 1 copy (c.{{ $allCopies->count() + 1 }}) = total {{ $allCopies->count() + 1 }}<br>
                    ➕ Input <span class="font-bold text-emerald-800">5</span> → tambah 5 copy (c.{{ $allCopies->count() + 1 }}-c.{{ $allCopies->count() + 5 }}) = total {{ $allCopies->count() + 5 }}<br>
                    ➕ Input <span class="font-bold text-emerald-800">0</span> → tidak tambah apapun, hanya update info buku
                </p>
                @error('tambah_stok')<span class="text-red-500 text-sm mt-2 block font-medium">⚠️ {{ $message }}</span>@enderror
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputField = document.getElementById('tambah_stok');
                const statusIcon = document.getElementById('tambah_stok_status');
                const previewDiv = document.getElementById('stok_preview');
                const previewText = document.getElementById('preview_text');
                const previewTotal = document.getElementById('preview_total');
                const currentTotal = {{ $allCopies->count() }};

                function updatePreview() {
                    const value = parseInt(inputField.value || 0);
                    const newTotal = currentTotal + value;
                    
                    if (value > 0) {
                        statusIcon.classList.remove('hidden');
                        previewDiv.classList.remove('hidden');
                        previewText.innerHTML = `Akan menambah <strong>${value}</strong> salinan`;
                        previewTotal.textContent = newTotal;
                    } else {
                        statusIcon.classList.add('hidden');
                        previewDiv.classList.add('hidden');
                    }
                    
                    // Log untuk debug
                    console.log('Tambah Stok Input:', {
                        rawValue: inputField.value,
                        parsedValue: value,
                        newTotal: newTotal,
                        isValid: value >= 0 && value <= 999
                    });
                }

                inputField.addEventListener('input', updatePreview);
                inputField.addEventListener('change', updatePreview);
                
                // Initialize preview
                updatePreview();

                // Monitor form submission
                const form = inputField.closest('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const finalValue = parseInt(inputField.value || 0);
                        console.log('Form submitted with tambah_stok:', finalValue);
                        
                        // Add hidden field for debugging if value is 1
                        if (finalValue === 1) {
                            console.warn('⚠️ SUBMITTING WITH VALUE 1 - Check if this reaches controller');
                        }
                    });
                }
            });
            </script>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori_id" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id', $buku->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Subjek/DDC <span class="text-red-500">*</span></label>
                <select name="subjek_id" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Pilih Subjek --</option>
                    @foreach($subjek as $s)
                        <option value="{{ $s->id }}" {{ old('subjek_id', $buku->subjek_id) == $s->id ? 'selected' : '' }}>{{ $s->kode_ddc }} - {{ $s->nama_subjek }}</option>
                    @endforeach
                </select>
                @error('subjek_id')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Lokasi Rak</label>
                <select name="lokasi_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Pilih Lokasi (Opsional) --</option>
                    @foreach($lokasi as $l)
                        <option value="{{ $l->id }}" {{ old('lokasi_id', $buku->lokasi_id) == $l->id ? 'selected' : '' }}>{{ $l->nama_lokasi }}</option>
                    @endforeach
                </select>
                @error('lokasi_id')<span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>@enderror
            </div>

            <!-- Label Preview -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-3">Preview Label:</h3>
                <div style="width: 100px; height: 100px; border: 2px solid #1e3a8a; padding: 8px; font-family: monospace; font-size: 11px; line-height: 1.4;" class="bg-white">
                    <div>{{ $buku->subjek?->kode_ddc ?? 'DDC' }}</div>
                    <div>{{ $buku->nama_depan_penulis ?? 'NAMA' }}</div>
                    <div>{{ $buku->huruf_judul_awal ?? 'J' }}</div>
                    <div>{{ $buku->nomor_salinan ?? 'c.?' }}</div>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <button type="submit" class="px-6 py-2.5 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Perbarui Buku
                </button>
                <a href="{{ route('master-buku.index') }}" class="px-6 py-2.5 bg-slate-300 text-slate-800 font-semibold rounded-lg hover:bg-slate-400 transition-colors inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Batal
                </a>
            </div>
        </div>
    </form>
</x-app-layout>
