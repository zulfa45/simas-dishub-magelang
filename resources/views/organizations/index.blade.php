<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Organisasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Departemen / Bagian -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold border-b pb-2 mb-4">Master Bagian / Departemen</h3>
                    
                    <!-- Form Tambah -->
                    <form action="{{ route('organizations.department.store') }}" method="POST" class="mb-6 flex gap-2">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Bagian Baru..." class="flex-1 rounded-md border-gray-300 shadow-sm text-sm" required>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">Tambah</button>
                    </form>

                    <!-- List -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Bagian</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Jml Pegawai</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($departments as $dept)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $dept->name }}</td>
                                    <td class="px-4 py-3 text-center text-gray-500">{{ $dept->users_count }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('organizations.department.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('Hapus bagian ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-gray-500">Belum ada data bagian.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Jabatan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold border-b pb-2 mb-4">Master Jabatan</h3>
                    
                    <!-- Form Tambah -->
                    <form action="{{ route('organizations.position.store') }}" method="POST" class="mb-6 flex gap-2">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Jabatan Baru..." class="flex-1 rounded-md border-gray-300 shadow-sm text-sm" required>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">Tambah</button>
                    </form>

                    <!-- List -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Jabatan</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Jml Pegawai</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($positions as $pos)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $pos->name }}</td>
                                    <td class="px-4 py-3 text-center text-gray-500">{{ $pos->users_count }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('organizations.position.destroy', $pos->id) }}" method="POST" onsubmit="return confirm('Hapus jabatan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-gray-500">Belum ada data jabatan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>