<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Keuangan: {{ $project->nama_proyek }}
            </h2>
            <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-600 text-black rounded-md hover:bg-gray-700 shadow text-sm">
                ← Kembali ke Daftar Proyek
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 border-l-4 border-green-500 rounded-md shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Ringkasan Anggaran (Seperti di PPT Halaman 5) -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="border-r border-gray-200">
                    <p class="text-sm text-gray-500 uppercase font-bold mb-1">Anggaran Total</p>
                    <p class="text-xl font-extrabold text-blue-800">Rp {{ number_format($project->anggaran, 0, ',', '.') }}</p>
                </div>
                <div class="border-r border-gray-200">
                    <p class="text-sm text-gray-500 uppercase font-bold mb-1">Total Terpakai</p>
                    <p class="text-xl font-extrabold text-red-600">Rp {{ number_format($totalTerpakai, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase font-bold mb-1">Sisa Anggaran</p>
                    <p class="text-xl font-extrabold text-green-600">Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Form Tambah Laporan -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Catat Keuangan Baru</h3>
                <form action="{{ route('projects.financials.store', $project->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="md:col-span-1">
                            <x-input-label for="jenis" value="Jenis" />
                            <select name="jenis" id="jenis" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="pengeluaran">Pengeluaran</option>
                                <option value="pemasukan">Pemasukan</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="uraian" value="Uraian Kegiatan / Barang" />
                            <x-text-input id="uraian" type="text" name="uraian" class="block mt-1 w-full" required placeholder="Contoh: Pembelian Semen" />
                        </div>
                        <div class="md:col-span-1">
                            <x-input-label for="volume" value="Volume (Opsional)" />
                            <x-text-input id="volume" type="number" step="0.01" name="volume" class="block mt-1 w-full" placeholder="10" />
                        </div>
                        <div class="md:col-span-1">
                            <x-input-label for="satuan" value="Satuan" />
                            <x-text-input id="satuan" type="text" name="satuan" class="block mt-1 w-full" placeholder="Sak / m3" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="harga_satuan" value="Harga Satuan (Rp)" />
                            <x-text-input id="harga_satuan" type="number" name="harga_satuan" class="block mt-1 w-full" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="jumlah" value="Jumlah Total (Rp)" />
                            <x-text-input id="jumlah" type="number" name="jumlah" class="block mt-1 w-full" required />
                        </div>
                        <div class="md:col-span-1 flex items-end">
                            <x-primary-button class="w-full justify-center h-10">+ Tambah</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Laporan Keuangan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Laporan Keuangan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Jenis</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Uraian</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Vol/Satuan</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Harga Sat</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Jumlah Total</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($financials as $fin)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-bold rounded {{ $fin->jenis == 'pengeluaran' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ strtoupper($fin->jenis) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $fin->uraian }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $fin->volume }} {{ $fin->satuan }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">Rp {{ number_format($fin->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-800">Rp {{ number_format($fin->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <form action="{{ route('projects.financials.destroy', [$project->id, $fin->id]) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 px-2 py-1 rounded">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada data keuangan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>