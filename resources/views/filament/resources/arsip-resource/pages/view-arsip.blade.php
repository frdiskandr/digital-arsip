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
                    {{-- Stats Badges --}}
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                        <x-heroicon-m-arrow-down-tray class="w-3 h-3" />
                        {{ $record->download_count }} Unduhan
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                        <x-heroicon-m-share class="w-3 h-3" />
                        {{ $record->share_count }} Dibagikan
                    </span>

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
            @php
            $fileUrl = route('arsip.view', ['record' => $record]); $filePath = $record->file_path;
            echo '<script>console.log("Debug filePath:", ' . json_encode($record) . ');</script>';
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
        @if ($extension == 'pdf')
        <div
            class="border rounded-lg overflow-hidden mb-4 bg-white dark:bg-gray-900"
        >
            <iframe
                src="{{ $fileUrl }}"
                class="w-full h-[800px]"
                frameborder="0"
            ></iframe>
        </div>
        @elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
        <div
            class="flex justify-center items-center border rounded-lg overflow-hidden mb-4 bg-white dark:bg-gray-900 p-4"
        >
            <img
                src="{{ $fileUrl }}"
                alt="{{ $record->judul }}"
                class="max-h-[80vh] w-auto object-contain rounded-lg shadow-md"
            />
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
            // Use paginated versions passed from the Page class when available.
            // Fallback to a safe paginated query (5 per page) if not provided.
            $versions = $versions ?? $record->versions()->orderBy('version', 'desc')->paginate(5);
        @endphp
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Riwayat Versi</h3>

            @if ($versions->count() == 0)
                <div class="flex flex-col items-center justify-center p-8 text-center bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 text-primary-500 bg-primary-50 rounded-full dark:bg-gray-700">
                        <x-heroicon-o-document-duplicate class="w-6 h-6" />
                    </div>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">Belum ada riwayat versi</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Setiap pembaruan pada arsip ini akan dicatat di sini.</p>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/40">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Versi</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Judul & File</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Diubah oleh</th>
                                    <th scope="col" class="px-4 py-3 text-left hidden md:table-cell text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Tanggal Versi</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($versions as $version)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                        <td class="px-4 py-3 align-top whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-300">v{{ $version->version }}</span>
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            <div class="flex flex-col gap-1">
                                                <span class="font-medium truncate">{{ Str::limit($version->judul, 80) }}</span>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $version->original_file_name }}</div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $version->user?->name ?? 'N/A' }}
                                        </td>

                                        <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-600 dark:text-gray-300">{{ $version->created_at->format('d M Y, H:i') }}</td>

                                        <td class="px-4 py-3 text-right whitespace-nowrap">
                                            <a href="{{ route('arsip.version.download', ['version' => $version]) }}" target="_blank" class="inline-flex items-center justify-center h-9 w-9 text-primary-600 hover:bg-gray-100 rounded-lg dark:hover:bg-gray-900">
                                                <x-heroicon-o-arrow-down-tray class="w-5 h-5"/>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Menampilkan <span class="font-medium text-gray-900 dark:text-white">{{ $versions->count() }}</span> dari <span class="font-medium text-gray-900 dark:text-white">{{ $versions->total() }}</span> versi</div>
                    <div>
                        {{ $versions->links() }}
                    </div>
                </div>
            @endif
        </div>


        @if (class_exists(\Spatie\Activitylog\Models\Activity::class))
            @php
                // Use paginated activities passed from the Page class when available.
                // Fallback to a safe paginated query (5 per page) if not provided.
                $activities = $activities ?? (
                    class_exists(\Spatie\Activitylog\Models\Activity::class)
                    ? \Spatie\Activitylog\Models\Activity::where('subject_type', \App\Models\Arsip::class)
                        ->where('subject_id', $record->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(5)
                    : null
                );
            @endphp

            <div class="mt-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Riwayat Perubahan</h3>

                @if ($activities && $activities->total() == 0)
                    <div class="text-gray-500 dark:text-gray-300">Belum ada riwayat untuk arsip ini.</div>
                @elseif ($activities)
                    <div class="mt-2 grid gap-4">
                        @foreach ($activities as $activity)
                            <article class="relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-lg p-4 sm:p-4 shadow-sm hover:shadow-md">
                                <div class="flex items-start gap-3">
                                    <div class="shrink-0">
                                        <div class="h-10 w-10 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                            <x-heroicon-o-clock class="w-5 h-5" />
                                        </div>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-4">
                                            <div class="text-sm leading-6">
                                                <h4 class="font-semibold text-gray-900 dark:text-white truncate">{{ Str::limit($activity->description, 120) }}</h4>
                                                @if ($activity->causer)
                                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">oleh <span class="font-medium text-gray-700 dark:text-gray-200">{{ $activity->causer->name }}</span></p>
                                                @endif
                                            </div>

                                            <div class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</div>
                                        </div>

                                        @if (!empty($activity->properties) && is_array($activity->properties))
                                            <div class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                                                @php $props = $activity->properties; @endphp
                                                @if (isset($props['attributes']) || isset($props['old']))
                                                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                        @foreach ($props['attributes'] ?? [] as $key => $value)
                                                            <div class="flex items-start gap-2">
                                                                <dt class="font-medium text-gray-700 dark:text-gray-200 text-xs w-32">{{ $key }}</dt>
                                                                <dd class="text-gray-600 dark:text-gray-300 text-xs">@if(isset($props['old'][$key]))<del class="text-red-500 mr-2">{{ $props["old"][$key] }}</del>@endif <span>{{ $value }}</span></dd>
                                                            </div>
                                                        @endforeach
                                                    </dl>
                                                @else
                                                    <pre class="whitespace-pre-wrap text-gray-600 dark:text-gray-300 text-xs">{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-4 flex items-center justify-center">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-filament-panels::page>
