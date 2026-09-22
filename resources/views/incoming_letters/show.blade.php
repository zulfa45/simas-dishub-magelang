<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Surat Masuk') }} #{{ $incomingLetter->nomor_agenda }}
            </h2>
            <a href="{{ route('incoming-letters.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Kolom Informasi Surat -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Surat</h3>
                        <table class="min-w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="py-2 font-medium text-gray-500 w-1/3">Nomor Surat</td>
                                    <td class="py-2">: {{ $incomingLetter->nomor_surat }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-500">Kategori</td>
                                    <td class="py-2">: {{ $incomingLetter->category->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-500">Tanggal Surat</td>
                                    <td class="py-2">: {{ \Carbon\Carbon::parse($incomingLetter->tanggal_surat)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-500">Asal Surat</td>
                                    <td class="py-2">: {{ $incomingLetter->asal_surat }} ({{ $incomingLetter->instansi_pengirim }})</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-500">Perihal</td>
                                    <td class="py-2">: {{ $incomingLetter->perihal }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-500">Sifat & Prioritas</td>
                                    <td class="py-2">: 
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">{{ ucfirst($incomingLetter->sifat) }}</span>
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">{{ ucfirst($incomingLetter->prioritas) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-500">Status Saat Ini</td>
                                    <td class="py-2">: <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ ucfirst(str_replace('_', ' ', $incomingLetter->status)) }}</span></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4 border-t pt-4">
                            <h4 class="font-medium text-gray-500 mb-2">Ringkasan:</h4>
                            <p class="text-gray-700 bg-gray-50 p-4 rounded">{{ $incomingLetter->ringkasan ?: 'Tidak ada ringkasan.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Lampiran -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Lampiran Dokumen</h3>
                        @if($incomingLetter->attachments->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($incomingLetter->attachments as $attachment)
                                    <li class="py-3 flex justify-between items-center">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            <span class="text-sm font-medium">{{ $attachment->file_name }}</span>
                                        </div>
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm">Unduh</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">Tidak ada lampiran.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Samping (Riwayat & Aksi) -->
            <div class="space-y-6">
                <!-- Tombol Aksi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 space-y-3">
                        <h3 class="text-lg font-bold border-b pb-2">Aksi</h3>
                        @role('admin')
                            <a href="{{ route('assignments.create', $incomingLetter->id) }}" class="block text-center w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">Buat Disposisi / Penugasan</a>
                            <button class="w-full px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">Edit Surat</button>
                        @endrole
                        <button class="w-full px-4 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 border text-sm">Cetak Lembar Disposisi</button>
                    </div>
                </div>

                <!-- Riwayat Perjalanan Surat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Riwayat Surat</h3>
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @forelse($incomingLetter->histories as $history)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4 text-sm">
                                                    <div>
                                                        <p class="text-gray-800">{{ $history->description }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">Oleh: {{ $history->user->name ?? 'Sistem' }}</p>
                                                    </div>
                                                    <div class="text-right text-xs whitespace-nowrap text-gray-500">
                                                        <time datetime="{{ $history->created_at }}">{{ $history->created_at->format('d M, H:i') }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada riwayat.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>