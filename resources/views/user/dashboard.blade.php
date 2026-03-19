<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-bold text-blue-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-blue-700">Anda dapat memberikan suara untuk proyek pembangunan di bawah ini. Voting tercatat dalam blockchain untuk transparansi.</p>
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-4">Daftar Proyek Pembangunan (Tersedia untuk Di-vote)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($proyekTersedia as $p)
                <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-800">{{ $p->nama_proyek }}</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-bold">USULAN</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">{{ $p->deskripsi }}</p>
                    
                    <div class="text-sm text-gray-500 mb-4 grid grid-cols-2 gap-2">
                        <div><strong>Lokasi:</strong> {{ $p->lokasi }}</div>
                        <div><strong>Anggaran:</strong> Rp {{ number_format($p->anggaran,0,',','.') }}</div>
                        <div><strong>Tahun:</strong> {{ $p->tahun }}</div>
                    </div>

                    <form action="{{ route('project.vote', $p->id) }}" method="POST" class="flex gap-4 border-t pt-4">
                        @csrf
                        <button type="submit" name="suara" value="setuju" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded flex justify-center items-center">
                            👍 Setuju
                        </button>
                        <button type="submit" name="suara" value="tidak_setuju" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded flex justify-center items-center">
                            👎 Tidak Setuju
                        </button>
                    </form>
                    <div class="mt-4 text-center">
                        <a href="{{ route('project.detail', $p->id) }}" class="text-blue-500 text-sm hover:underline">Lihat Detail & Laporan Blockchain</a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>