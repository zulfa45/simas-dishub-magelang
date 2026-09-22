<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengguna: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-xs text-yellow-600 bg-yellow-50 p-2 rounded">Kosongkan kolom password di bawah ini jika tidak ingin mengubah password.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div class="md:col-span-2 border-t pt-4 mt-2">
                                <h4 class="font-medium text-gray-900 mb-4">Informasi Kepegawaian & Akses</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Peran (Role Akses)</label>
                                <select name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    @php $userRole = $user->roles->first()->name ?? ''; @endphp
                                    <option value="">Pilih Role...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $userRole == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <!-- Kosong untuk spacing -->
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bagian / Departemen</label>
                                <select name="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">-- Tidak Ada / Kosongkan --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ $user->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                                <select name="position_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">-- Tidak Ada / Kosongkan --</option>
                                    @foreach($positions as $pos)
                                        <option value="{{ $pos->id }}" {{ $user->position_id == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="mt-8 flex gap-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">Perbarui Data</button>
                            <a href="{{ route('users.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 border">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>