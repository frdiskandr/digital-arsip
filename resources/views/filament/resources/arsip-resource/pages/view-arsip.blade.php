<x-filament-panels::page>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="flex justify-between items-start mb-4 gap-4">
            <div class="flex-1 min-w-0">
                <h2
                    class="text-2xl font-bold text-gray-900 dark:text-white truncate"
                >
                    {{ $record->judul }}
                </h2>
                <div class="mt-10 md:mt-2 flex items-center gap-2 ">
                    @php // helper to compute readable text color
                    $computeTextColor = function ($hex) { $hex = ltrim($hex ??
                    '', '#'); if (strlen($hex) === 3) { $hex =
                    $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; } if
                    (strlen($hex) !== 6) { return ['bg' => '#6b7280', 'text' =>
                    '#ffffff']; } $r = hexdec(substr($hex, 0, 2)); $g =
                    hexdec(substr($hex, 2, 2)); $b = hexdec(substr($hex, 4, 2));
                    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
                    $text = $luminance > 0.65 ? '#111827' : '#ffffff'; return
                    ['bg' => "#{$hex}", 'text' => $text]; }; $kategoriColor =
                    $record->kategori?->color ?? '#F97316'; $kategoriColors =
                    $computeTextColor($kategoriColor); $subjekColor =
                    $record->subjek?->color ?? null; $subjekColors =
                    $subjekColor ? $computeTextColor($subjekColor) : null;
                    @endphp @if ($record->kategori)
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                        style="<?php echo 'background-color: ' . $kategoriColors['bg'] . '; color: ' . $kategoriColors['text'] . ';' ?>"
                    >{{ $record->kategori->nama }}</span>
                    @endif @if ($record->subjek)
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                        style="<?php echo 'background-color: ' . $subjekColors['bg'] . '; color: ' . $subjekColors['text'] . ';' ?>"
                    >{{ $record->subjek->nama }}</span>
                    @endif
                </div>
            </div>
            @php $fileUrl = route('arsip.view', ['record' => $record]); $filePath = $record->file_path;
            @endphp
        </div>
        <p class="text-gray-500 dark:text-gray-300 mb-4">
            {{ $record->deskripsi }}
        </p>

        @php $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $supportedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'mp4'];
        $officeExtensions = ['xlsx', 'xls', 'txt']; $fileSize =
        Illuminate\Support\Facades\Storage::disk('local')->size($filePath);
        @endphp @if ($filePath &&
        Illuminate\Support\Facades\Storage::disk('local')->exists($filePath))
        @if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']))
        <div
            class="border rounded-lg overflow-hidden mb-4 bg-white dark:bg-gray-900"
        >
            <iframe
                src="{{ $fileUrl }}"
                class="w-full h-[800px]"
                frameborder="0"
            ></iframe>
        </div>
        @elseif ($extension == 'mp4')
        <div
            class="border rounded-lg overflow-hidden mb-4 bg-white dark:bg-gray-900"
        >
            <video
                controls
                class="w-full max-h-[80vh]"
                src="{{ $fileUrl }}"
            ></video>
        </div>
        @elseif (in_array($extension, $officeExtensions))
        <div
            class="border rounded-lg overflow-hidden mb-4 p-4 bg-white dark:bg-gray-900"
        >
            @if ($extension == 'txt')
            <pre
                >{{ Illuminate\Support\Facades\Storage::disk('local')->get($filePath) }}</pre
            >
            @else @if ($fileSize > 5 * 1024 * 1024) {{-- 5MB --}}
            <div
                class="p-4 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 rounded-lg text-center"
            >
                <p class="text-lg font-semibold mb-2">
                    File terlalu besar untuk ditampilkan.
                </p>
                <p class="text-gray-600 mb-4">
                    Untuk performa terbaik, silakan unduh file untuk melihatnya.
                </p>
                <a
                    href="{{ $fileUrl }}"
                    target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                    <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2" />
                    Unduh File
                </a>
            </div>
            @else
            <div id="excel-preview"></div>
            <script>
                fetch("{{ $fileUrl }}")
                    .then((response) => response.arrayBuffer())
                    .then((data) => {
                        const workbook = XLSX.read(data, { type: "array" });
                        const sheetName = workbook.SheetNames[0];
                        const worksheet = workbook.Sheets[sheetName];
                        const html = XLSX.utils.sheet_to_html(worksheet);
                        document.getElementById("excel-preview").innerHTML =
                            html;
                    });
            </script>
            @endif @endif
        </div>
        @else
        <div class="p-4 bg-gray-100 dark:bg-gray-900 rounded-lg text-center">
            <p class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">
                Pratinjau tidak tersedia untuk tipe file ini.
            </p>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                Anda dapat mengunduh file untuk melihatnya.
            </p>
            <a
                href="{{ $fileUrl }}"
                target="_blank"
                class="inline-flex items-center px-4 py-2 bg-primary-600 dark:bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-700 dark:hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
            >
                <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2" />
                Unduh File
            </a>
        </div>
        @endif @else
        <div class="p-4 bg-red-100 text-red-700 rounded-lg">
            File tidak ditemukan.
        </div>
        @endif

        {{-- Version History Table --}}
        @php
            $versions = $record->versions;
        @endphp
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">
                Riwayat Versi
            </h3>

            @if ($versions->isEmpty())
                <div class="flex flex-col items-center justify-center p-8 text-center bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 text-primary-500 bg-primary-50 rounded-full dark:bg-gray-700">
                        <x-heroicon-o-document-duplicate class="w-6 h-6" />
                    </div>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">Belum ada riwayat versi</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Setiap pembaruan pada arsip ini akan dicatat di sini.</p>
                </div>
            @else
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Versi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Diubah oleh</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Versi</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($versions as $version)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl text-primary-700 bg-primary-500/10 dark:text-primary-500">
                                            v{{ $version->version }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-950 dark:text-white">{{ Str::limit($version->judul, 50) }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $version->original_file_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $version->user?->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $version->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('arsip.version.download', ['version' => $version]) }}" target="_blank" class="inline-flex items-center justify-center h-9 w-9 text-primary-600 hover:bg-gray-500/5 rounded-full dark:text-primary-400">
                                            <x-heroicon-o-arrow-down-tray class="w-5 h-5"/>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>


        @if (class_exists(\Spatie\Activitylog\Models\Activity::class)) @php
        $activities = \Spatie\Activitylog\Models\Activity::where('subject_type',
        \App\Models\Arsip::class) ->where('subject_id', $record->id)
        ->orderBy('created_at', 'desc') ->get(); @endphp

        <div
            class="mt-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4"
        >
            <h3
                class="text-lg font-semibold mb-4 text-gray-900 dark:text-white"
            >
                Riwayat Perubahan
            </h3>
            @if ($activities->isEmpty())
            <div class="text-gray-500 dark:text-gray-300">
                Belum ada riwayat untuk arsip ini.
            </div>
            @else
            <div class="space-y-4">
                @foreach ($activities as $activity)
                <div
                    class="border rounded-lg p-3 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700"
                >
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700 dark:text-gray-200">
                            <strong>{{ $activity->description }}</strong>
                            @if ($activity->causer) oleh
                            <span
                                class="font-medium"
                                >{{ $activity->causer->name }}</span
                            >
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>


                    @if (!empty($activity->properties) &&
                    is_array($activity->properties))
                    <div class="mt-2 text-sm text-gray-600">
                        @php
                        $props = $activity->properties;
                        @endphp

                        @if (isset($props['attributes']) || isset($props['old']))
                        <table class="w-full text-sm">
                            <tbody>
                                @foreach ($props['attributes'] ?? [] as $key =>
                                $value)
                                <tr>
                                    <td class="font-medium text-gray-700 dark:text-gray-300 w-1/3">
                                        {{ $key }}
                                    </td>
                                    <td class="text-gray-600 dark:text-gray-400">
                                        @if(isset($props['old'][$key]))<del
                                            class="text-red-500 mr-2"
                                            >{{ $props["old"][$key] }}</del
                                        >@endif <span>{{ $value }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <pre
                            class="whitespace-pre-wrap text-gray-600 dark:text-gray-300"
                            >{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre
                        >
                        @endif
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endif
    </div>
</x-filament-panels::page>
