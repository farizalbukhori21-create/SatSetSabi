<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SatSetSabi') - Top-Up Game</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
<header class="border-b border-slate-800 bg-slate-950/95">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4">
    <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight"><span class="text-blue-500">SatSet</span><span class="text-yellow-400">Sabi.</span></a>
    <nav class="flex items-center gap-4 text-sm">
      <a href="{{ route('home') }}" class="hover:text-yellow-300">Beranda</a>
      @auth
        <a href="{{ route('orders.index') }}" class="hover:text-yellow-300">Pesanan</a>
        @if(auth()->user()->role === 'admin') <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-300">Admin</a> @endif
        <span class="hidden text-slate-400 sm:inline">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="rounded-lg bg-slate-800 px-3 py-2 hover:bg-slate-700">Keluar</button></form>
      @else
        <a href="{{ route('login') }}" class="hover:text-yellow-300">Masuk</a>
        <a href="{{ route('register') }}" class="rounded-lg bg-yellow-400 px-4 py-2 font-bold text-slate-950">Daftar</a>
      @endauth
    </nav>
  </div>
</header>
<main class="mx-auto max-w-7xl px-5 py-8">
@if(session('success')) <div class="mb-5 rounded-xl border border-emerald-700 bg-emerald-950 p-3 text-emerald-200">{{ session('success') }}</div> @endif
@if($errors->any()) <div class="mb-5 rounded-xl border border-red-800 bg-red-950 p-3 text-red-200"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
@yield('content')
</main>
<footer class="mt-16 border-t border-slate-800 py-8 text-center text-sm text-slate-500">© {{ date('Y') }} SatSetSabi. Top-Up game jadi sat set.</footer>
</body></html>
