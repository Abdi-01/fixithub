@php
$steps = [
'PENDING' => [
'label' => 'Pending',
'detail' => 'Masih akan menentukan solusinya',
],
'INPROGRESS' => [
'label' => 'In Progress',
'detail' => 'Solusi sudah dipilih dan akan diimplementasikan',
],
'VERIFIED' => [
'label' => 'Verified',
'detail' => 'Telah diterapkan',
],
];
@endphp

<ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">
    @foreach ($steps as $key => $step)
    @php
    $isActive = $status === $key || array_search($status, array_keys($steps)) > array_search($key, array_keys($steps));
    $isCurrent = $status === $key;
    $bgColor = $isActive ? ($key === 'PENDING' ? 'bg-yellow-200 dark:bg-yellow-900' : ($key === 'INPROGRESS' ? 'bg-blue-200 dark:bg-blue-900' : 'bg-green-200 dark:bg-green-900')) : 'bg-gray-100 dark:bg-gray-700';
    $iconColor = $isActive ? ($key === 'PENDING' ? 'text-yellow-500 dark:text-yellow-400' : ($key === 'INPROGRESS' ? 'text-blue-500 dark:text-blue-400' : 'text-green-500 dark:text-green-400')) : 'text-gray-500 dark:text-gray-400';
    @endphp

    <li class="mb-10 ms-6">
        <span class="absolute flex items-center justify-center w-8 h-8 {{ $bgColor }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
            @if ($isActive)
            <!-- Icon Check -->
            <svg class="w-3.5 h-3.5 {{ $iconColor }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
            </svg>
            @else
            <!-- Icon Stopwatch -->
            <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16ZM8 1.333A6.667 6.667 0 1 0 8 14.667 6.667 6.667 0 0 0 8 1.333Z" />
                <path d="M8 4a.667.667 0 0 1 .667.667v3.005l2.272 1.36a.667.667 0 1 1-.686 1.144L7.333 8.332V4.667A.667.667 0 0 1 8 4Z" />
            </svg>
            @endif
        </span>
        <h3 class="font-medium leading-tight {{ $isCurrent ? 'text-black dark:text-white' : '' }}">{{ $step['label'] }}</h3>
        <p class="text-sm">{{ $step['detail'] }}</p>
    </li>
    @endforeach
</ol>