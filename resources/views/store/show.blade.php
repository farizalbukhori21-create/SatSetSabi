@extends('layouts.app')
@section('title',$product->name)
@section('content')
<a href="{{ route('home') }}" class="text-sm text-blue-300">← Kembali ke katalog</a>
<div class="mt-5 grid gap-8 lg:grid-cols-[1fr_1.2fr]">
  <div class="flex min-h-64 items-center justify-center rounded-3xl bg-gradient-to-br from-blue-800 to-slate-900"><span class="text-7xl font-black text-yellow-300">{{ strtoupper(substr($product->name,0,2)) }}</span></div>
  <div><p class="text-sm font-bold uppercase tracking-widest text-yellow-400">{{ $product->category->name }}</p><h1 class="mt-2 text-4xl font-black">{{ $product->name }}</h1><p class="mt-4 text-slate-400">{{ $product->description }}</p>
    <h2 class="mb-4 mt-8 text-xl font-bold">Pilih nominal</h2>
    <div class="grid gap-3 sm:grid-cols-2">
      @foreach($product->denominations as $item)
      <a href="{{ route('checkout',$item) }}" class="rounded-xl border border-slate-700 bg-slate-900 p-4 hover:border-yellow-400"><div class="font-bold">{{ $item->name }}</div><div class="mt-2 text-lg font-black text-yellow-300">Rp {{ number_format($item->price,0,',','.') }}</div></a>
      @endforeach
    </div>
  </div>
</div>
@endsection
