<x-filament-panels::page>
    <div class="space-y-4">
        {{-- 1. Cara Pembuatan Arsip --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>1. Tata Cara Pembuatan Arsip</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Arsip" di sidebar kiri.</li>
                    <li>Klik tombol "Buat Arsip" di pojok kanan atas.</li>
                    <li>Isi formulir yang tersedia:
                        <ul class="list-disc list-inside ml-4 mt-2">
                            <li><strong>Judul Arsip:</strong> Nama atau judul untuk arsip Anda.</li>
                            <li><strong>Deskripsi:</strong> Penjelasan singkat mengenai isi arsip.</li>
                            <li><strong>Fungsi:</strong> Pilih fungsi arsip (misal: Keuangan, Personalia).</li>
                            <li><strong>Subjek:</strong> (Opsional) Pilih subjek yang lebih spesifik.</li>
                            <li><strong>File Arsip:</strong> Unggah file yang ingin diarsipkan.</li>
                            <li><strong>Tanggal Arsip:</strong> Tanggal pembuatan atau relevansi arsip.</li>
                        </ul>
                    </li>
                    <li>Setelah semua terisi, klik tombol "Buat" untuk menyimpan.</li>
                </ol>
            </div>
        </details>

        {{-- 2. Cara Penghapusan Arsip (Soft Delete) --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>2. Tata Cara Penghapusan Arsip</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-gray-700 dark:text-gray-300 mb-2">Penghapusan ini bersifat sementara (Soft Delete). Arsip akan dipindahkan ke "Trash Arsip" dan dapat dipulihkan.</p>
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Arsip".</li>
                    <li>Cari arsip yang ingin dihapus pada tabel.</li>
                    <li>Klik ikon tiga titik (Aksi) di sebelah kanan baris arsip.</li>
                    <li>Pilih opsi "Delete".</li>
                    <li>Konfirmasi penghapusan pada dialog yang muncul.</li>
                </ol>
            </div>
        </details>

        {{-- 3. Cara Restore Arsip --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>3. Tata Cara Restore Arsip</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Trash Arsip" di sidebar kiri.</li>
                    <li>Cari arsip yang ingin dipulihkan.</li>
                    <li>Klik tombol "Restore" pada baris arsip tersebut.</li>
                    <li>Konfirmasi pemulihan, dan arsip akan kembali ke daftar "Arsip" utama.</li>
                </ol>
            </div>
        </details>

        {{-- 4. Cara Delete Permanen Arsip --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>4. Tata Cara Hapus Permanen Arsip</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-red-600 dark:text-red-400 mb-2 font-semibold">PERINGATAN: Tindakan ini tidak dapat diurungkan. File fisik juga akan terhapus dari server.</p>
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Trash Arsip".</li>
                    <li>Cari arsip yang ingin dihapus permanen.</li>
                    <li>Klik tombol "Permanent Delete" pada baris arsip tersebut.</li>
                    <li>Konfirmasi penghapusan permanen pada dialog yang muncul.</li>
                </ol>
            </div>
        </details>

        {{-- 5. Picture to Arsip --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>5. Tata Cara Picture to Arsip</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-gray-700 dark:text-gray-300 mb-2">Fitur ini memungkinkan Anda mengambil beberapa gambar dari kamera dan menyimpannya sebagai satu file PDF.</p>
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Picture to PDF" di sidebar.</li>
                    <li>Isi "Judul Arsip" dan "Deskripsi".</li>
                    <li>Klik "Ambil Gambar" untuk membuka kamera. Ambil gambar sebanyak yang diperlukan.</li>
                    <li>Gambar yang diambil akan muncul sebagai thumbnail. Anda bisa menghapus gambar jika tidak sesuai.</li>
                    <li>Setelah selesai, klik "Simpan ke Arsip". Sistem akan mengonversi gambar menjadi PDF dan menyimpannya di menu "Arsip".</li>
                </ol>
            </div>
        </details>

        {{-- 6. Cara Pembuatan Fungsi Arsip --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>6. Cara Pembuatan Fungsi Arsip (Kategori)</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Fungsi" di bawah grup "Manajemen Arsip".</li>
                    <li>Klik "Buat Fungsi".</li>
                    <li>Isi nama fungsi (misal: "Pemasaran").</li>
                    <li>Pilih warna untuk label agar mudah dikenali.</li>
                    <li>Klik "Buat" untuk menyimpan.</li>
                </ol>
            </div>
        </details>

        {{-- 7. Cara Pembuatan Subjek Arsip --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>7. Cara Pembuatan Subjek Arsip</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Subjek" di bawah grup "Manajemen Arsip".</li>
                    <li>Klik "Buat Subjek".</li>
                    <li>Isi nama subjek (misal: "Laporan Bulanan").</li>
                    <li>Pilih warna untuk label.</li>
                    <li>Klik "Buat" untuk menyimpan.</li>
                </ol>
            </div>
        </details>

        {{-- 8. Cara Pembuatan Roles --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>8. Cara Pembuatan Roles</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Roles" di bawah grup "Manajemen User".</li>
                    <li>Klik "Buat Role".</li>
                    <li>Masukkan nama role (misal: "Operator", "Viewer").</li>
                    <li>Pilih izin (permissions) yang akan diberikan untuk role tersebut.</li>
                    <li>Klik "Buat" untuk menyimpan.</li>
                </ol>
            </div>
        </details>

        {{-- 9. Cara Pembuatan User --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>9. Cara Pembuatan User Baru</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Users" di bawah grup "Manajemen User".</li>
                    <li>Klik "Buat User".</li>
                    <li>Isi detail user seperti Nama, Email, dan Password.</li>
                    <li>Pilih "Roles" untuk user tersebut.</li>
                    <li>Klik "Buat" untuk menyimpan.</li>
                </ol>
            </div>
        </details>

        {{-- 10. Cara Pengelolaan Setting --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>10. Cara Pengelolaan Setting</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Buka menu "Settings" di bawah grup "Sistem".</li>
                    <li>Di sini Anda dapat mengubah informasi umum aplikasi seperti:
                        <ul class="list-disc list-inside ml-4 mt-2">
                            <li><strong>Nama Instansi</strong></li>
                            <li><strong>Slogan</strong></li>
                            <li><strong>Logo</strong></li>
                        </ul>
                    </li>
                    <li>Ubah data yang diinginkan dan perubahan akan tersimpan secara otomatis.</li>
                </ol>
            </div>
        </details>

        {{-- 11. Cara Update Password --}}
        <details class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <summary class="p-4 cursor-pointer font-semibold text-gray-900 dark:text-white flex justify-between items-center">
                <span>11. Cara Update Password</span>
                <x-heroicon-o-chevron-down class="w-5 h-5 transition-transform transform" />
            </summary>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Klik nama Anda di pojok kanan atas layar.</li>
                    <li>Pilih menu "Profile" dari dropdown.</li>
                    <li>Scroll ke bawah ke bagian "Ubah Password".</li>
                    <li>Masukkan password Anda saat ini.</li>
                    <li>Masukkan password baru dan konfirmasinya.</li>
                    <li>Klik "Simpan" untuk mengubah password.</li>
                </ol>
            </div>
        </details>
    </div>

    <style>
        details[open] summary .transform {
            transform: rotate(180deg);
        }
    </style>
</x-filament-panels::page>
