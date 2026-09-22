<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sistem Log Aktivitas (Audit Log)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Filter -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border">
                        <form action="{{ route('audit-logs.index') }}" method="GET" class="flex gap-4 items-end">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe Aksi</label>
                                <select name="action_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                    <option value="">Semua Aksi</option>
                                    <option value="create" {{ request('action_type') == 'create' ? 'selected' : '' }}>Create (Tambah)</option>
                                    <option value="update" {{ request('action_type') == 'update' ? 'selected' : '' }}>Update (Ubah)</option>
                                    <option value="delete" {{ request('action_type') == 'delete' ? 'selected' : '' }}>Delete (Hapus)</option>
                                    <option value="login" {{ request('action_type') == 'login' ? 'selected' : '' }}>Login</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Modul / Model</label>
                                <input type="text" name="model_type" value="{{ request('model_type') }}" placeholder="Contoh: IncomingLetter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                            </div>
                            <div>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">Filter Data</button>
                                <a href="{{ route('audit-logs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm ml-2">Reset</a>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">Waktu Kejadian</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">Pelaku (User)</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">Aksi</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">Modul Terkait</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">Alamat IP</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">Detail Perubahan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $log->user->name ?? 'Sistem / Guest' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @php
                                                $color = match($log->action) {
                                                    'create' => 'bg-green-100 text-green-800',
                                                    'update' => 'bg-yellow-100 text-yellow-800',
                                                    'delete' => 'bg-red-100 text-red-800',
                                                    'login' => 'bg-blue-100 text-blue-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                {{ strtoupper($log->action) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500">
                                            {{ str_replace('App\\Models\\', '', $log->model_type) }} <br>
                                            <span class="text-xs text-gray-400">ID: {{ $log->model_id }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $log->ip_address }}</td>
                                        <td class="px-4 py-3 text-xs">
                                            <div class="max-w-xs overflow-auto max-h-24 bg-gray-50 p-2 rounded border">
                                                @if($log->old_values)
                                                    <div class="text-red-600 mb-1"><strong>Lama:</strong> {{ json_encode($log->old_values) }}</div>
                                                @endif
                                                @if($log->new_values)
                                                    <div class="text-green-600"><strong>Baru:</strong> {{ json_encode($log->new_values) }}</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada log aktivitas yang tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>