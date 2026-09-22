<aside class="w-64 bg-gray-800 text-white min-h-screen flex-shrink-0 flex flex-col">
    <div class="h-16 flex items-center justify-center border-b border-gray-700 font-bold text-lg tracking-wider">
        SIMAS DISHUB
    </div>
    
    <nav class="flex-1 px-2 py-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
            Dashboard
        </a>

        @role('admin')
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Surat
        </div>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Surat Masuk</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Arsip</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Kategori</a>
        
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Sistem
        </div>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Pengguna</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Organisasi</a>
        @endrole

        @role('staf-loket')
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Surat
        </div>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Surat Masuk</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Tambah Surat</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Arsip</a>
        
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Penugasan
        </div>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Penugasan</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Tindak Lanjut</a>
        @endrole

        @role('karyawan')
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Tugas Saya
        </div>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Belum Diproses</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Dalam Proses</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Selesai</a>
        @endrole

    </nav>
</aside>