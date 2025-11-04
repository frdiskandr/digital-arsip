<div class="px-4 py-3 w-full overflow-hidden">
    <div class="grid grid-cols-12 gap-4 items-center">
        {{-- Kolom Utama: Judul dan Nomor Arsip --}}
        <div class="col-span-12 md:col-span-6 min-w-0">
            <a href="{{ \App\Filament\Resources\ArsipResource::getUrl('view', ['record' => $getRecord()]) }}" class="block text-lg font-semibold text-primary-600 hover:underline truncate">
                {{ $getRecord()->judul }}
            </a>
            @if (!empty($getRecord()->original_file_name))
                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                    File: {{ $getRecord()->original_file_name }}
                </p>
            @endif
        </div>

        {{-- Kolom Jenis Dokumen & Kategori --}}
        <div class="col-span-6 md:col-span-2 flex items-center space-x-2 min-w-0">
            @php
                $original = $getRecord()->original_file_name;
                $path = $getRecord()->file_path;
                $ext = null;
                if (!empty($original)) {
                    $ext = pathinfo($original, PATHINFO_EXTENSION);
                } elseif (!empty($path)) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                }
                $ext = strtoupper($ext ?? 'FILE');
            @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200 truncate">
                {{ $ext }}
            </span>
            @if ($getRecord()->kategori)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200 truncate">
                    {{ $getRecord()->kategori->nama }}
                </span>
            @endif
        </div>

        {{-- Kolom Pengguna dan Tanggal --}}
        <div class="col-span-6 md:col-span-4 flex items-center min-w-0">
            <div class="flex-shrink-0">
                @php
                    $user = $getRecord()->user;
                    $avatar = null;
                    if ($user) {
                        if (method_exists($user, 'getFilamentAvatarUrl')) {
                            $avatar = $user->getFilamentAvatarUrl();
                        } elseif (!empty($user->avatar_url)) {
                            $avatar = $user->avatar_url;
                        } elseif (!empty($user->email)) {
                            $hash = md5(strtolower(trim($user->email)));
                            $avatar = "https://www.gravatar.com/avatar/{$hash}?s=80&d=identicon";
                        }
                    }
                    if (!$avatar) {
                        $avatar = 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($user->name ?? 'User');
                    }
                @endphp
                <img class="h-8 w-8 rounded-full object-cover" src="{{ $avatar }}" alt="{{ $user?->name ?? 'User' }}">
            </div>
            <div class="ml-3 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                    {{ $user?->name ?? 'Tidak diketahui' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                    {{ optional($getRecord()->created_at)->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
