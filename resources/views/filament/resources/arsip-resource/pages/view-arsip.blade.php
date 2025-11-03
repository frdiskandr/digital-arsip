<x-filament-panels::page>
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">{{ $record->judul }}</h2>
            @php
                $fileUrl = $record->file_url;
                $filePath = $record->file_path;
            @endphp
            @if ($filePath && Illuminate\Support\Facades\Storage::disk('public')->exists($filePath))
                <a href="{{ $fileUrl }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2" />
                    Unduh File
                </a>
            @endif
        </div>
        <p class="text-gray-500 mb-4">{{ $record->deskripsi }}</p>

        @php
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $supportedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
        @endphp

        @if ($filePath && Illuminate\Support\Facades\Storage::disk('public')->exists($filePath))
            @if (in_array($extension, $supportedExtensions))
                <div class="border rounded-lg overflow-hidden mb-4">
                    <iframe src="{{ $fileUrl }}" class="w-full h-[800px]" frameborder="0"></iframe>
                </div>
            @else
                <div class="p-4 bg-gray-100 rounded-lg text-center">
                    <p class="text-lg font-semibold mb-2">Pratinjau tidak tersedia untuk tipe file ini.</p>
                    <p class="text-gray-600 mb-4">Anda dapat mengunduh file untuk melihatnya.</p>
                    <a href="{{ $fileUrl }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2" />
                        Unduh File
                    </a>
                </div>
            @endif
        @else
            <div class="p-4 bg-red-100 text-red-700 rounded-lg">
                File tidak ditemukan.
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ \App\Filament\Resources\ArsipResource::getUrl('index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                Kembali ke Daftar Arsip
            </a>
        </div>
    </div>
</x-filament-panels::page>
