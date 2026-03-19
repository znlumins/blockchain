<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Proyek Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="nama_proyek" :value="__('Nama Proyek')" />
                                <x-text-input id="nama_proyek" class="block mt-1 w-full" type="text" name="nama_proyek" :value="old('nama_proyek')" required autofocus />
                                <x-input-error :messages="$errors->get('nama_proyek')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi Singkat Proyek')" />
                                <textarea name="deskripsi" id="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="lokasi" :value="__('Lokasi')" />
                                    <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required />
                                    <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="anggaran" :value="__('Anggaran (Rp)')" />
                                    <x-text-input id="anggaran" class="block mt-1 w-full" type="number" name="anggaran" :value="old('anggaran')" required placeholder="Contoh: 150000000" />
                                    <x-input-error :messages="$errors->get('anggaran')" class="mt-2" />
                                </div>
                            </div>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="tahun" :value="__('Tahun Anggaran')" />
                                    <x-text-input id="tahun" class="block mt-1 w-full" type="number" name="tahun" :value="old('tahun', date('Y'))" required placeholder="Contoh: 2025" />
                                    <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                                </div>
                                 <div>
                                    <x-input-label for="status" :value="__('Status Awal')" />
                                    <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="usulan">Usulan</option>
                                        <option value="proses">Proses</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex items-center gap-4 border-t pt-6">
                                <x-primary-button>{{ __('Simpan Proyek') }}</x-primary-button>
                                <a href="{{ route('projects.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>