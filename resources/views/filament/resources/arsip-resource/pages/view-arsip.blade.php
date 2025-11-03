<x-filament-panels::page>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
            $supportedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'mp4'];
            $officeExtensions = ['xlsx', 'xls', 'txt'];
            $fileSize = Illuminate\Support\Facades\Storage::disk('public')->size($filePath);
        @endphp

        @if ($filePath && Illuminate\Support\Facades\Storage::disk('public')->exists($filePath))
            @if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']))
                <div class="border rounded-lg overflow-hidden mb-4">
                    <iframe src="{{ $fileUrl }}" class="w-full h-[800px]" frameborder="0"></iframe>
                </div>
            @elseif ($extension == 'mp4')
                <div class="border rounded-lg overflow-hidden mb-4">
                    <video controls class="w-full max-h-[80vh]" src="{{ $fileUrl }}"></video>
                </div>
            @elseif (in_array($extension, $officeExtensions))
                <div class="border rounded-lg overflow-hidden mb-4 p-4">
                    @if ($extension == 'txt')
                        <pre>{{ Illuminate\Support\Facades\Storage::disk('public')->get($filePath) }}</pre>
                    @else
                        @if ($fileSize > 5 * 1024 * 1024) {{-- 5MB --}}
                            <div class="p-4 bg-yellow-100 text-yellow-700 rounded-lg text-center">
                                <p class="text-lg font-semibold mb-2">File terlalu besar untuk ditampilkan.</p>
                                <p class="text-gray-600 mb-4">Untuk performa terbaik, silakan unduh file untuk melihatnya.</p>
                                <a href="{{ $fileUrl }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2" />
                                    Unduh File
                                </a>
                            </div>
                        @else
                            <div id="excel-preview"></div>
                            <script>
                                fetch('{{ $fileUrl }}')
                                    .then(response => response.arrayBuffer())
                                    .then(data => {
                                        const workbook = XLSX.read(data, { type: 'array' });
                                        const sheetName = workbook.SheetNames[0];
                                        const worksheet = workbook.Sheets[sheetName];
                                        const html = XLSX.utils.sheet_to_html(worksheet);
                                        document.getElementById('excel-preview').innerHTML = html;
                                    });
                            </script>
                        @endif
                    @endif
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
