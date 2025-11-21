<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Digital Arsip - Sistem Manajemen Arsip Modern</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
            rel="stylesheet"
        />

        <!-- AOS -->
        <link
            href="https://unpkg.com/aos@2.3.1/dist/aos.css"
            rel="stylesheet"
        />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: "#f0f9ff",
                                100: "#e0f2fe",
                                200: "#bae6fd",
                                300: "#7dd3fc",
                                400: "#38bdf8",
                                500: "#0ea5e9",
                                600: "#0284c7",
                                700: "#0369a1",
                                800: "#075985",
                                900: "#0c4a6e",
                            },
                        },
                    },
                },
            };
        </script>
    </head>
    <body class="antialiased bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-primary-600">
                            Digital Arsip
                        </h1>
                    </div>
                    <div class="flex items-center">
                        <a
                            href="{{ route('filament.admin.auth.login') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all"
                        >
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-16">
            <div
                class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
            >
                <div
                    class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-primary-200 to-primary-400 opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                ></div>
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8 pt-16">
                <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-20">
                    <div class="text-center" data-aos="fade-up">
                        <h1
                            class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl"
                        >
                            Sistem Manajemen Arsip Digital Modern
                        </h1>
                        <p
                            class="mt-6 text-lg leading-8 text-gray-600"
                            data-aos="fade-up"
                            data-aos-delay="200"
                        >
                            Kelola dokumen dan arsip penting Anda dengan lebih
                            efisien. Sistem arsip digital yang aman,
                            terorganisir, dan mudah diakses kapan saja.
                        </p>
                        <div
                            class="mt-10 flex items-center justify-center gap-x-6"
                            data-aos="fade-up"
                            data-aos-delay="400"
                        >
                            <a
                                href="{{ route('filament.admin.auth.login') }}"
                                class="rounded-md bg-primary-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
                            >
                                Mulai Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-24 sm:py-32 bg-white">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center" data-aos="fade-up">
                    <h2 class="text-base font-semibold leading-7 text-primary-600">Manajemen Lebih Baik</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Fitur Unggulan Sistem</p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">Nikmati berbagai fitur canggih yang dirancang untuk memaksimalkan efisiensi pengelolaan arsip digital Anda.</p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                        <!-- Feature 1 -->
                        <div class="flex flex-col" data-aos="fade-up" data-aos-delay="100">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                </div>
                                Manajemen Arsip Digital
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Simpan, kelola, dan atur dokumen penting Anda dengan mudah. Mendukung berbagai format file termasuk PDF, Gambar, dan Video.</p>
                            </dd>
                        </div>

                        <!-- Feature 2 -->
                        <div class="flex flex-col" data-aos="fade-up" data-aos-delay="200">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                    </svg>
                                </div>
                                Picture to PDF
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Fitur inovatif untuk mengambil foto dokumen fisik secara langsung dan mengonversinya menjadi file PDF siap arsip.</p>
                            </dd>
                        </div>

                        <!-- Feature 3 -->
                        <div class="flex flex-col" data-aos="fade-up" data-aos-delay="300">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                Pratinjau Instan
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Lihat isi dokumen langsung di browser tanpa perlu mengunduh. Mendukung PDF, Gambar, dan Video Player terintegrasi.</p>
                            </dd>
                        </div>

                        <!-- Feature 4 -->
                        <div class="flex flex-col" data-aos="fade-up" data-aos-delay="400">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                    </svg>
                                </div>
                                Klasifikasi Cerdas
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Organisir arsip dengan sistem Kategori dan Subjek yang dilengkapi kode warna visual untuk identifikasi cepat.</p>
                            </dd>
                        </div>

                        <!-- Feature 5 -->
                        <div class="flex flex-col" data-aos="fade-up" data-aos-delay="500">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                Audit Trail & Versi
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Lacak setiap perubahan dan aktivitas user. Sistem mencatat riwayat versi dokumen untuk keamanan dan akuntabilitas.</p>
                            </dd>
                        </div>

                        <!-- Feature 6 -->
                        <div class="flex flex-col" data-aos="fade-up" data-aos-delay="600">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-primary-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                Keamanan Terjamin
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">Kontrol akses berbasis peran (Role-Based Access Control) memastikan hanya pengguna yang berwenang yang dapat mengakses data.</p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-primary-600 py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-8" data-aos="zoom-in">
                <div class="mx-auto max-w-2xl text-center">
                    <h2
                        class="text-3xl font-bold tracking-tight text-white sm:text-4xl"
                    >
                        Mulai Kelola Arsip Digital Anda
                    </h2>
                    <p
                        class="mx-auto mt-6 max-w-xl text-lg leading-8 text-primary-100"
                    >
                        Sistem manajemen arsip digital yang aman, efisien, dan
                        mudah digunakan.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a
                            href="{{ route('filament.admin.auth.login') }}"
                            class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-primary-600 shadow-sm hover:bg-primary-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                        >
                            Mulai Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900" aria-labelledby="footer-heading">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8 lg:py-16">
                <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                    <div class="space-y-8">
                        <span class="text-2xl font-bold text-white">Digital Arsip</span>
                        <p class="text-sm leading-6 text-gray-300">
                            Solusi manajemen arsip digital terpercaya untuk efisiensi dan keamanan dokumen bisnis Anda.
                        </p>
                        <div class="flex space-x-6">
                            <!-- Social placeholders -->
                            <a href="#" class="text-gray-400 hover:text-gray-300">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-300">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.48 2h.08zm-1.6 14.4c-2.87 0-5.2-2.33-5.2-5.2 0-2.87 2.33-5.2 5.2-5.2 2.87 0 5.2 2.33 5.2 5.2 0 2.87-2.33 5.2-5.2 5.2zm0-8.39c-1.76 0-3.19 1.43-3.19 3.19 0 1.76 1.43 3.19 3.19 3.19 1.76 0 3.19-1.43 3.19-3.19 0-1.76-1.43-3.19-3.19-3.19zm6.406-1.133c-.353 0-.64.287-.64.64 0 .353.287.64.64.64.353 0 .64-.287.64-.64 0-.353-.287-.64-.64-.64z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 class="text-sm font-semibold leading-6 text-white">Solusi</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Manajemen Arsip</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Digitalisasi Dokumen</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Kolaborasi Tim</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-semibold leading-6 text-white">Dukungan</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Panduan Pengguna</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Bantuan Teknis</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 class="text-sm font-semibold leading-6 text-white">Perusahaan</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Tentang Kami</a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Kontak</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 lg:mt-24 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-xs leading-5 text-gray-400">&copy; {{ date("Y") }} Digital Arsip. All rights reserved.</p>
                    <p class="text-sm font-semibold text-gray-400">PT. Tomo Teknologi Sinergi</p>
                </div>
            </div>
        </footer>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                easing: "ease-in-out",
                once: true,
            });
        </script>
    </body>
</html>
