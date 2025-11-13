<div>
    <div class="mb-3 text-xs text-gray-500">
        <span wire:loading class="ml-2 text-blue-600">(loading...)</span>
    </div>
    <div class="flex items-center gap-4 mb-4">
        <input
            type="text"
            wire:model.debounce.300ms="search"
            wire:input="$set('search', $event.target.value)"
            placeholder="Cari judul arsip..."
            class="filament-input w-1/2"
        />

        <select
            wire:model="kategori"
            wire:change="$set('kategori', $event.target.value)"
            class="filament-select"
        >
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $k)
            <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-x-auto">
        <table
            class="w-full bg-white divide-y divide-gray-200 rounded-lg shadow"
        >
            <thead>
                <tr class="text-left text-sm font-medium text-gray-700">
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Judul Arsip</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Tanggal Upload</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                @forelse($arsips as $arsip)
                <tr>
                    <td class="px-4 py-3">
                        {{ $arsips->firstItem() ? $arsips->firstItem() + $loop->index : $loop->iteration }}
                    </td>
                    <td class="px-4 py-3">{{ $arsip->judul }}</td>
                    <td class="px-4 py-3">
                        {{ $arsip->kategori?->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ optional($arsip->created_at)->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        <x-filament::button
                            size="sm"
                            color="primary"
                            tag="a"
                            href="{{ \App\Filament\Resources\ArsipResource::getUrl('edit', ['record' => $arsip->id]) }}"
                        >
                            Edit
                        </x-filament::button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-4 py-6 text-center" colspan="5">
                        Tidak ada arsip ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $arsips->links() }}
    </div>
</div>
