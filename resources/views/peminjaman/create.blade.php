<x-app-layout>
    <x-slot name="title">Tambah Peminjaman - Perpustakaan Muhi</x-slot>

    <!-- Header Halaman -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('peminjaman.index') }}" class="p-2 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Catat Peminjaman</h2>
        </div>
        <p class="text-slate-500 font-medium ml-12">Silakan isi formulir di bawah untuk mencatat peminjaman baru.</p>
    </div>

    <!-- Main Card -->
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-3xl border border-slate-100 shadow-md overflow-hidden p-8">

                @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Kiri: Data Siswa & Tanggal -->
                    <div class="space-y-6">
                        @if(auth()->user()->role === 'siswa')
                        <!-- Jika yang login siswa, otomatis pilih dirinya sendiri -->
                        <div>
                            <label class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Peminjam</label>
                            <div class="w-full px-4 py-3 bg-indigo-50 border border-indigo-100 rounded-2xl text-indigo-800 font-bold flex items-center gap-3">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ auth()->user()->nama }} (Siswa)
                            </div>
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @error('user_id') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        @else
                        <!-- Jika petugas, bisa memilih siswa atau guru -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Dropdown Siswa -->
                            <div>
                                <label for="user_id_siswa" class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Pilih Siswa</label>
                                <select name="user_id_siswa" id="user_id_siswa" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800">
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->jurusan_name }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Guru -->
                            <div>
                                <label for="user_id_guru" class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Pilih Guru</label>
                                <select name="user_id_guru" id="user_id_guru" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800">
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach($guru as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }} ({{ $g->guru_mapel }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Hidden input untuk menahan user_id yang dipilih -->
                        <input type="hidden" name="user_id" id="user_id" value="">

                        @error('user_id') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror

                        <script>
                            const selectSiswa = document.getElementById('user_id_siswa');
                            const selectGuru = document.getElementById('user_id_guru');
                            const inputUserId = document.getElementById('user_id');

                            if (selectSiswa && inputUserId) {
                                selectSiswa.addEventListener('change', function() {
                                    inputUserId.value = this.value;
                                    if (selectGuru) selectGuru.value = '';
                                });
                            }

                            if (selectGuru && inputUserId) {
                                selectGuru.addEventListener('change', function() {
                                    inputUserId.value = this.value;
                                    if (selectSiswa) selectSiswa.value = '';
                                });
                            }
                        </script>
                        @endif

                        <div>
                            <label for="tgl_pinjam" class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Tanggal Pinjam</label>
                            <input type="date" name="tgl_pinjam" id="tgl_pinjam" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800" required>
                            @error('tgl_pinjam') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="tgl_jatuh_tempo" class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-2">Tanggal Jatuh Tempo</label>
                            <input type="date" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" value="{{ date('Y-m-d', strtotime('+1 days')) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition-all font-medium text-slate-800" required>
                            @error('tgl_jatuh_tempo') <p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Kanan: Pilih Buku -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-black text-slate-700 uppercase tracking-wider mb-3">Tambahkan Buku ke Peminjaman</label>
                            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-4 max-h-80 overflow-y-auto space-y-3">
                                @forelse($bukuByTitle as $b)
                                <div class="bg-white rounded-2xl border-2 border-slate-100 p-4 transition-all hover:border-indigo-300 hover:shadow-md group">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3 flex-1">
                                            <input type="checkbox" name="buku_id[]" value="{{ $b->id }}" class="w-5 h-5 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 mt-1 checkbox-buku transition-all" data-buku-id="{{ $b->id }}" data-max="{{ $b->total_exemplar }}">
                                            <div class="flex-1">
                                                <p class="text-sm font-bold text-slate-900 line-clamp-2">{{ $b->judul }} <span class="ml-1 text-[10px] text-slate-400 font-mono font-normal">({{ $b->nomor_salinan }})</span></p>
                                                <p class="text-xs text-slate-500 font-semibold uppercase tracking-widest mt-1">
                                                    {{ $b->kategori->nama_kategori ?? 'Kategori' }}
                                                </p>
                                                <div class="mt-2 inline-flex items-center gap-1 px-2 py-1 bg-emerald-50 rounded-lg">
                                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-xs font-bold text-emerald-700">{{ $b->total_exemplar }} Tersedia</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Input Jumlah (Hidden initially) -->
                                    <div class="mt-4 ml-8 hidden jumlah-section" data-buku-id="{{ $b->id }}">
                                        <div class="flex items-center gap-2">
                                            <label class="text-xs font-bold text-slate-600 w-24">Jumlah:</label>
                                            <input type="number" name="buku_jumlah[{{ $b->id }}]" value="1" min="1" max="{{ $b->total_exemplar }}" class="w-20 px-3 py-2 text-center border-2 border-indigo-200 rounded-lg font-bold text-indigo-600 focus:outline-none focus:border-indigo-500 transition-colors input-jumlah" data-buku-id="{{ $b->id }}" data-max="{{ $b->total_exemplar }}">
                                            <span class="text-xs text-slate-500 font-semibold ml-2">Maks. {{ $b->total_exemplar }}</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="text-slate-500 text-sm font-medium">Tidak ada buku tersedia saat ini</p>
                                </div>
                                @endforelse
                            </div>
                            @error('buku_id') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Ringkasan Peminjaman (Ditambahkan) -->
                        <div id="summary-section" class="hidden mt-6 bg-indigo-50 border border-indigo-100 rounded-3xl p-5">
                            <h3 class="text-xs font-black text-indigo-700 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Ringkasan Peminjaman (<span id="total-buku">0</span> Buku)
                            </h3>
                            <div id="summary-list" class="space-y-2">
                                <!-- List buku yang dipilih akan muncul di sini via JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end gap-3">
                    <a href="{{ route('peminjaman.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-100 transition-all hover:-translate-y-0.5 active:scale-95" id="btn-submit">
                        ✓ Simpan Peminjaman
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Data buku dari server
        const bukuData = @json($bukuByTitle->mapWithKeys(fn($b) => [$b->id => ['judul' => $b->judul, 'max' => $b->total_exemplar, 'nomor_salinan' => $b->nomor_salinan]]));

        function updateSummary() {
            try {
                const selectedBooks = [];
                let totalBuku = 0;

                document.querySelectorAll('.checkbox-buku:checked').forEach(checkbox => {
                    const bukuId = checkbox.value;
                    const inputJumlah = document.querySelector(`input.input-jumlah[data-buku-id="${bukuId}"]`);
                    const jumlah = inputJumlah ? (parseInt(inputJumlah.value) || 1) : 1;
                    const bData = bukuData[bukuId] || {};
                    const judul = bData.judul || 'Buku';
                    const nomorSalinan = bData.nomor_salinan || '-';

                    selectedBooks.push({ judul, jumlah, bukuId, nomorSalinan });
                    totalBuku += jumlah;
                });

                const summarySection = document.getElementById('summary-section');
                const summaryList = document.getElementById('summary-list');
                const totalBukuEl = document.getElementById('total-buku');

                if (selectedBooks.length > 0) {
                    if (summarySection) summarySection.classList.remove('hidden');
                    if (summaryList) {
                        summaryList.innerHTML = selectedBooks.map(b => `
                            <div class="flex items-center justify-between py-2 px-3 bg-white rounded-lg border border-indigo-200">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-800 line-clamp-1">${b.judul}</span>
                                    <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-tighter">Salinan: ${b.nomorSalinan}</span>
                                </div>
                                <span class="text-sm font-bold text-indigo-600 bg-indigo-100 px-3 py-1 rounded">× ${b.jumlah}</span>
                            </div>
                        `).join('');
                    }
                    if (totalBukuEl) totalBukuEl.textContent = totalBuku;
                } else {
                    if (summarySection) summarySection.classList.add('hidden');
                }
            } catch (err) {
                console.error("Summary error:", err);
            }
        }

        // Handle checkbox change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('checkbox-buku')) {
                const bukuId = e.target.dataset.bukuId;
                const jumlahSection = document.querySelector(`.jumlah-section[data-buku-id="${bukuId}"]`);
                const inputJumlah = document.querySelector(`input[data-buku-id="${bukuId}"]`);

                if (e.target.checked) {
                    if (jumlahSection) jumlahSection.classList.remove('hidden');
                    if (inputJumlah) inputJumlah.disabled = false;
                } else {
                    if (jumlahSection) jumlahSection.classList.add('hidden');
                }
                updateSummary();
            }
            
            if (e.target.classList.contains('input-jumlah')) {
                const max = parseInt(e.target.dataset.max) || 100;
                let value = parseInt(e.target.value) || 1;
                if (value > max) e.target.value = max;
                if (value < 1) e.target.value = 1;
                updateSummary();
            }
        });

        // Initialize on load
        window.addEventListener('load', updateSummary);
    </script>
</x-app-layout>