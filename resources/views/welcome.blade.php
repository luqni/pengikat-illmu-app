<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Demi Pena') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|inter:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans text-slate-900 bg-white dark:bg-slate-950 dark:text-white selection:bg-emerald-500 selection:text-white">
        
        <!-- Navigation -->
        <nav class="fixed w-full z-50 transition-all duration-300 backdrop-blur-md bg-white/70 dark:bg-slate-950/70 border-b border-slate-200/50 dark:border-slate-800/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <!-- Logo Icon (Pen) -->
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                            <i class="fa-solid fa-pen-nib text-lg"></i>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-slate-900 dark:text-white">Demi Pena</span>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('google.login') }}" class="group relative px-5 py-2.5 rounded-full bg-slate-900 dark:bg-emerald-500 text-white font-semibold text-sm shadow-md hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out"></div>
                                <span>Login with Google</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
                <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen animate-blob"></div>
                <div class="absolute top-20 right-10 w-72 h-72 bg-teal-400/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-indigo-400/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50/50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/50 text-emerald-700 dark:text-emerald-400 text-sm font-medium mb-8 backdrop-blur-sm animate-fade-in-up">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Tingkatkan Produktivitas Ibadah & Ilmu
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-bold tracking-tight text-slate-900 dark:text-white mb-6 leading-[1.1]">
                    Ikatlah Ilmu dengan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">Tulisan & Teknologi</span>
                </h1>
                
                <p class="mt-6 text-lg lg:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    Platform all-in-one untuk mencatat ide, ringkasan kajian, ayat Al-Qur'an & hadis. 
                    Dilengkapi dengan teknologi <strong>OCR</strong> canggih untuk mendigitalkan catatan tulis tangan Anda seketika.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('google.login') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-slate-900 dark:bg-emerald-500 text-white font-semibold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                        Mulai Sekarang Gratis
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-300">
                        Pelajari Fitur
                    </a>
                </div>

                <!-- App Preview Mockup (CSS only representation) -->
                <div class="mt-20 relative mx-auto max-w-5xl">
                    <div class="relative p-2 bg-slate-900/5 dark:bg-white/10 rounded-[2rem] lg:rounded-[2.5rem] border border-slate-200/50 dark:border-white/10 backdrop-blur-3xl shadow-2xl">
                        <div class="absolute top-0 md:-top-12 left-1/2 -translate-x-1/2 w-3/4 h-24 bg-emerald-500/30 blur-[60px] rounded-full -z-10"></div>
                        <div class="rounded-[1.5rem] lg:rounded-[2rem] overflow-hidden bg-white dark:bg-slate-900 shadow-inner border border-slate-100 dark:border-slate-800">
                             <!-- Browser/App Header -->
                             <div class="h-8 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center px-4 gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-400/80"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-400/80"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-400/80"></div>
                             </div>
                             <!-- Content Placeholder -->
                             <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 min-h-[400px]">
                                <div class="space-y-4">
                                    <div class="h-8 w-3/4 bg-slate-100 dark:bg-slate-800 rounded animate-pulse"></div>
                                    <div class="h-4 w-full bg-slate-50 dark:bg-slate-800/50 rounded animate-pulse delay-75"></div>
                                    <div class="h-4 w-5/6 bg-slate-50 dark:bg-slate-800/50 rounded animate-pulse delay-100"></div>
                                    
                                    <div class="mt-8 p-4 rounded-xl border border-emerald-100 dark:border-emerald-900/30 bg-emerald-50/50 dark:bg-emerald-900/10">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                                </svg>
                                            </div>
                                            <span class="font-medium text-emerald-900 dark:text-emerald-100">OCR Processing...</span>
                                        </div>
                                        <div class="h-2 w-full bg-emerald-200 dark:bg-emerald-900 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 w-2/3 rounded-full"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden md:block bg-slate-50 dark:bg-slate-800/30 rounded-xl p-4 border border-slate-100 dark:border-slate-800/50">
                                     <div class="flex items-start gap-4">
                                        <div class="flex-1 space-y-3">
                                            <div class="h-20 bg-slate-100 dark:bg-slate-700/50 rounded-lg"></div>
                                            <div class="h-20 bg-slate-100 dark:bg-slate-700/50 rounded-lg opacity-60"></div>
                                        </div>
                                     </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-slate-50 dark:bg-slate-900/50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Fitur Unggulan</h2>
                    <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">Dirancang khusus untuk para penuntut ilmu yang ingin menjaga ilmunya tetap abadi.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute inset-x-0 -top-px h-px bg-gradient-to-r from-transparent via-emerald-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-14 h-14 rounded-xl bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.854 1.5-2.268a6.016 6.016 0 003 0c.842.414 1.5 1.285 1.5 2.268v.192A12.07 12.07 0 0114.25 18zm-4.5 0v-.192c0-.983-.658-1.854-1.5-2.268a6.016 6.016 0 003 0c.842.414 1.5 1.285 1.5 2.268v.192c0 .983-.658 1.854-1.5 2.268-.842.414-1.5 1.285-1.5 2.268z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Catat & Ringkas</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            Simpan setiap ide brilian dan ringkasan kajian dalam format yang rapi dan mudah diakses kembali.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute inset-x-0 -top-px h-px bg-gradient-to-r from-transparent via-emerald-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-14 h-14 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Al-Qur'an & Hadis</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            Integrasi seamless untuk menyisipkan dalil Al-Qur'an dan Hadis shahih ke dalam catatan Anda.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                         <div class="absolute inset-x-0 -top-px h-px bg-gradient-to-r from-transparent via-emerald-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-14 h-14 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">OCR Tulisan Tangan</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            Punya catatan di buku tulis? Cukup foto dan biarkan AI kami mengubahnya menjadi teks digital yang bisa diedit.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                 <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                             <i class="fa-solid fa-pen-nib"></i>
                        </div>
                        <span class="font-bold text-lg text-slate-900 dark:text-white">Demi Pena</span>
                    </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    &copy; {{ date('Y') }} Demi Pena. All rights reserved.
                </p>
            </div>
        </footer>

        <!-- Custom Animation Styles -->
        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
            @keyframes fade-in-up {
                0% { opacity: 0; transform: translateY(20px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-up {
                animation: fade-in-up 0.8s ease-out forwards;
            }
        </style>
    </body>
</html>
