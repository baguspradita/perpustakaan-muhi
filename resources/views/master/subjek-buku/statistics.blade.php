<x-app-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">📊 Statistik Subjek Buku</h2>
                <p class="text-slate-500 font-medium">Analisis distribusi buku berdasarkan subcategory/DDC</p>
            </div>
            <a href="{{ route('subjek-buku.index') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg flex items-center gap-2 w-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Total Subjek</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalSubjek }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-2xl">
                    📚
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Total Buku</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalBuku }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center text-2xl">
                    📖
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Rata-rata/Subjek</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $averageBooks }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-2xl">
                    📊
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Puncak Subjek</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $maxBuku }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center text-2xl">
                    📈
                </div>
            </div>
        </div>
    </div>

    <!-- Chart & Table -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Table (Main: 2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-800">📋 Distribusi Buku per Subjek</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Kode DDC</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase">Nama Subjek</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">📚 Buku</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-600 uppercase">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjekStats as $item)
                            @php
                                $percentage = $totalBuku > 0 ? round(($item->buku_count / $totalBuku) * 100, 1) : 0;
                                $progressWidth = $totalBuku > 0 ? ($item->buku_count / $totalBuku) * 100 : 0;
                            @endphp
                            <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-indigo-600">{{ $item->kode_ddc }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $item->nama_subjek }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-full text-sm">
                                        {{ $item->buku_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-20 h-2 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-indigo-500 to-blue-500" style="width: {{ $progressWidth }}%"></div>
                                        </div>
                                        <span class="text-xs font-medium text-slate-600">{{ $percentage }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Subjek Card (Sidebar) -->
        <div class="bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-indigo-50 to-blue-50">
                <h3 class="text-lg font-bold text-slate-800">🏆 Top 5 Subjek</h3>
                <p class="text-xs text-slate-600 mt-1">Berdasarkan jumlah buku</p>
            </div>
            <div class="p-6 space-y-4">
                @foreach($subjekStats->take(5) as $rank => $item)
                    <div class="flex items-start gap-3 pb-3 border-b border-slate-100 last:border-0 last:pb-0">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ $rank + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900">{{ $item->kode_ddc }}</p>
                            <p class="text-xs text-slate-600 truncate">{{ $item->nama_subjek }}</p>
                            <div class="mt-2 flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500" style="width: {{ ($item->buku_count / $maxBuku) * 100 }}%"></div>
                                </div>
                                <span class="font-bold text-emerald-600 text-sm">{{ $item->buku_count }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Empty State -->
    @if($totalSubjek === 0)
        <div class="mt-8 p-8 bg-blue-50 border border-blue-200 rounded-lg text-center">
            <p class="text-blue-900 font-medium">📭 Belum ada subjek buku</p>
            <a href="{{ route('subjek-buku.create') }}" class="text-sm text-blue-600 hover:text-blue-800 mt-2 inline-block">
                Tambah subjek pertama →
            </a>
        </div>
    @endif
</x-app-layout>
