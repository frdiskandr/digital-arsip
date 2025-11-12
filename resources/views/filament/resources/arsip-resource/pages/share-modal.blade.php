@props(['url'])

<div
    x-data="{
        url: @js($url),
        copied: false,
        copyToClipboard() {
            navigator.clipboard.writeText(this.url).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            });
        }
    }"
    class="space-y-4"
>
    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
        Bagikan Arsip
    </h3>

    {{-- Copyable Link --}}
    <div>
        <label for="share-url" class="text-sm font-medium text-gray-700 dark:text-gray-200">
            Tautan Publik
        </label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <input
                type="text"
                id="share-url"
                x-model="url"
                readonly
                class="block w-full flex-1 rounded-none rounded-l-md border-gray-300 bg-gray-50 text-gray-700 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-200 focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
            >
            <button
                type="button"
                @click="copyToClipboard()"
                class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
            >
                <span x-show="!copied">
                    <x-heroicon-o-clipboard class="h-5 w-5 text-gray-400" />
                </span>
                <span x-show="copied">
                    <x-heroicon-o-check class="h-5 w-5 text-green-500" />
                </span>
                <span x-text="copied ? 'Disalin!' : 'Salin'"></span>
            </button>
        </div>
    </div>

    {{-- QR Code --}}
    <div class="flex flex-col items-center justify-center space-y-2 pt-4">
        <div class="p-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            {!! QrCode::size(200)->generate($url) !!}
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Pindai QR code untuk membuka
        </p>
    </div>
</div>
