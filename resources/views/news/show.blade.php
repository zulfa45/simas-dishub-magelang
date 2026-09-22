<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Baca Berita') }}
            </h2>
            <a href="{{ route('news.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($news->image)
                    <img src="{{ Storage::url($news->image) }}" alt="Banner" class="w-full h-64 md:h-96 object-cover">
                @endif
                <div class="p-8 text-gray-900">
                    <div class="mb-6 pb-6 border-b">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded-full">{{ $news->category ?: 'Umum' }}</span>
                        <h1 class="text-3xl font-extrabold text-gray-900 mt-4 leading-tight">{{ $news->title }}</h1>
                        <div class="flex items-center text-sm text-gray-500 mt-4 space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $news->creator->name ?? 'Admin' }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('d F Y, H:i') : $news->created_at->format('d F Y, H:i') }}
                            </span>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-wrap">
                        {{ $news->content }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>