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
        <div class="py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div
                    class="mx-auto max-w-2xl lg:text-center"
                    data-aos="fade-up"
                >
                    <h2
                        class="text-base font-semibold leading-7 text-primary-600"
                    >
                        Manajemen Lebih Baik
                    </h2>
                    <p
                        class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"
                    >
                        Fitur Unggulan Sistem
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Nikmati berbagai fitur canggih untuk mengelola arsip
                        digital Anda
                    </p>
                </div>
                <div
                    class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none"
                >
                    <dl
                        class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3"
                    >
                        <div
                            class="flex flex-col"
                            data-aos="fade-up"
                            data-aos-delay="100"
                        >
                            <dt
                                class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900"
                            >
                                <svg
                                    class="h-5 w-5 flex-none text-primary-600"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M10 2a.75.75 0 01.75.75v5.59l1.95-2.1a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0L6.2 7.26a.75.75 0 111.1-1.02l1.95 2.1V2.75A.75.75 0 0110 2z"
                                    />
                                    <path
                                        d="M5 8.75v-2.5a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0zM16.5 6.25v2.5a.75.75 0 01-1.5 0v-2.5a.75.75 0 011.5 0zM4.25 15h11.5a.75.75 0 000-1.5H4.25a.75.75 0 000 1.5z"
                                    />
                                </svg>
                                Pengarsipan Digital
                            </dt>
                            <dd
                                class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600"
                            >
                                <p class="flex-auto">
                                    Simpan dokumen penting Anda dalam format
                                    digital yang aman dan terorganisir.
                                </p>
                            </dd>
                        </div>
                        <div
                            class="flex flex-col"
                            data-aos="fade-up"
                            data-aos-delay="200"
                        >
                            <dt
                                class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900"
                            >
                                <svg
                                    class="h-5 w-5 flex-none text-primary-600"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M8 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                    />
                                    <path
                                        fill-rule="evenodd"
                                        d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8a2.5 2.5 0 115 0 2.5 2.5 0 01-5 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Pencarian Cepat
                            </dt>
                            <dd
                                class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600"
                            >
                                <p class="flex-auto">
                                    Temukan dokumen yang Anda butuhkan dengan
                                    cepat menggunakan fitur pencarian canggih.
                                </p>
                            </dd>
                        </div>
                        <div
                            class="flex flex-col"
                            data-aos="fade-up"
                            data-aos-delay="300"
                        >
                            <dt
                                class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900"
                            >
                                <svg
                                    class="h-5 w-5 flex-none text-primary-600"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Manajemen Kategori
                            </dt>
                            <dd
                                class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600"
                            >
                                <p class="flex-auto">
                                    Atur arsip Anda dalam kategori yang
                                    terstruktur untuk pengelolaan yang lebih
                                    baik.
                                </p>
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
        <footer class="bg-white">
            <div
                class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8"
            >
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-center text-sm leading-5 text-gray-500">
                        &copy; {{ date("Y") }} Digital Arsip. All rights
                        reserved.
                    </p>
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
