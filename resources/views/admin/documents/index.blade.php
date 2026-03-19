<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-gray-800 leading-tight">
                📁 Dokumentasi & Foto: {{ $project->nama_proyek }}
            </h2>
            <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-800 text-black rounded-md hover:bg-gray-900 shadow text-xs font-bold transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 border-l-4 border-green-500 rounded-md shadow-sm font-bold animate-bounce">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- 1. FORM UPLOAD (Sesuai PPT Halaman 6) -->
            <div class="bg-white p-8 shadow-sm rounded-2xl border border-gray-200">
                <h3 class="text-lg font-black text-gray-800 mb-6 flex items-center uppercase tracking-tight">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload Dokumentasi Baru ke Blockchain
                </h3>
                <form action="{{ route('projects.documents.store', $project->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <x-input-label for="tipe_data" value="Kategori" />
                            <select name="tipe_data" id="tipe_data" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="FOTO">📸 FOTO PROGRESS</option>
                                <option value="DOKUMEN">📄 LAPORAN PDF/DOCX</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="deskripsi" value="Judul / Deskripsi Singkat" />
                            <x-text-input id="deskripsi" type="text" name="deskripsi" class="block mt-1 w-full" required placeholder="Contoh: Foto Pemasangan Pondasi" />
                        </div>
                        <div>
                            <x-input-label for="file" value="Pilih File Fisik" />
                            <input id="file" type="file" name="file" class="block mt-1 w-full text-sm text-gray-500 border border-gray-300 rounded-xl p-2 bg-gray-50 cursor-pointer" required />
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-black font-black py-3 px-8 rounded-xl shadow-indigo-200 shadow-lg transition transform active:scale-95">
                            UPLOAD SEKARANG
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. GALERI DOKUMENTASI (Sesuai PPT Halaman 10) -->
            <div class="bg-white p-8 shadow-sm rounded-2xl border border-gray-200">
                <div class="flex items-center justify-between mb-8 border-b pb-4">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">🖼️ Galeri Proyek & Jejak Digital</h3>
                    <span class="text-xs font-bold text-gray-400 bg-gray-100 px-3 py-1 rounded-full uppercase tracking-widest">Total: {{ $documents->count() }} Data</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    @forelse ($documents as $doc)
                        <div class="group border-2 border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:border-indigo-400 transition bg-white relative">
                            <!-- Badge Tipe -->
                            <div class="absolute top-2 right-2 z-10">
                                <span class="px-2 py-1 text-[9px] font-black rounded-md shadow-sm uppercase border
                                    {{ $doc->tipe_data == 'FOTO' ? 'bg-yellow-400 text-yellow-900 border-yellow-500' : 'bg-blue-600 text-black border-blue-700' }}">
                                    {{ $doc->tipe_data }}
                                </span>
                            </div>

                            @if($doc->tipe_data == 'FOTO')
                                <img src="{{ asset('storage/' . $doc->file_path) }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500" alt="Progress">
                            @else
                                <div class="w-full h-48 bg-indigo-50 flex flex-col items-center justify-center text-indigo-400 group-hover:bg-indigo-100 transition">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="text-[10px] font-black mt-3 tracking-widest uppercase">OFFICIAL DOCUMENT</span>
                                </div>
                            @endif

                            <div class="p-5">
                                <p class="text-sm font-black text-gray-800 truncate mb-1">{{ $doc->deskripsi }}</p>
                                <p class="text-[10px] text-gray-400 font-mono mb-4 italic">{{ $doc->created_at->format('d/m/Y H:i') }}</p>
                                
                                <div class="flex justify-between items-center border-t pt-4">
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-indigo-600 text-xs font-black hover:underline flex items-center">
                                        LIHAT FILE ↗
                                    </a>
                                    <form action="{{ route('projects.documents.destroy', [$project->id, $doc->id]) }}" method="POST" onsubmit="return confirm('Hapus dari Blockchain?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-4 py-20 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-gray-400 font-black italic uppercase tracking-tighter">Belum ada bukti fisik proyek yang diunggah.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>