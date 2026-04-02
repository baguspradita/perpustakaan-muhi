<x-app-layout>
    <x-slot name="title">Detail Guru - Perpustakaan Muhi</x-slot>

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('guru.index') }}" class="p-2 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Detail Guru</h2>
        </div>
        <p class="text-slate-500 font-medium ml-12">Informasi lengkap data guru.</p>
    </div>

    <!-- Main Card -->
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Info Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Nama Guru -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Guru</label>
                        <p class="text-lg font-bold text-slate-800">{{ $guru->user->nama }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Email</label>
                        <p class="text-base text-slate-700">{{ $guru->user->email }}</p>
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor Telepon</label>
                        <p class="text-base text-slate-700">
                            @if($guru->user->no_telp)
                                {{ $guru->user->no_telp }}
                            @else
                                <span class="text-slate-400">Tidak diisi</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- NIP -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor NIP</label>
                        <p class="text-lg font-bold text-indigo-600">{{ $guru->nip }}</p>
                    </div>

                    <!-- Mata Pelajaran -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Mata Pelajaran</label>
                        <div>
                            <span class="inline-flex items-center px-3 py-1 bg-indigo-50 border border-indigo-100 rounded-full text-sm font-bold text-indigo-600 uppercase tracking-widest">
                                {{ $guru->mapel }}
                            </span>
                        </div>
                    </div>

                    <!-- Terdaftar Sejak -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Terdaftar Sejak</label>
                        <p class="text-base text-slate-700">{{ \Carbon\Carbon::parse($guru->created_at)->translatedFormat('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 justify-end">
            <a href="{{ route('guru.edit', $guru->id) }}" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl transition-colors shadow-md hover:shadow-lg inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
            <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors shadow-md hover:shadow-lg inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
