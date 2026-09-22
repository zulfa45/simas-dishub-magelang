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
        <a href="{{ route('incoming-letters.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('incoming-letters.*') ? 'bg-gray-700' : '' }}">Surat Masuk</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Arsip</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Kategori</a>
        
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Sistem
        </div>
        <a href="{{ route('news.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('news.*') ? 'bg-gray-700' : '' }}">Kelola Berita</a>
        <a href="{{ route('audit-logs.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('audit-logs.*') ? 'bg-gray-700' : '' }}">Audit Log</a>
        <a href="{{ route('users.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('users.*') ? 'bg-gray-700' : '' }}">Pengguna</a>
        <a href="{{ route('organizations.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('organizations.*') ? 'bg-gray-700' : '' }}">Organisasi</a>
        @endrole

        @role('staf-loket')
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Surat
        </div>
        <a href="{{ route('incoming-letters.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('incoming-letters.index') ? 'bg-gray-700' : '' }}">Surat Masuk</a>
        <a href="{{ route('incoming-letters.create') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('incoming-letters.create') ? 'bg-gray-700' : '' }}">Tambah Surat</a>
        <a href="#" class="block px-4 py-2 rounded transition hover:bg-gray-700">Arsip</a>
        
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Sistem
        </div>
        <a href="{{ route('news.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('news.*') ? 'bg-gray-700' : '' }}">Papan Informasi</a>
        @endrole

        @role('karyawan')
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Tugas Saya
        </div>
        <a href="{{ route('my-tasks.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('my-tasks.*') ? 'bg-gray-700' : '' }}">Daftar Tugas</a>
        <a href="{{ route('incoming-letters.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('incoming-letters.*') ? 'bg-gray-700' : '' }}">Surat Masuk</a>
        
        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Sistem
        </div>
        <a href="{{ route('news.index') }}" class="block px-4 py-2 rounded transition hover:bg-gray-700 {{ request()->routeIs('news.*') ? 'bg-gray-700' : '' }}">Papan Informasi</a>
        @endrole

    </nav>
</aside>