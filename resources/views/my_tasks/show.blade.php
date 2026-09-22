<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Tugas') }} #{{ $assignment->id }}
            </h2>
            <a href="{{ route('my-tasks.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Informasi Tugas & Surat -->
            <div class="space-y-6">
                <!-- Detail Tugas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 border-l-4 border-indigo-500">
                        <h3 class="text-xl font-bold text-indigo-700">{{ $assignment->title }}</h3>
                        <p class="mt-2 text-gray-700">{{ $assignment->instruction }}</p>
                        
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="block text-gray-500">Batas Waktu:</span>
                                <span class="font-medium {{ $assignment->deadline && \Carbon\Carbon::parse($assignment->deadline)->isPast() ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ $assignment->deadline ? \Carbon\Carbon::parse($assignment->deadline)->format('d M Y H:i') : 'Tidak ada' }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-gray-500">Prioritas:</span>
                                <span class="font-medium">{{ ucfirst($assignment->priority) }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500">Status Tugas:</span>
                                <span class="font-medium text-blue-600">{{ ucfirst(str_replace('_', ' ', $assignment->status)) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Surat Terkait -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Informasi Surat Terkait</h3>
                        <div class="text-sm space-y-2">
                            <p><span class="font-medium text-gray-500 w-32 inline-block">Nomor Surat</span>: {{ $assignment->letter->nomor_surat }}</p>
                            <p><span class="font-medium text-gray-500 w-32 inline-block">Asal Surat</span>: {{ $assignment->letter->asal_surat }}</p>
                            <p><span class="font-medium text-gray-500 w-32 inline-block">Perihal</span>: {{ $assignment->letter->perihal }}</p>
                            <div class="mt-3 pt-3 border-t">
                                <a href="{{ route('incoming-letters.show', $assignment->letter->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Buka Detail Surat Lengkap &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanggapan & Progress -->
            <div class="space-y-6">
                <!-- Form Tanggapan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Beri Tanggapan / Progress</h3>
                        
                        <form action="{{ route('my-tasks.respond', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggapan/Catatan Pekerjaan</label>
                                <textarea name="isi_tanggapan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="Tuliskan progress yang telah dilakukan..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ubah Status Tugas</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="dalam_proses" {{ $assignment->status == 'dalam_proses' ? 'selected' : '' }}>Masih Dalam Proses</option>
                                    <option value="selesai" {{ $assignment->status == 'selesai' ? 'selected' : '' }}>Sudah Selesai</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lampiran Bukti Kerja (Opsional)</label>
                                <input type="file" name="lampiran_file" class="mt-1 block w-full text-sm">
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">Kirim Tanggapan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- History Tanggapan -->
                @if($assignment->responses->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Riwayat Tanggapan</h3>
                        <div class="space-y-4">
                            @foreach($assignment->responses as $resp)
                                <div class="p-3 bg-gray-50 rounded border">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-medium text-sm">{{ $resp->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $resp->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-800">{{ $resp->isi_tanggapan }}</p>
                                    <div class="mt-2 flex justify-between items-center text-xs">
                                        <span class="px-2 py-0.5 bg-gray-200 rounded text-gray-700">Status: {{ str_replace('_', ' ', $resp->status) }}</span>
                                        @if($resp->lampiran)
                                            <a href="#" class="text-blue-600 hover:underline flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                Lihat Bukti
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>