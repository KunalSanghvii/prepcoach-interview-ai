
{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'PrepCoach') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Fallback minimal styles (if Vite isn't running). */
            :root { color-scheme: light; }
            body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji"; }
            .fallback { max-width: 1100px; margin: 0 auto; padding: 24px; }
        </style>
    @endif
</head>

<body class="min-h-screen bg-white text-zinc-900 antialiased">
    {{-- Background --}}
    <div class="pointer-events-none fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-b from-white via-white to-zinc-50"></div>
        <div class="absolute -top-40 left-1/2 h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-gradient-to-tr from-indigo-200/50 via-fuchsia-200/40 to-amber-200/40 blur-3xl"></div>
        <div class="absolute bottom-[-240px] right-[-160px] h-[520px] w-[520px] rounded-full bg-gradient-to-tr from-emerald-200/35 via-sky-200/30 to-indigo-200/35 blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.12]" style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,0.25) 1px, transparent 0); background-size: 22px 22px;"></div>
    </div>

    {{-- Top Nav --}}
    <header class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 pt-6">
        <nav class="flex items-center justify-between">
            <a href="{{ url('/') }}" class="group inline-flex items-center gap-2">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-zinc-900 text-white shadow-sm">
                    {{-- Simple "PC" mark --}}
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 17V7h6a4 4 0 0 1 0 8H7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M17 8a4 4 0 1 0 0 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <div class="leading-tight">
                    <div class="font-semibold tracking-tight">{{ config('app.name', 'PrepCoach') }}</div>
                    <div class="text-xs text-zinc-500">Interview prep, made simple</div>
                </div>
            </a>

            {{-- KEEP AUTH ROUTES / HREF AS-IS --}}
            @if (Route::has('login'))
                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-medium shadow-sm hover:bg-zinc-50"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-white/70 hover:text-zinc-900"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>
    </header>

    {{-- Hero --}}
    <main class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
        <section class="pt-12 sm:pt-16 lg:pt-20">
            <div class="grid gap-10 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white/70 px-3 py-1 text-xs font-medium text-zinc-600 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        New: structured mock interviews + feedback
                    </div>

                    <h1 class="mt-5 text-4xl font-semibold tracking-tight sm:text-5xl lg:text-6xl">
                        Prep for interviews with
                        <span class="bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-amber-600 bg-clip-text text-transparent">
                            confidence
                        </span>
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-relaxed text-zinc-600 sm:text-lg">
                        PrepCoach helps you practice real questions, organize answers, and track progress — without the chaos.
                        Clean UI, fast flow, and a dashboard that keeps you focused.
                    </p>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:items-center">
                        {{-- KEEP HREF AS-IS --}}
                        @if (Route::has('login'))
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-2xl bg-zinc-900 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800"
                            >
                                Get started
                                <svg class="ml-2 h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M5 12h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center rounded-2xl border border-zinc-200 bg-white px-6 py-3 text-sm font-semibold text-zinc-900 shadow-sm hover:bg-zinc-50"
                                >
                                    Create account
                                </a>
                            @endif
                        @endif

                        <div class="text-sm text-zinc-500">
                            No spam. No clutter. Just prep.
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3 text-xs text-zinc-600">
                        <span class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white/70 px-3 py-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span> Practice questions
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white/70 px-3 py-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-fuchsia-600"></span> Structured answers
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white/70 px-3 py-1">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-600"></span> Track progress
                        </span>
                    </div>
                </div>

                {{-- Right: Preview Card --}}
                <div class="lg:col-span-5">
                    <div class="relative rounded-3xl border border-zinc-200 bg-white/70 p-5 shadow-sm backdrop-blur">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold">Your Prep Snapshot</div>
                            <div class="text-xs text-zinc-500">Last 7 days</div>
                        </div>

                        <div class="mt-4 grid grid-cols-3 gap-3">
                            <div class="rounded-2xl border border-zinc-200 bg-white p-4">
                                <div class="text-xs text-zinc-500">Sessions</div>
                                <div class="mt-1 text-2xl font-semibold">6</div>
                                <div class="mt-1 text-xs text-emerald-600">+2 this week</div>
                            </div>
                            <div class="rounded-2xl border border-zinc-200 bg-white p-4">
                                <div class="text-xs text-zinc-500">Questions</div>
                                <div class="mt-1 text-2xl font-semibold">42</div>
                                <div class="mt-1 text-xs text-zinc-500">behavioral + tech</div>
                            </div>
                            <div class="rounded-2xl border border-zinc-200 bg-white p-4">
                                <div class="text-xs text-zinc-500">Confidence</div>
                                <div class="mt-1 text-2xl font-semibold">78%</div>
                                <div class="mt-1 text-xs text-indigo-600">steady climb</div>
                            </div>
                        </div>

                        <div class="mt-4 rounded-2xl border border-zinc-200 bg-white p-4">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-semibold">Next up</div>
                                <div class="text-xs text-zinc-500">Recommended</div>
                            </div>

                            <div class="mt-3 space-y-2">
                                <div class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2">
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium truncate">Tell me about yourself</div>
                                        <div class="text-xs text-zinc-500">2–3 min structured story</div>
                                    </div>
                                    <span class="text-xs font-semibold text-zinc-700">Start</span>
                                </div>
                                <div class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2">
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium truncate">SQL: window functions</div>
                                        <div class="text-xs text-zinc-500">practice 5 problems</div>
                                    </div>
                                    <span class="text-xs font-semibold text-zinc-700">Start</span>
                                </div>
                                <div class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2">
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium truncate">Behavioral: conflict</div>
                                        <div class="text-xs text-zinc-500">STAR answer builder</div>
                                    </div>
                                    <span class="text-xs font-semibold text-zinc-700">Start</span>
                                </div>
                            </div>
                        </div>

                        <div class="pointer-events-none absolute -inset-px rounded-3xl bg-gradient-to-tr from-indigo-500/10 via-fuchsia-500/10 to-amber-500/10"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features --}}
        <section class="mt-14 pb-16 sm:mt-16 lg:mt-20">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-3xl border border-zinc-200 bg-white/70 p-6 shadow-sm backdrop-blur">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-zinc-900 text-white">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 7h10v10H7z" stroke="currentColor" stroke-width="2" />
                            <path d="M9 11h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M9 14h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold">Structured practice</h3>
                    <p class="mt-2 text-sm leading-relaxed text-zinc-600">
                        Keep questions, notes, and answers organized so you can iterate quickly.
                    </p>
                </div>

                <div class="rounded-3xl border border-zinc-200 bg-white/70 p-6 shadow-sm backdrop-blur">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-zinc-900 text-white">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 12a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M8 12a4 4 0 0 1 8 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 12v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold">Progress you can see</h3>
                    <p class="mt-2 text-sm leading-relaxed text-zinc-600">
                        Track sessions, confidence, and focus areas — no messy spreadsheets.
                    </p>
                </div>

                <div class="rounded-3xl border border-zinc-200 bg-white/70 p-6 shadow-sm backdrop-blur">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-zinc-900 text-white">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 17l10-10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M8 7h6a3 3 0 0 1 0 6H12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 13v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold">Fast, clean flow</h3>
                    <p class="mt-2 text-sm leading-relaxed text-zinc-600">
                        Minimal clicks. Clear CTAs. Designed to keep you in “prep mode.”
                    </p>
                </div>
            </div>

            <footer class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-zinc-200/70 pt-6 sm:flex-row">
                <div class="text-sm text-zinc-500">
                    © {{ date('Y') }} {{ config('app.name', 'PrepCoach') }}. All rights reserved.
                </div>

                {{-- KEEP AUTH ROUTES / HREF AS-IS --}}
                @if (Route::has('login'))
                    <div class="flex items-center gap-3 text-sm">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-medium text-zinc-700 hover:text-zinc-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-medium text-zinc-700 hover:text-zinc-900">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-semibold text-zinc-900 hover:text-zinc-700">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </footer>
        </section>
    </main>
</body>
</html>
```
