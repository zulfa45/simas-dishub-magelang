<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Disposisi / Penugasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 p-4 bg-blue-50 rounded-md border border-blue-100">
                        <h3 class="font-bold text-blue-800 text-lg">Informasi Surat #{{ $letter->nomor_agenda }}</h3>
                        <p class="text-sm text-blue-700 mt-1">Perihal: {{ $letter->perihal }}</p>
                        <p class="text-sm text-blue-700">Asal: {{ $letter->asal_surat }}</p>
                    </div>

                    <form action="{{ route('assignments.store', $letter->id) }}" method="POST" x-data="{ recipientType: 'individu' }">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Judul Tugas -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul Disposisi/Tugas</label>
                                <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="Contoh: Tindak Lanjut Undangan Rapat">
                            </div>

                            <!-- Instruksi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Instruksi Detail</label>
                                <textarea name="instruction" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="Jelaskan apa yang harus dikerjakan..."></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Target Penerima -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipe Penerima</label>
                                    <select name="recipient_type" x-model="recipientType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="individu">Individu Tertentu (Karyawan/Staf)</option>
                                        <option value="bagian">Bagian / Departemen</option>
                                        <option value="semua_karyawan">Semua Karyawan</option>
                                    </select>
                                </div>

                                <!-- Pilih Individu -->
                                <div x-show="recipientType === 'individu'">
                                    <label class="block text-sm font-medium text-gray-700">Pilih Individu (Bisa lebih dari 1)</label>
                                    <select name="recipients[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-32">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->roles->pluck('name')->implode(', ') }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Tahan tombol CTRL (Windows) atau CMD (Mac) untuk memilih lebih dari satu.</p>
                                </div>

                                <!-- Pilih Bagian -->
                                <div x-show="recipientType === 'bagian'" x-cloak>
                                    <label class="block text-sm font-medium text-gray-700">Pilih Bagian (Bisa lebih dari 1)</label>
                                    <select name="recipients[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-32">
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Semua anggota di bagian ini akan menerima tugas.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Batas Waktu -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Batas Waktu (Deadline)</label>
                                    <input type="datetime-local" name="deadline" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada batas waktu khusus.</p>
                                </div>

                                <!-- Prioritas -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tingkat Prioritas</label>
                                    <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="normal">Normal</option>
                                        <option value="rendah">Rendah</option>
                                        <option value="tinggi">Tinggi</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 flex gap-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium">Kirim Disposisi</button>
                            <a href="{{ route('incoming-letters.show', $letter->id) }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 border">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>