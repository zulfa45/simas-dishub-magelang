<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Surat Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('incoming-letters.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Agenda</label>
                                <input type="text" name="nomor_agenda" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="kategori_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Perihal</label>
                                <input type="text" name="perihal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Instansi Pengirim</label>
                                <input type="text" name="instansi_pengirim" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Asal Surat (Pengirim Spesifik)</label>
                                <input type="text" name="asal_surat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sifat</label>
                                <select name="sifat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="biasa">Biasa</option>
                                    <option value="penting">Penting</option>
                                    <option value="rahasia">Rahasia</option>
                                    <option value="sangat_rahasia">Sangat Rahasia</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prioritas</label>
                                <select name="prioritas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="rendah">Rendah</option>
                                    <option value="normal">Normal</option>
                                    <option value="tinggi">Tinggi</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Ringkasan / Isi Singkat</label>
                                <textarea name="ringkasan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Upload File Surat (Opsional)</label>
                                <input type="file" name="lampiran" class="mt-1 block w-full">
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Surat Masuk</button>
                            <a href="{{ route('incoming-letters.index') }}" class="ml-4 text-gray-600 hover:text-gray-900">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>