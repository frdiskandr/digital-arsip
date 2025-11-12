@php
/** @var \App\Models\Arsip $record */ $record = $record ?? null;

$kategoriColor = $record?->kategori?->color ?? '#F3F4F6'; $title =
e($record->judul ?? ''); $original = e($record->original_file_name ?? ''); $user
= e($record->user?->name ?? 'N/A'); $tanggal = $record->created_at?->format('d M
Y') ?? '';

@endphp

<div
    class="flex items-start gap-4 p-3 rounded-md"
    style="background-color: rgba(0, 0, 0, 0)"
>
    <div
        style="width:4px; height:48px; background-color: {{
            $kategoriColor
        }}; border-radius:4px"
    ></div>
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between gap-2">
            <div class="truncate">
                <div
                    class="text-sm font-semibold text-gray-900 dark:text-white"
                >
                    {!! $title !!}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    {!! $original !!}
                </div>
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-300">
                {{ $tanggal }}
            </div>
        </div>
        <div class="mt-2 text-xs text-gray-500 dark:text-gray-300">
            {{ $user }}
        </div>
    </div>
</div>
