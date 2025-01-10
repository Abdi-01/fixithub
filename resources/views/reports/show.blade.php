<!-- 
This page for display problems detail and show solutions from others account.
The data structure example is like this :
	{
		"created": 1735555328497,
		"___class": "reports",
		"description": "Terjaid kerusakan jalan",
		"location": "yogyakarta",
		"title": "Kerusakan jembatan dayu",
		"mediafile": null,
		"category": "Transportasi",
		"ownerId": null,
		"updated": 1736146983468,
		"objectId": "9B6E25A8-862B-4082-BAC1-D1E32620AA14",
		"status": "PENDING"
	} 
-->
@extends('layouts.app')

@php
$reportObjectId = $report['objectId'];
@endphp
@section('content')
<div class="md:px-24">
    @if ($report)
    @section('title', $report['title'] . ' | FixIt Hub')

    <!-- Notifikasi -->
    <x-notif />
    <div class="flex gap-16">
        <div id="content-report" class="flex-1 max-h-screen overflow-y-scroll space-y-5 pr-5">
            <h1 class="text-3xl font-semibold">{{ $report['title'] ?? 'N/A' }} </h1>
            <div class="flex gap-8">
                <p><span class="text-gray-400">Published</span> {{ \Carbon\Carbon::parse($report['created'])->format('d/m/Y H:i:s') }}</p>
                <p><span class="text-gray-400">Location</span> {{ $report['location'] }}</p>
                <p><span class="text-gray-400">Category</span> {{ $report['category'] }}</p>
                <!-- <p><span class="text-gray-400">Status</span> <b>{{ $report['status'] }}</b></p> -->
            </div>
            <hr />
            <p>{!! $report['description'] ?? 'N/A' !!}</p>
            <hr />
            <div>
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Solutions</h3>
                    <x-solutions.modal-create-solution slugReportId="{{$report['objectId']}}" />
                </div>
                <div>
                    @forelse($report['solutionReportList'] as $solution)
                    <div>
                        <div class="p-4 md:p-6">
                            <div class="flex justify-between items-center">
                                <div class="mb-4 flex gap-2 items-center">
                                    <p><span class="text-gray-400">Created by</span> {{ $solution['ownerData']['email'] }}</p>
                                </div>
                                <div class="text-xs">
                                    <span class="uppercase font-medium me-2 px-2.5 py-0.5 rounded
            @if ($solution['status'] === 'Submitted') bg-yellow-100 text-yellow-800 
            @elseif ($solution['status'] === 'Selected') bg-blue-100 text-blue-800 
            @elseif ($solution['status'] === 'In Progress') bg-blue-300 text-blue-800 
            @elseif ($solution['status'] === 'Solved') bg-green-100 text-green-800 
            @else bg-gray-100 text-gray-800 @endif">
                                        {{ $solution['status'] }}
                                    </span>
                                </div>
                            </div>
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 ">{{ $solution['title'] }}</h5>
                            </a>
                            <p class="mb-3 text-gray-600">
                                {!! $solution['description'] ?? 'N/A' !!}
                            </p>
                        </div>
                    </div>
                    <hr />
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div id="content-track-status" class="w-fit space-y-5">
            @if(session('user') && session('user')['role'] == 'citizen' || $report['status'] != 'Pending')
            <h2 class="text-xl text-gray-500">Track Goverment Status</h2>
            <x-reports.track-status status="{{$report['status']}}" />
            @elseif($report['status'] == 'Pending')
            <h2 class="text-xl text-gray-500">Verifikasi masalah ini ?</h2>
            <button
                id="openModalBtn"
                class="w-full block sm:inline-block border border-green-400  text-green-500 px-4 py-1.5 rounded shadow hover:bg-gray-100"
                onclick="onVerifiedReport('{{ $reportObjectId }}')">
                Verifikasi
            </button>
            @endif
        </div>
    </div>
    <!-- Display other fields here -->
    @else
    <p>No report found.</p>
    @endif
</div>
<script>
    function onVerifiedReport(slugReportId) {
        console.log(slugReportId);

        fetch(`{{ route('report.verify', ':slug') }}`.replace(':slug', slugReportId), {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = "/reports"; // Redirect setelah berhasil
                } else {
                    console.error("Verifikasi laporan gagal");
                }
            })
            .catch(error => console.error("Error:", error));
    }
</script>
@endsection