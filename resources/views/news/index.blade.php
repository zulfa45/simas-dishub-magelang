<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berita & Informasi Internal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Pengumuman</h3>
                        @role('admin')
                            <a href="{{ route('news.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">+ Buat Pengumuman Baru</a>
                        @endrole
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($news as $item)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition bg-white flex flex-col">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="Image" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                    </div>
                                @endif
                                <div class="p-4 flex-1 flex flex-col">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded">{{ $item->category ?: 'Umum' }}</span>
                                        <span class="text-xs text-gray-500">{{ $item->created_at->format('d M Y') }}</span>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-2 leading-tight">
                                        <a href="{{ route('news.show', $item->id) }}" class="hover:text-blue-600">{{ $item->title }}</a>
                                    </h4>
                                    <p class="text-sm text-gray-600 flex-1">{{ Str::limit($item->content, 100) }}</p>
                                    
                                    @role('admin')
                                        <div class="mt-4 pt-3 border-t flex justify-between items-center text-xs">
                                            <span class="{{ $item->status == 'published' ? 'text-green-600' : 'text-gray-500' }} font-medium">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                            <div class="space-x-2">
                                                <a href="{{ route('news.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                                <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus berita ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endrole
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12 text-gray-500">
                                <p>Belum ada pengumuman atau berita.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>