<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Notifikasi Sukses Voting -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <!-- Detail Proyek & Tombol Voting -->
        <div class="bg-white shadow-md p-6 rounded-lg border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-3xl font-extrabold text-gray-800">{{ $project->nama_proyek }}</h2>
                <span class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full font-bold shadow-sm uppercase">{{ $project->status }}</span>
            </div>
            
            <p class="text-gray-600 mb-6 text-lg">{{ $project->deskripsi }}</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <p class="text-sm text-blue-500 font-bold uppercase">Anggaran Total</p>
                    <p class="font-bold text-2xl text-blue-800">Rp {{ number_format($project->anggaran, 0,',','.') }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-500 font-bold uppercase">Status Voting Warga</p>
                    <p class="font-bold text-xl mt-1">
                        <span class="text-green-600">{{ $setuju }} Setuju</span> 
                        <span class="text-gray-400 mx-2">|</span> 
                        <span class="text-red-600">{{ $tidak_setuju }} Tidak</span>
                    </p>
                </div>
            </div>

            <!-- Tombol Voting (Hanya muncul untuk role Warga) -->
            @if(Auth::user()->role == 'warga')
            <div class="border-t pt-6 mt-2">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Berikan Suara Anda:</h3>
                <form action="{{ route('project.vote', $project->id) }}" method="POST" class="flex flex-wrap gap-4">
                    @csrf
                    <button type="submit" name="suara" value="setuju" class="w-full md:w-auto px-8 py-3 bg-green-500 hover:bg-green-600 text-black font-bold rounded-lg shadow transition flex items-center justify-center text-lg">
                        👍 Saya Setuju
                    </button>
                    <button type="submit" name="suara" value="tidak_setuju" class="w-full md:w-auto px-8 py-3 bg-red-500 hover:bg-red-600 text-black font-bold rounded-lg shadow transition flex items-center justify-center text-lg">
                        👎 Tidak Setuju
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Simulated Blockchain Ledger (Log Audit) -->
        <div class="bg-gray-50 shadow-md p-6 rounded-lg border border-gray-200">
            <h3 class="text-xl font-bold mb-2 text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                Blockchain Explorer (Jejak Audit)
            </h3>
            <p class="text-sm text-gray-500 mb-6 pb-4 border-b">Setiap vote dan penambahan data akan dicatat ke dalam Hash Block baru secara otomatis. Data bersifat permanen dan tidak dapat dimanipulasi (Immutable).</p>
            
            <div class="space-y-4">
                @foreach($blockchainLogs as $log)
                <div class="bg-white p-5 rounded-lg border-l-4 {{ $log->model_type == 'App\Models\Vote' ? 'border-green-500' : 'border-indigo-500' }} shadow-sm font-mono text-sm">
                    <div class="flex justify-between items-center mb-3 border-b pb-2">
                        <span class="font-bold text-gray-800 text-base">Block #{{ $log->id }} <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded ml-2">{{ $log->action }}</span></span>
                        <span class="text-gray-500 text-xs">{{ $log->created_at->format('d M Y, H:i:s') }}</span>
                    </div>
                    <div class="mb-3">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-bold mb-1">Hash Saat Ini:</p>
                        <p class="break-all text-green-700 bg-green-50 p-2 rounded border border-green-100">{{ $log->hash }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-bold mb-1">Hash Sebelumnya:</p>
                        <p class="break-all text-gray-600 bg-gray-100 p-2 rounded border border-gray-200">{{ $log->previous_hash }}</p>
                    </div>
                    <div class="mt-4">
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider font-bold mb-1">Data Payload:</p>
                        <div class="bg-gray-900 text-green-400 p-3 rounded-md overflow-x-auto text-xs">
                            <pre><code>{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>
                    </div>
                    <div class="text-right mt-3 text-xs text-gray-400 font-sans">
                        Divalidasi oleh Node (User): <span class="font-bold text-gray-600">{{ $log->created_by }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
    </div>
</x-app-layout>