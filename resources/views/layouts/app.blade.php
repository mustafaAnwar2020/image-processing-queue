<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--color-slate-50:oklch(.984 .003 247.858);--color-slate-100:oklch(.968 .007 247.896);--color-slate-200:oklch(.929 .013 255.508);--color-slate-300:oklch(.869 .022 252.894);--color-slate-400:oklch(.704 .04 256.788);--color-slate-500:oklch(.554 .046 257.417);--color-slate-600:oklch(.446 .043 257.281);--color-slate-700:oklch(.372 .044 257.287);--color-slate-800:oklch(.279 .041 260.031);--color-slate-900:oklch(.208 .042 265.755);--color-slate-950:oklch(.129 .042 264.695);--color-gray-50:oklch(.985 .002 247.839);--color-gray-100:oklch(.967 .003 264.542);--color-gray-200:oklch(.928 .006 264.531);--color-gray-300:oklch(.872 .01 258.338);--color-gray-400:oklch(.707 .022 261.325);--color-gray-500:oklch(.551 .027 264.364);--color-gray-600:oklch(.446 .03 256.802);--color-gray-700:oklch(.373 .034 259.733);--color-gray-800:oklch(.278 .033 256.848);--color-gray-900:oklch(.21 .034 264.665);--color-gray-950:oklch(.13 .028 261.692);--color-zinc-50:oklch(.985 0 0);--color-zinc-100:oklch(.967 .001 286.375);--color-zinc-200:oklch(.92 .004 286.32);--color-zinc-300:oklch(.871 .006 286.286);--color-zinc-400:oklch(.705 .015 286.067);--color-zinc-500:oklch(.552 .016 285.938);--color-zinc-600:oklch(.442 .017 285.786);--color-zinc-700:oklch(.37 .013 285.805);--color-zinc-800:oklch(.274 .006 286.033);--color-zinc-900:oklch(.21 .006 285.885);--color-zinc-950:oklch(.141 .005 285.823);--color-neutral-50:oklch(.985 0 0);--color-neutral-100:oklch(.97 0 0);--color-neutral-200:oklch(.922 0 0);--color-neutral-300:oklch(.87 0 0);--color-neutral-400:oklch(.708 0 0);--color-neutral-500:oklch(.556 0 0);--color-neutral-600:oklch(.439 0 0);--color-neutral-700:oklch(.371 0 0);--color-neutral-800:oklch(.269 0 0);--color-neutral-900:oklch(.205 0 0);--color-neutral-950:oklch(.145 0 0);--color-stone-50:oklch(.985 .001 106.423);--color-stone-100:oklch(.97 .001 106.424);--color-stone-200:oklch(.923 .003 48.717);--color-stone-300:oklch(.869 .005 56.366);--color-stone-400:oklch(.709 .01 56.259);--color-stone-500:oklch(.553 .013 58.071);--color-stone-600:oklch(.444 .011 73.639);--color-stone-700:oklch(.374 .01 67.558);--color-stone-800:oklch(.268 .007 34.298);--color-stone-900:oklch(.216 .006 56.043);--color-stone-950:oklch(.147 .004 49.25);--color-red-50:oklch(.971 .013 17.38);--color-red-100:oklch(.936 .032 17.717);--color-red-200:oklch(.885 .062 18.334);--color-red-300:oklch(.808 .114 19.571);--color-red-400:oklch(.704 .191 22.216);--color-red-500:oklch(.637 .237 25.331);--color-red-600:oklch(.577 .245 27.325);--color-red-700:oklch(.505 .213 27.518);--color-red-800:oklch(.444 .177 26.899);--color-red-900:oklch(.396 .141 25.723);--color-red-950:oklch(.258 .092 26.042);--color-green-50:oklch(.982 .018 155.826);--color-green-100:oklch(.962 .044 156.743);--color-green-200:oklch(.925 .084 155.995);--color-green-300:oklch(.871 .15 154.449);--color-green-400:oklch(.792 .209 151.711);--color-green-500:oklch(.723 .219 149.579);--color-green-600:oklch(.627 .194 149.214);--color-green-700:oklch(.527 .154 150.069);--color-green-800:oklch(.448 .119 151.328);--color-green-900:oklch(.393 .095 152.535);--color-green-950:oklch(.266 .065 152.934);--color-black:#000;--color-white:#fff;--spacing:.25rem;--breakpoint-sm:40rem;--breakpoint-md:48rem;--breakpoint-lg:64rem;--breakpoint-xl:80rem;--breakpoint-2xl:96rem;--text-sm:.875rem;--text-sm--line-height:calc(1.25/.875);--text-base:1rem;--text-base--line-height:1.5;--text-lg:1.125rem;--text-lg--line-height:calc(1.75/1.125);--text-xl:1.25rem;--text-xl--line-height:calc(1.75/1.25);--text-2xl:1.5rem;--text-2xl--line-height:calc(2/1.5);--text-3xl:1.875rem;--text-3xl--line-height:1.2;--font-weight-medium:500;--font-weight-semibold:600;--font-weight-bold:700;--radius-sm:.25rem;--radius-lg:.5rem;--shadow-2xs:0 1px #0000000d;--shadow-xs:0 1px 2px 0 #0000000d;--shadow-sm:0 1px 3px 0 #0000001a,0 1px 2px -1px #0000001a;--shadow-md:0 4px 6px -1px #0000001a,0 2px 4px -2px #0000001a;--shadow-lg:0 10px 15px -3px #0000001a,0 4px 6px -4px #0000001a;--default-transition-duration:.15s;--default-transition-timing-function:cubic-bezier(.4,0,.2,1);--default-font-family:var(--font-sans)}@layer base{*,:after,:before{box-sizing:border-box;border:0 solid;margin:0;padding:0}html{line-height:1.5;font-family:var(--default-font-family,ui-sans-serif,system-ui,sans-serif)}body{line-height:inherit}button,input,select,textarea{font:inherit;color:inherit}::placeholder{opacity:1;color:color-mix(in oklab,currentColor 50%,transparent)}}@layer utilities{.flex{display:flex}.grid{display:grid}.hidden{display:none}.inline-block{display:inline-block}.inline-flex{display:inline-flex}.min-h-screen{min-height:100vh}.w-full{width:100%}.max-w-7xl{max-width:80rem}.flex-col{flex-direction:column}.items-center{align-items:center}.justify-between{justify-content:space-between}.space-x-4>:not(:last-child){--tw-space-x-reverse:0;margin-inline-start:calc(1rem*var(--tw-space-x-reverse));margin-inline-end:calc(1rem*calc(1 - var(--tw-space-x-reverse)))}.gap-4{gap:1rem}.rounded{border-radius:.25rem}.rounded-sm{border-radius:var(--radius-sm)}.border{border-style:solid;border-width:1px}.border-b{border-bottom-style:solid;border-bottom-width:1px}.bg-white{background-color:var(--color-white)}.bg-green-100{background-color:oklch(.982 .018 155.826)}.bg-red-100{background-color:oklch(.971 .013 17.38)}.px-2{padding-inline:.5rem}.px-4{padding-inline:1rem}.px-6{padding-inline:1.5rem}.py-2{padding-block:.5rem}.py-3{padding-block:.75rem}.py-8{padding-block:2rem}.mb-2{margin-bottom:.5rem}.mb-4{margin-bottom:1rem}.text-sm{font-size:var(--text-sm);line-height:var(--text-sm--line-height)}.text-xl{font-size:var(--text-xl);line-height:var(--text-xl--line-height)}.text-2xl{font-size:var(--text-2xl);line-height:var(--text-2xl--line-height)}.text-3xl{font-size:var(--text-3xl);line-height:var(--text-3xl--line-height)}.font-medium{font-weight:var(--font-weight-medium)}.font-semibold{font-weight:var(--font-weight-semibold)}.font-bold{font-weight:var(--font-weight-bold)}.text-green-700{color:oklch(.527 .154 150.069)}.text-red-700{color:oklch(.505 .213 27.518)}.hover\:bg-gray-600:hover{background-color:oklch(.446 .03 256.802)}.transition-colors{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke;transition-timing-function:var(--default-transition-timing-function);transition-duration:var(--default-transition-duration)}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{background-color:oklch(.278 .033 256.848)}.dark\:bg-green-900{background-color:oklch(.266 .065 152.934)}.dark\:bg-red-900{background-color:oklch(.258 .092 26.042)}.dark\:border-green-700{border-color:oklch(.527 .154 150.069)}.dark\:border-red-700{border-color:oklch(.505 .213 27.518)}.dark\:text-green-200{color:oklch(.962 .044 156.743)}.dark\:text-red-200{color:oklch(.936 .032 17.717)}}</style>
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen">
    <nav class="bg-white dark:bg-[#161615] border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#706f6c] dark:hover:text-[#A1A09A]">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#706f6c] dark:hover:text-[#A1A09A]">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#706f6c] dark:hover:text-[#A1A09A]">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] rounded-sm hover:bg-[#706f6c] dark:hover:bg-[#A1A09A]">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>

