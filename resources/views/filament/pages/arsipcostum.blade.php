{{-- Ensure Livewire assets are rendered even if the layout doesn't output stacks --}}
@livewireStyles

<x-filament-panels::page>
    <div class="px-4 py-6">
        <!-- <h1 class="text-2xl font-semibold mb-4">Arsip Custom (debug)</h1> -->

        @livewire(\App\Http\Livewire\ArsipCustomTable::class)
    </div>
</x-filament-panels::page>

@livewireScripts
