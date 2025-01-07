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

@section('content')
<div class="px-24">
    @if ($report)
    @section('title', $report['title'] . ' | FixIt Hub')
    <div class="flex gap-16">
        <div class="flex-1 space-y-5">
            <h1 class="text-3xl font-semibold">{{ $report['title'] ?? 'N/A' }} </h1>
            <div class="flex gap-8">
                <p><span class="text-gray-400">Published</span> {{ \Carbon\Carbon::parse($report['created'])->format('d/m/Y H:i:s') }}</p>
                <p><span class="text-gray-400">Location</span> {{ $report['location'] }}</p>
                <p><span class="text-gray-400">Category</span> {{ $report['category'] }}</p>
                <!-- <p><span class="text-gray-400">Status</span> <b>{{ $report['status'] }}</b></p> -->
            </div>
            <hr />
            <p>{{ $report['description'] ?? 'N/A' }}</p>
            <hr />
            <div>
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Solutions</h3>
                    <x-reports.modal-create-solution />
                </div>
            </div>
        </div>
        <div class="w-fit space-y-5">
            <h2 class="text-xl text-gray-500">Track Goverment Status</h2>
            <x-reports.track-status status="{{$report['status']}}" />
        </div>
    </div>
    <!-- Display other fields here -->
    @else
    <p>No report found.</p>
    @endif
</div>
@endsection