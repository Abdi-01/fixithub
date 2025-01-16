@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <div class="flex gap-6">
        @if(session('user') && session('user')['role'] == 'citizen')
        <div class="flex-1 space-y-5">
            <h1 class="text-4xl text-center text-gray-900"><span class="text-gray-400 font-light">Selamat Datang
                    di</span>
                <span>FixIt<span class="font-bold">Hub</span></span>
            </h1>
            <x-reports.create-report />
        </div>
        @endif
        <div class="flex-1">
            <h1 class="text-2xl font-semibold mb-5 text-slate-500">Masalah Terbaru</h1>
            @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-5">
                {{ session('error') }}
            </div>
            @endif

            <div class="space-y-4">
                @forelse($reports as $report)
                <div class="bg-white border border-gray-200 rounded-lg shadow">
                    <div class="p-4 md:p-6">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-2 items-center">
                                <img src="https://avatar.iran.liara.run/public" class="w-10 h-10" />
                                <p class="text-gray-400">{{ $report['ownerData']['email'] }}</p>
                            </div>
                            <div class="text-xs">
                                <span class="uppercase bg-blue-100 text-blue-800 font-medium me-2 px-2.5 py-0.5 rounded">
                                    {{ $report['category'] }}
                                </span>
                                <span class="uppercase bg-gray-100 text-blue-800 font-medium me-2 px-2.5 py-0.5 rounded">
                                    {{ $report['location'] }}
                                </span>
                                <span class="uppercase font-medium me-2 px-2.5 py-0.5 rounded
            @if ($report['status'] === 'Pending') bg-yellow-100 text-yellow-800 
            @elseif ($report['status'] === 'Verified') bg-blue-100 text-blue-800 
            @elseif ($report['status'] === 'Solved') bg-green-100 text-green-800 
            @else bg-gray-100 text-gray-800 @endif">
                                    {{ $report['status'] }}
                                </span>
                            </div>
                        </div>
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 ">{{ $report['title'] }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-500  line-clamp-1">
                            {!! strip_tags($report['description']) !!}
                        </p>
                    </div>
                    <div class="px-4 py-2 md:px-6 md:py-4 bg-gray-100">
                        <a href="/reports/{{ $report['objectId'] }}" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                            View solutions
                            <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection