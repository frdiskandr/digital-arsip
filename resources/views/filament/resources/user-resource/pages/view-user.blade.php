<x-filament-panels::page>
    <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="mb-4">
            <h2 class="text-2xl font-bold">{{ $record->name }}</h2>
            <p class="text-gray-600">{{ $record->email }}</p>
        </div>

        <div class="mt-6">
            <a href="{{ \App\Filament\Resources\UserResource::getUrl('index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                Kembali ke Daftar User
            </a>
        </div>

        @if (class_exists(\Spatie\Activitylog\Models\Activity::class))
            @php
                $activities = \Spatie\Activitylog\Models\Activity::where('subject_type', \App\Models\User::class)
                    ->where('subject_id', $record->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            <div class="mt-8 bg-white border rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4">Riwayat Perubahan</h3>
                @if ($activities->isEmpty())
                    <div class="text-gray-500">Belum ada riwayat untuk user ini.</div>
                @else
                    <div class="space-y-4">
                        @foreach ($activities as $activity)
                            <div class="border rounded-lg p-3">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-700">
                                        <strong>{{ $activity->description }}</strong>
                                        @if ($activity->causer)
                                            oleh <span class="font-medium">{{ $activity->causer->name }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                                </div>
                                @if (!empty($activity->properties) && is_array($activity->properties))
                                    <div class="mt-2 text-sm text-gray-600">
                                        <pre class="whitespace-pre-wrap">{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
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
