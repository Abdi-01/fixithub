@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Daftar Laporan</h1>

    @if(session('error'))
    <div class="bg-red-500 text-white p-3 rounded mb-5">
        {{ session('error') }}
    </div>
    @endif

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Judul</th>
                    <th scope="col" class="py-3 px-6">Deskripsi</th>
                    <th scope="col" class="py-3 px-6">Lokasi</th>
                    <th scope="col" class="py-3 px-6">Kategori</th>
                    <th scope="col" class="py-3 px-6">Instansi</th>
                    <th scope="col" class="py-3 px-6">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-4 px-6">{{ $report['title'] }}</td>
                    <td class="py-4 px-6">{{ $report['description'] }}</td>
                    <td class="py-4 px-6">{{ $report['location'] }}</td>
                    <td class="py-4 px-6">{{ $report['category'] }}</td>
                    <td class="py-4 px-6">{{ $report['department'] }}</td>
                    <td class="py-4 px-6">{{ \Carbon\Carbon::parse($report['created'])->format('d-m-Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-4 px-6 text-center">Tidak ada laporan tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection