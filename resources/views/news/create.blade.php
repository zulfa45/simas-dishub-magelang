<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengumuman / Berita Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" x-data="{ targetType: 'semua' }">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Judul Berita</label>
                                <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Konten Berita</label>
                                <textarea name="content" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <input type="text" name="category" placeholder="Cth: Pengumuman, Acara, Penting" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="published">Langsung Terbit (Published)</option>
                                    <option value="draft">Simpan sebagai Draft</option>
                                </select>
                            </div>

                            <!-- Target Penerima -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Target Penerima (Visibilitas)</label>
                                <div class="flex items-center space-x-4 mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="target_type" value="semua" x-model="targetType" class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2">Semua Orang</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="target_type" value="bagian_tertentu" x-model="targetType" class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2">Bagian / Departemen Tertentu</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="target_type" value="individu_tertentu" x-model="targetType" class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2">Individu Tertentu</span>
                                    </label>
                                </div>

                                <!-- Pilih Bagian -->
                                <div x-show="targetType === 'bagian_tertentu'" x-cloak class="mt-3 p-4 bg-gray-50 border rounded-md">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bagian (Bisa pilih lebih dari satu)</label>
                                    <select name="departments[]" multiple class="block w-full rounded-md border-gray-300 shadow-sm h-32">
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pilih Individu -->
                                <div x-show="targetType === 'individu_tertentu'" x-cloak class="mt-3 p-4 bg-gray-50 border rounded-md">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Individu (Bisa pilih lebih dari satu)</label>
                                    <select name="users[]" multiple class="block w-full rounded-md border-gray-300 shadow-sm h-32">
                                        @foreach($users as $usr)
                                            <option value="{{ $usr->id }}">{{ $usr->name }} ({{ $usr->roles->pluck('name')->implode(', ') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Gambar/Banner Utama (Opsional)</label>
                                <input type="file" name="image" class="mt-1 block w-full text-sm">
                            </div>

                        </div>

                        <div class="mt-6 flex gap-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">Simpan Berita</button>
                            <a href="{{ route('news.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 border">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>