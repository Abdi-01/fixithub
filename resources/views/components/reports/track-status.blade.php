@php
$steps = [
'Pending' => [
'label' => 'Pending',
'detail' => 'Masih akan menentukan solusinya',
],
'Verified' => [
'label' => 'Verified',
'detail' => 'Solusi sudah dipilih dan akan diimplementasikan',
],
'Solved' => [
'label' => 'Solved',
'detail' => 'Telah diterapkan',
],
];
@endphp

<ol class="relative text-gray-500 border-s border-gray-200 ">
    @foreach ($steps as $key => $step)
    @php
    $isActive = $status === $key || array_search($status, array_keys($steps)) > array_search($key, array_keys($steps));
    $isCurrent = $status === $key;
    $bgColor = $isActive ? ($key === 'Pending' ? 'bg-yellow-200 ' : ($key === 'Verified' ? 'bg-blue-200 ' : 'bg-green-200 ')) : 'bg-gray-100 ';
    $iconColor = $isActive ? ($key === 'Pending' ? 'text-yellow-500 ' : ($key === 'Verified' ? 'text-blue-500 ' : 'text-green-500 ')) : 'text-gray-500 ';
    @endphp

    <li class="mb-10 ms-6">
        <span class="absolute flex items-center justify-center w-8 h-8 {{ $bgColor }} rounded-full -start-4 ring-4 ring-white ">
            @if ($isActive)
            <!-- Icon Check -->
            <svg class="w-3.5 h-3.5 {{ $iconColor }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
            </svg>
            @else
            <!-- Icon Stopwatch -->
            <svg class="w-3.5 h-3.5 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16ZM8 1.333A6.667 6.667 0 1 0 8 14.667 6.667 6.667 0 0 0 8 1.333Z" />
                <path d="M8 4a.667.667 0 0 1 .667.667v3.005l2.272 1.36a.667.667 0 1 1-.686 1.144L7.333 8.332V4.667A.667.667 0 0 1 8 4Z" />
            </svg>
            @endif
        </span>
        <h3 class="font-medium leading-tight {{ $isCurrent ? 'text-black ' : '' }}">{{ $step['label'] }}</h3>
        <p class="text-sm">{{ $step['detail'] }}</p>
    </li>
    @endforeach
</ol>