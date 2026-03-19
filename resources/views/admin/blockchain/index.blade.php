<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-indigo-700 leading-tight flex items-center">
            <span class="mr-2">🔗</span> SIPPD BLOCKCHAIN EXPLORER
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-indigo-900 p-6 rounded-xl shadow-2xl border-b-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-black text-2xl font-black italic tracking-tighter">GLOBAL TRANSACTION LEDGER</h3>
                        <p class="text-indigo-300 text-sm font-mono uppercase">Node Status: <span class="text-green-400">● Active / Synchronized</span></p>
                    </div>
                    <div class="text-right">
                        <p class="text-indigo-400 text-xs font-bold uppercase">Network Protocol</p>
                        <p class="text-black font-mono font-bold">SHA-256 / SIPPD-V1</p>
                    </div>
                </div>
            </div>

            <!-- List of Blocks (Seperti di PPT Hal 15) -->
            <div class="space-y-4">
                @forelse ($logs as $log)
                <div class="bg-white border-2 border-gray-100 rounded-xl overflow-hidden shadow-sm hover:border-indigo-400 transition transform hover:-translate-y-1">
                    <div class="bg-gray-50 px-6 py-3 border-b flex justify-between items-center">
                        <span class="font-black text-indigo-600 font-mono">BLOCK #{{ sprintf('%05d', $log->id) }}</span>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest italic">{{ $log->created_at->format('d M Y | H:i:s') }}</span>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-1 border-r pr-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Aktivitas Sistem</p>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full font-black text-xs uppercase">{{ $log->action }}</span>
                            <p class="text-xs text-gray-500 mt-4 font-bold">Diverifikasi Oleh:</p>
                            <p class="text-sm font-black text-indigo-500">{{ strtoupper($log->created_by) }}</p>
                        </div>
                        
                        <div class="md:col-span-3 space-y-4">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Hash Digital (Block Signature)</p>
                                <p class="font-mono text-xs text-green-600 bg-green-50 p-2 rounded border border-green-200 break-all">{{ $log->hash }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Hash Sebelumnya (Parent Link)</p>
                                <p class="font-mono text-xs text-gray-400 bg-gray-50 p-2 rounded border break-all">{{ $log->previous_hash }}</p>
                            </div>
                            
                            <!-- Dropdown Data Payload -->
                            <details class="group">
                                <summary class="text-xs font-bold text-indigo-600 cursor-pointer hover:underline list-none flex items-center">
                                    <svg class="w-3 h-3 mr-1 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    LIHAT DATA TRANSAKSI (RAW DATA)
                                </summary>
                                <div class="mt-3 bg-gray-900 text-green-400 p-4 rounded-lg text-[11px] font-mono shadow-inner border-2 border-gray-800">
                                    <pre><code>{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</code></pre>
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white p-12 text-center rounded-xl shadow-sm border">
                    <p class="text-gray-400 font-bold italic">Belum ada blok transaksi yang tervalidasi di dalam jaringan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $logs->links() }}
            </div>

        </div>
    </div>
</x-app-layout>