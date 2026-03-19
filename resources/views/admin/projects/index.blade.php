<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Daftar Proyek
            </h2>
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-indigo-600 text-black rounded-md hover:bg-indigo-700 shadow font-bold text-sm transition">
                + Tambah Proyek Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    
                    <!-- Notifikasi Sukses -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 text-green-800 border-l-4 border-green-500 rounded-md font-medium shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Anggaran (Rp)</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Kelola Data (Admin)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($projects as $project)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">{{ $project->nama_proyek }}</div>
                                        <div class="text-xs text-gray-400 font-normal mt-0.5 uppercase tracking-tighter">Tahun Anggaran: {{ $project->tahun }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $project->lokasi }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-blue-700 text-center">
                                        {{ number_format($project->anggaran, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-extrabold rounded-full shadow-sm
                                        @if($project->status == 'usulan') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @elseif($project->status == 'proses') bg-blue-100 text-blue-800 border border-blue-200
                                        @else bg-green-100 text-green-800 border border-green-200 @endif">
                                            {{ strtoupper($project->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        
                                        <!-- TOMBOL AKSI LENGKAP -->
                                        <div class="flex justify-center gap-2">
                                            
                                            <!-- Tombol Laporan Keuangan (PPT Hal 5) -->
                                            <a href="{{ route('projects.financials.index', $project->id) }}" class="flex items-center text-green-700 hover:text-green-900 bg-green-100 hover:bg-green-200 px-3 py-1.5 rounded-md font-bold text-xs transition border border-green-200 shadow-sm" title="Kelola Laporan Keuangan">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Keuangan
                                            </a>
                                            
                                            <!-- Tombol Dokumen/Foto (PPT Hal 6 & 10) -->
                                            <a href="{{ route('projects.documents.index', $project->id) }}" class="flex items-center text-blue-700 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-3 py-1.5 rounded-md font-bold text-xs transition border border-blue-200 shadow-sm" title="Kelola Dokumentasi & Foto">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Dokumen
                                            </a>

                                            <!-- Tombol Detail Publik -->
                                            <a href="{{ route('project.detail', $project->id) }}" class="flex items-center text-indigo-700 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 px-3 py-1.5 rounded-md font-bold text-xs transition border border-indigo-200 shadow-sm" title="Lihat Halaman Publik/Warga">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Detail
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Peringatan: Menghapus proyek ini juga akan menghapus semua Laporan Keuangan, Voting, dan Dokumen terkait secara permanen! Lanjutkan?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-2.5 py-1.5 rounded-md font-bold transition border border-red-200 shadow-sm" title="Hapus Proyek">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 font-medium bg-gray-50">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        Belum ada data proyek pembangunan.<br>
                                        <a href="{{ route('projects.create') }}" class="text-indigo-600 hover:underline mt-2 inline-block font-bold">Mulai Tambah Proyek Baru →</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $projects->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>