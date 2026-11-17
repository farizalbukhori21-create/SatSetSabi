@extends('layouts.app')
@section('title','Masuk')
@section('content')
<div class="mx-auto max-w-md rounded-2xl border border-slate-800 bg-slate-900 p-7"><h1 class="text-3xl font-black">Masuk</h1><p class="mb-6 mt-2 text-slate-400">Lanjutkan transaksi Top-Up kamu.</p>
<form method="POST" action="{{ route('login') }}" class="space-y-4">@csrf
<label class="block text-sm">Email<input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3"></label>
<label class="block text-sm">Password<input name="password" type="password" required class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3"></label>
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Ingat saya</label>
<button class="w-full rounded-lg bg-yellow-400 p-3 font-black text-slate-950">Masuk</button></form><p class="mt-5 text-sm text-slate-400">Belum punya akun? <a class="text-yellow-300" href="{{ route('register') }}">Daftar</a></p></div>
@endsection
