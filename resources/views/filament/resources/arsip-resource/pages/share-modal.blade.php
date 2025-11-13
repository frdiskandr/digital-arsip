@props(['url'])

<div
    x-data="{
        url: @js($url),
        copied: false,
        copyToClipboard() {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(this.url).then(() => {
                    this.copied = true;
                    setTimeout(() => this.$dispatch('close'), 1200);
                }).catch(err => {
                    console.error('Async copy failed: ', err);
                    alert('Gagal menyalin tautan.');
                });
            } else {
                const input = this.$refs.shareUrlInput;
                input.select();
                try {
                    document.execCommand('copy');
                    this.copied = true;
                    setTimeout(() => this.$dispatch('close'), 1200);
                } catch (err) {
                    console.error('Fallback copy failed: ', err);
                    alert('Gagal menyalin tautan.');
                }
                window.getSelection()?.removeAllRanges();
            }
        }
    }"
    class="space-y-6"
>
    <header class="flex items-start gap-3">
        <div
            class="p-2 rounded-lg bg-gray-50 dark:bg-gray-700/40 text-primary-600 dark:text-primary-400"
        >
            <x-heroicon-o-share class="h-6 w-6" />
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-950 dark:text-gray-100">
                Bagikan Arsip
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Bagikan tautan ini dengan rekan yang berwenang — tautan
                menggunakan route internal sehingga hanya user yang sesuai dapat
                mengakses.
            </p>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
        {{-- Link box --}}
        <div class="col-span-1">
            <label
                for="share-url"
                class="text-sm font-medium text-gray-700 dark:text-gray-200"
                >Tautan Arsip</label
            >
            <div class="mt-2 flex items-stretch gap-0">
                <input
                    id="share-url"
                    type="text"
                    x-model="url"
                    readonly
                    x-ref="shareUrlInput"
                    class="flex-1 block w-full rounded-l-lg border border-gray-200 bg-white text-gray-800 placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100"
                />

                <button
                    type="button"
                    @click="copyToClipboard()"
                    class="inline-flex items-center gap-2 rounded-r-lg border border-l-0 border-gray-200 bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary-500 dark:focus:ring-offset-0"
                    aria-live="polite"
                >
                    <template x-if="!copied">
                        <x-heroicon-o-clipboard class="h-5 w-5" />
                    </template>
                    <template x-if="copied">
                        <x-heroicon-o-check class="h-5 w-5 text-white" />
                    </template>
                    <span x-text="copied ? 'Disalin' : 'Salin'">Salin</span>
                </button>
            </div>

            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                Tautan akan mengarah ke halaman detail arsip dalam aplikasi.
                Pastikan penerima memiliki akses yang sesuai.
            </p>
        </div>

        {{-- QR area --}}
        <div class="col-span-1 flex flex-col items-center md:items-end">
            <div
                class="w-48 h-48 p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center"
            >
                {!! QrCode::size(220)->generate($url) !!}
            </div>
            <p
                class="mt-3 text-sm text-gray-600 dark:text-gray-400 text-center md:text-right"
            >
                Pindai QR untuk membuka arsip di perangkat lain.
            </p>
        </div>
    </div>

    {{-- subtle toast for copied state (accessible) --}}
    <div x-show="copied" x-transition class="fixed bottom-6 right-6 z-50">
        <div
            class="flex items-center gap-3 rounded-md bg-white dark:bg-gray-800 px-4 py-2 shadow ring-1 ring-gray-200 dark:ring-gray-700"
        >
            <x-heroicon-o-check class="h-5 w-5 text-green-500" />
            <div class="text-sm text-gray-950 dark:text-white">
                Tautan disalin ke clipboard
            </div>
        </div>
    </div>
</div>

