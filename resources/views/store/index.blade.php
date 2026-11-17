@extends('layouts.app')
@section('title','Top-Up Game')
@section('content')
<section class="overflow-hidden rounded-3xl bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900 p-8 md:p-14">
  <p class="mb-3 inline-flex rounded-full bg-yellow-400 px-3 py-1 text-xs font-black uppercase tracking-widest text-slate-950">Top-Up tanpa ribet</p>
  <h1 class="max-w-2xl text-4xl font-black leading-tight md:text-6xl">Main terus.<br><span class="text-yellow-300">Top-Up sat set.</span></h1>
  <p class="mt-5 max-w-xl text-blue-100">Pilih game favoritmu, tentukan nominal, dan lanjutkan transaksi dengan praktis.</p>
  <a href="#games" class="mt-7 inline-block rounded-xl bg-yellow-400 px-6 py-3 font-extrabold text-slate-950">Cari Top-Up</a>
</section>
<section id="games" class="mt-12">
  <div class="mb-6 flex items-end justify-between"><div><p class="text-sm font-bold uppercase tracking-widest text-yellow-400">Katalog</p><h2 class="text-3xl font-black">Pilih game favorit</h2></div><span class="text-sm text-slate-400">{{ $products->count() }} game</span></div>
  <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($products as $product)
      <a href="{{ route('games.show',$product) }}" class="group rounded-2xl border border-slate-800 bg-slate-900 p-5 transition hover:-translate-y-1 hover:border-blue-500">
        <div class="mb-4 flex h-36 items-center justify-center rounded-xl bg-gradient-to-br from-blue-900 to-slate-800"><span class="text-4xl font-black text-yellow-300">{{ strtoupper(substr($product->name,0,2)) }}</span></div>
        <p class="text-xs font-bold uppercase tracking-wider text-blue-400">{{ $product->category->name }}</p>
        <h3 class="mt-1 text-xl font-extrabold group-hover:text-yellow-300">{{ $product->name }}</h3>
        <p class="mt-2 text-sm text-slate-400">{{ $product->description }}</p>
        <div class="mt-5 flex items-center justify-between"><span class="text-sm text-slate-500">{{ $product->denominations->count() }} pilihan nominal</span><span class="font-bold text-yellow-300">Pilih <span aria-hidden="true">→</span></span></div>
      </a>
    @empty <p class="text-slate-400">Belum ada produk tersedia.</p> @endforelse
  </div>
</section>
@endsection
