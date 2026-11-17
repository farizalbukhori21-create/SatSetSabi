
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">

    <h1 class="text-2xl font-bold mb-6">
        Daftar Pengguna SatSetSabi
    </h1>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4">No.</th>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Tanggal Daftar</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr class="border-t">
                        <td class="p-4">
                            {{ $users->firstItem() + $loop->index }}
                        </td>
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            {{ ucfirst($user->role) }}
                        </td>
                        <td class="p-4">
                            {{ $user->created_at->format('d-m-Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center">
                            Belum ada pengguna terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>
@endsection
