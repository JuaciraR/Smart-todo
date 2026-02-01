<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>To-Do List | Task Manager</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="fixed inset-0 -z-10 bg-[#f8faff] overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-100 via-white to-orange-50 opacity-80"></div>
            <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-200/40 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-orange-200/40 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative min-h-screen flex flex-col items-center justify-center px-6">
            
            <div class="mb-10">
                <div class="relative w-32 h-32 flex items-center justify-center">
                    <div class="absolute inset-0 bg-white/70 backdrop-blur-md rounded-[2.5rem] rotate-12 shadow-xl border border-white/40"></div>
                    <div class="absolute inset-0 bg-white/90 backdrop-blur-md rounded-[2.5rem] -rotate-6 shadow-sm border border-white/20"></div>
                    
                    <svg class="relative w-16 h-16 text-indigo-600 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>

            <div class="text-center max-w-2xl">
                <h1 class="text-5xl md:text-6xl font-extrabold text-slate-800 tracking-tight leading-tight mb-4">
                    Organize everything <br>
                    <span class="text-indigo-600">instantly.</span>
                </h1>
                
                <p class="text-lg text-slate-600 font-medium leading-relaxed mb-12">
                    A clean and intuitive task manager built with Laravel 12 & Tailwind CSS. <br class="hidden md:block">
                    Focus on what matters most and boost your daily productivity.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('tasks.index') }}" 
                               class="w-full sm:w-auto px-10 py-3 bg-indigo-600 text-white font-bold rounded-full shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                                Go to My Tasks
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="w-full sm:w-auto px-12 py-3 bg-slate-800 text-white font-bold rounded-full shadow-lg hover:bg-black transition-all">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="w-full sm:w-auto px-12 py-3 bg-white text-slate-700 font-bold rounded-full shadow-md border border-slate-100 hover:bg-slate-50 transition-all">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <div class="mt-24 pt-8 border-t border-slate-200/40 w-full max-w-xl">
                <div class="flex justify-center gap-6 mb-4">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Backend</span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Frontend</span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">State</span>
                </div>
                <div class="text-center">
                    <p class="text-sm font-bold text-slate-600">
                        Laravel 12 <span class="mx-1">&bull;</span> Tailwind CSS <span class="mx-1">&bull;</span> Livewire
                    </p>
                    <p class="text-[10px] font-medium text-slate-400 mt-2 tracking-widest uppercase">
                        V{{ Illuminate\Foundation\Application::VERSION }} &bull; PHP V{{ PHP_VERSION }}
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>