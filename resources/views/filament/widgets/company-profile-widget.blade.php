<x-filament::widget>
    <x-filament::card>
        @php
            $setting = \App\Models\Setting::first();
            $placeholder = 'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/company-logo-design-template-e089327a5c476ce5c70c74f7359c5898_screen.jpg?ts=1672291305';
            $logoUrl = $placeholder;
            if ($setting?->logo) {
                $logo = $setting->logo;
                // If it's an absolute URL use it. Otherwise use a relative /storage/... path
                // (avoids generating an absolute URL with a different host like 'http://localhost:8000').
                if (str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://')) {
                    $logoUrl = $logo;
                } else {
                    $logoUrl = '/storage/' . ltrim($logo, '/');
                }
            }
        @endphp
        <div class="flex items-center space-x-4">
            {{-- Company logo (from Setting or placeholder) --}}
            <img src="{{ $logoUrl }}" alt="{{ $setting?->name ?? 'Company Logo' }}" class="h-16 w-16 rounded-full object-cover">
            <div>
                <h2 class="text-xl font-bold">{{ $setting?->name ?? 'Nama Perusahaan' }}</h2>
                <p class="text-gray-600">{{ $setting?->slogan ?? 'Membangun Era digital Indonesia' }}</p>
            </div>
        </div>
        {{-- <div class="mt-4 text-gray-700">
            <p>Ini adalah tempat untuk menampilkan informasi profil perusahaan Anda. Anda bisa menambahkan detail seperti:</p>
            <ul class="list-disc list-inside ml-4 mt-2">
                <li>Alamat Perusahaan: Jl. Contoh No. 123, Kota Fiktif</li>
                <li>Nomor Telepon: (021) 123-4567</li>
                <li>Email: info@perusahaananda.com</li>
                <li>Website: www.perusahaananda.com</li>
                <li>Deskripsi lebih panjang tentang visi, misi, atau sejarah perusahaan.</li>
            </ul>
        </div> --}}
    </x-filament::card>
</x-filament::widget>
