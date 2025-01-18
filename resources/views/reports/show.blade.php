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
<div class="md:px-24">
    @if ($report)
    @section('title', $report['title'] . ' | FixIt Hub')
    @php
    $reportObjectId=$report['objectId']
    @endphp
    <!-- Notifikasi -->
    @include('components.notification')
    <div class="flex flex-col items-center md:items-start md:flex-row md:gap-16 space-y-5">
        <div id="content-report" class="flex-1 max-h-screen overflow-y-scroll space-y-5 md:pr-5">
            <div>
                <h1 class="text-3xl font-semibold">{{ $report['title'] ?? 'N/A' }} </h1>
                <div class="flex gap-2 items-center text-sm">
                    @if ($report['reportFor'])
                    <p class="text-sm text-gray-500"><span class="text-gray-400">Reference to</span> {{ $report['reportFor']['title'] }}</p>
                    <a href="/reports/{{ $report['reportFor']['objectId'] }}" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                        View reference
                        <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
            <div class="flex gap-4 text-[10px] md:text-lg">
                <p><span class="text-gray-400">Published</span> {{ \Carbon\Carbon::parse($report['created'])->format('d/m/Y H:i:s') }}</p>
                <p><span class="text-gray-400">Location</span> {{ $report['location'] }}</p>
                <p><span class="text-gray-400">Category</span> {{ $report['category'] }}</p>
                <!-- <p><span class="text-gray-400">Status</span> <b>{{ $report['status'] }}</b></p> -->
            </div>
            <hr />
            @if(!empty($report['mediafile']))
            <img src="{{ $report['mediafile'] }}" alt="Uploaded Image" class="max-w-full m-auto h-auto" />
            @endif
            <p>{!! $report['description'] ?? 'N/A' !!}</p>
            <!-- Discussions section only appear when report is verified or isn't Pending report  -->
            @if ($report['status'] != 'Pending')
            <hr />
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Solutions</h3>
                    @if(session('user') && session('user')['role'] == 'citizen' && $report['status'] != 'Solved')
                    <!-- @if(session('user') && $report['status'] !== 'Solved') -->
                    <x-solutions.modal-create-solution slugReportId="{{$report['objectId']}}" />
                    <!-- @endif -->
                    @endif
                </div>
                <div>
                    @forelse($report['solutionReportList'] as $solution)
                    <!-- define status with color code -->
                    @php
                    $solutionObjectId=$solution['objectId'];

                    $statusListClasses = [
                    'Submitted' => 'bg-yellow-100 text-yellow-800',
                    'Selected' => 'bg-blue-100 text-blue-800',
                    'In Progress' => 'bg-blue-300 text-blue-800',
                    'Completed' => 'bg-green-100 text-green-800',
                    'default' => 'bg-gray-100 text-gray-800',
                    ];
                    $statusBadgeClass = $statusListClasses[$solution['status']] ?? $statusListClasses['default'];

                    // Periksa apakah semua solusi berstatus "Submitted"
                    $allSolutionsSubmitted = collect($report['solutionReportList'])->every(fn($s) => $s['status'] === 'Submitted');

                    // Periksa apakah solusi saat ini adalah satu-satunya dengan status "Selected" atau "In Progress"
                    $isKeySolution = in_array($solution['status'], ['Selected', 'In Progress']);
                    @endphp
                    <div>
                        <div class="md:p-6">
                            <div class="flex justify-between items-center">
                                <div class="mb-4 flex gap-2 items-center flex-wrap text-xs md:text-base">
                                    <p><span class="text-gray-400">Created by</span> {{ $solution['ownerData']['email'] }}</p>
                                    <p><span class="text-gray-400">Category</span> {{ $solution['category'] }}</p>
                                </div>
                                <div class="flex items-center gap-2 text-[10px] md:text-xs">
                                    @if ( session('user')['role'] === 'goverment')
                                    <form
                                        action="{{ route('solution.update', ['reportIdSlug' => $report['objectId'], 'solutionIdSlug' => $solution['objectId']]) }}"
                                        method="POST"
                                        onchange="this.submit()">
                                        @csrf
                                        <select id="change-solution-status" name="change-solution-status"
                                            class="rounded-md bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 block w-full p-0.5"
                                            required>
                                            <option selected disabled>Pilih status solusi</option>
                                            <option value="Selected" {{ $solution['status'] == 'Selected' ? 'selected' : '' }}>Selected</option>
                                            <option value="In Progress" {{ $solution['status'] == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Completed" {{ $solution['status'] == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </form>
                                    @endif
                                    <span class="uppercase font-medium me-2 px-2.5 py-0.5 rounded {{ $statusBadgeClass }}">
                                        {{ $solution['status'] }}
                                    </span>
                                </div>
                            </div>
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 ">{{ $solution['title'] }}</h5>
                            </a>
                            @if(!empty($report['mediafile']))
                            <img src="{{ $solution['mediafile'] }}" alt="Uploaded Image" class="max-w-full m-auto h-auto" />
                            @endif
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
            @endif
        </div>
        <div id="content-track-status" class="w-fit space-y-3">
            @if(session('user') && session('user')['role'] == 'citizen' || $report['status'] != 'Pending')
            <h2 class="text-xl text-gray-500">Track Goverment Status</h2>
            <x-reports.track-status status="{{$report['status']}}" />
            @if(session('user') && (session('user')['objectId'] === $report['ownerData']['objectId'] || session('user')['role'] === 'goverment') && $report['status'] === 'Solved')
            <!-- Feedback Comment List -->
            <h2 class="text-xl text-gray-500">Tanggapan</h2>
            <div class="py-2 space-y-2 max-h-40 overflow-y-auto border border-gray-200 shadow">
                @forelse($report['feedbackRatingComment'] as $ratingComment)
                <p class="text-xs m-1 flex items-center">
                    <span class="text-gray-400">{{ $ratingComment['rating'] }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 .587l3.668 7.431L24 9.75l-6 5.847L19.336 24 12 20.201 4.664 24 6 15.597 0 9.75l8.332-1.732z" />
                    </svg>
                    <span>
                        {{ $ratingComment['comment'] }}
                    </span>
                </p>
                @empty
                <p class="text-xs text-gray-500">Tidak ada feedback tersedia.</p>
                @endforelse
            </div>
            <!-- Kondisi untuk Modal Report Feedback -->
            @php
            $userId = session('user')['objectId']; // Ambil ID pengguna yang login
            $hasGivenFeedback = collect($report['feedbackRatingComment'])
            ->contains(fn($feedback) => isset($feedback['ownerData']['objectId']) && $feedback['ownerData']['objectId'] === $userId);
            @endphp

            @unless($hasGivenFeedback)
            <x-reports.modal-report-feedback slugReportId="{{ $report['objectId'] }}" />
            @endunless

            <!-- Modal New Report -->

            <x-reports.modal-new-report-for slugReportId="{{$report['objectId']}}" />
            @endif
            @elseif(session('user') && session('user')['role'] == 'goverment' && $report['status'] == 'Pending')
            <h2 class="text-xl text-gray-500">Verifikasi masalah ini ?</h2>
            <button
                id="openModalBtn"
                class="w-full block sm:inline-block border border-green-400  text-green-500 px-4 py-1.5 rounded shadow hover:bg-gray-100"
                onclick="onVerifiedReport('{{ $reportObjectId }}')">
                Verifikasi
            </button>
            @endif
            <h2 class="text-xl text-gray-500">Diskusi</h2>
            <x-reports.discuss-box
                :reportId="$report['objectId']"
                :reportStatus="$report['status']"
                :discussionMessages="$report['discussionMessages']" />
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