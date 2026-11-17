@extends('layouts.app')
@section('title','Daftar')
@section('content')
<div class="mx-auto max-w-md rounded-2xl border border-slate-800 bg-slate-900 p-7"><h1 class="text-3xl font-black">Buat akun</h1><p class="mb-6 mt-2 text-slate-400">Daftar untuk mulai Top-Up.</p>
<form method="POST" action="{{ route('register') }}" class="space-y-4">@csrf
<label class="block text-sm">Nama<input name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3"></label>
<label class="block text-sm">Email<input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3"></label>
<label class="block text-sm">Password<input name="password" type="password" required class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3"></label>
<label class="block text-sm">Konfirmasi password<input name="password_confirmation" type="password" required class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-950 p-3"></label>
<button class="w-full rounded-lg bg-yellow-400 p-3 font-black text-slate-950">Daftar</button></form></div>
@endsection
